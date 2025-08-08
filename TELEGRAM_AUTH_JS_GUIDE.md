# Telegram Authentication JavaScript Guide

This guide explains how to use the Telegram authentication system in your JavaScript code.

## 🚀 **Quick Start**

The authentication system is automatically initialized when your app loads. The global `window.telegramAuth` instance provides all authentication functionality.

## 📋 **Available Methods**

### **1. Login**
```javascript
// Login with Telegram user data
const userData = {
    tgid: 123456789,
    first_name: 'John',
    second_name: 'Doe',
    username: 'johndoe'
};

try {
    const result = await window.telegramAuth.login(userData);
    console.log('Login successful:', result);
} catch (error) {
    console.error('Login failed:', error);
}
```

### **2. Logout**
```javascript
try {
    await window.telegramAuth.logout();
    console.log('Logout successful');
} catch (error) {
    console.error('Logout failed:', error);
}
```

### **3. Get Current User**
```javascript
try {
    const user = await window.telegramAuth.getCurrentUser();
    if (user) {
        console.log('Current user:', user);
        // user.id, user.tgid, user.first_name, etc.
    } else {
        console.log('No authenticated user');
    }
} catch (error) {
    console.error('Get user failed:', error);
}
```

### **4. Check Authentication Status**
```javascript
const isAuthenticated = window.telegramAuth.checkAuth();
console.log('Is authenticated:', isAuthenticated);
```

### **5. Make Authenticated API Requests**
```javascript
try {
    // Assign to room
    const result = await window.telegramAuth.authenticatedRequest('/user/room/assign', {
        method: 'PUT',
        body: JSON.stringify({ room_id: 1 })
    });
    console.log('Room assignment result:', result);
} catch (error) {
    console.error('API request failed:', error);
}
```

## 🎯 **Event System**

The authentication system dispatches events that you can listen to:

### **Available Events**
- `telegramAuth:ready` - Authentication system is ready
- `telegramAuth:login` - User logged in successfully
- `telegramAuth:logout` - User logged out
- `telegramAuth:sessionExpired` - Session expired
- `telegramAuth:loginError` - Login failed
- `telegramAuth:logoutError` - Logout failed
- `telegramAuth:initError` - Initialization failed

### **Event Listeners**
```javascript
// Listen for successful login
document.addEventListener('telegramAuth:login', (event) => {
    const user = event.detail.data;
    console.log('User logged in:', user);
    // Update UI, redirect, etc.
});

// Listen for logout
document.addEventListener('telegramAuth:logout', () => {
    console.log('User logged out');
    // Clear UI, redirect to login, etc.
});

// Listen for session expiration
document.addEventListener('telegramAuth:sessionExpired', () => {
    console.log('Session expired');
    // Prompt user to login again
});

// Listen for system ready
document.addEventListener('telegramAuth:ready', (event) => {
    const auth = event.detail.auth;
    console.log('Auth system ready');
    
    if (auth.checkAuth()) {
        console.log('User is already authenticated');
    }
});
```

## 🔧 **Integration with Telegram WebApp**

### **Automatic Authentication**
The system automatically authenticates users when the app loads using Telegram WebApp data:

```javascript
// This happens automatically in app.js
const webApp = window.Telegram && window.Telegram.WebApp;
if (webApp && webApp.initDataUnsafe?.user) {
    const user = webApp.initDataUnsafe.user;
    // User is automatically authenticated with this data
}
```

### **Manual Authentication**
If you need to authenticate manually:

```javascript
// Get user data from Telegram WebApp
const webApp = window.Telegram && window.Telegram.WebApp;
if (webApp && webApp.initDataUnsafe?.user) {
    const telegramUser = webApp.initDataUnsafe.user;
    
    const userData = {
        tgid: telegramUser.id,
        first_name: telegramUser.first_name,
        second_name: telegramUser.last_name || '',
        username: telegramUser.username || ''
    };
    
    try {
        await window.telegramAuth.login(userData);
        console.log('Manual authentication successful');
    } catch (error) {
        console.error('Manual authentication failed:', error);
    }
}
```

## 📱 **Usage in Components**

### **React Component Example**
```jsx
import React, { useState, useEffect } from 'react';

function UserProfile() {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        // Listen for authentication events
        const handleLogin = (event) => {
            setUser(event.detail.data);
            setLoading(false);
        };

        const handleLogout = () => {
            setUser(null);
            setLoading(false);
        };

        document.addEventListener('telegramAuth:login', handleLogin);
        document.addEventListener('telegramAuth:logout', handleLogout);

        // Check if user is already authenticated
        const checkAuth = async () => {
            try {
                const currentUser = await window.telegramAuth.getCurrentUser();
                setUser(currentUser);
            } catch (error) {
                console.error('Auth check failed:', error);
            } finally {
                setLoading(false);
            }
        };

        checkAuth();

        return () => {
            document.removeEventListener('telegramAuth:login', handleLogin);
            document.removeEventListener('telegramAuth:logout', handleLogout);
        };
    }, []);

    if (loading) {
        return <div>Loading...</div>;
    }

    if (!user) {
        return <div>Please login</div>;
    }

    return (
        <div>
            <h2>Welcome, {user.first_name}!</h2>
            <p>Telegram ID: {user.tgid}</p>
            <button onClick={() => window.telegramAuth.logout()}>
                Logout
            </button>
        </div>
    );
}
```

### **Vue Component Example**
```vue
<template>
    <div>
        <div v-if="loading">Loading...</div>
        <div v-else-if="!user">Please login</div>
        <div v-else>
            <h2>Welcome, {{ user.first_name }}!</h2>
            <p>Telegram ID: {{ user.tgid }}</p>
            <button @click="logout">Logout</button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: null,
            loading: true
        };
    },
    async mounted() {
        // Listen for auth events
        document.addEventListener('telegramAuth:login', this.handleLogin);
        document.addEventListener('telegramAuth:logout', this.handleLogout);

        // Check current auth status
        try {
            this.user = await window.telegramAuth.getCurrentUser();
        } catch (error) {
            console.error('Auth check failed:', error);
        } finally {
            this.loading = false;
        }
    },
    beforeUnmount() {
        document.removeEventListener('telegramAuth:login', this.handleLogin);
        document.removeEventListener('telegramAuth:logout', this.handleLogout);
    },
    methods: {
        handleLogin(event) {
            this.user = event.detail.data;
            this.loading = false;
        },
        handleLogout() {
            this.user = null;
            this.loading = false;
        },
        async logout() {
            try {
                await window.telegramAuth.logout();
            } catch (error) {
                console.error('Logout failed:', error);
            }
        }
    }
};
</script>
```

## 🔒 **Security Features**

### **Session Management**
- Sessions are automatically managed using Laravel's session system
- Session cookies are included in all requests
- Sessions expire based on Laravel configuration

### **Error Handling**
```javascript
try {
    const result = await window.telegramAuth.authenticatedRequest('/api/protected-endpoint');
    console.log('Success:', result);
} catch (error) {
    if (error.message.includes('401')) {
        // User is not authenticated
        console.log('Please login first');
    } else {
        // Other error
        console.error('Request failed:', error);
    }
}
```

### **Automatic Session Recovery**
The system automatically tries to recover sessions:
```javascript
// If session exists, user is automatically authenticated
const user = await window.telegramAuth.getCurrentUser();
if (user) {
    console.log('Session recovered:', user);
}
```

## 🧪 **Testing**

### **Test Authentication Flow**
```javascript
// Test login
const testUser = {
    tgid: 123456789,
    first_name: 'Test',
    second_name: 'User',
    username: 'testuser'
};

try {
    await window.telegramAuth.login(testUser);
    console.log('Test login successful');
    
    // Test authenticated request
    const result = await window.telegramAuth.authenticatedRequest('/auth/me');
    console.log('Test API call successful:', result);
    
    // Test logout
    await window.telegramAuth.logout();
    console.log('Test logout successful');
} catch (error) {
    console.error('Test failed:', error);
}
```

### **Check Authentication Status**
```javascript
// Check if user is authenticated
const isAuth = window.telegramAuth.checkAuth();
console.log('Authentication status:', isAuth);

// Get current user
const user = await window.telegramAuth.getCurrentUser();
console.log('Current user:', user);
```

## 📝 **Best Practices**

1. **Always handle errors** when making authentication calls
2. **Listen for events** to update your UI appropriately
3. **Check authentication status** before making protected requests
4. **Use the authenticatedRequest method** for API calls that require authentication
5. **Handle session expiration** gracefully
6. **Store user data locally** for offline functionality

## 🔄 **Migration from Old System**

If you're migrating from the old user storage system:

```javascript
// Old way
const userId = sessionStorage.getItem('userId');

// New way
const user = await window.telegramAuth.getCurrentUser();
const userId = user ? user.id : null;
```

The new system provides better security, session management, and error handling while maintaining backward compatibility.
