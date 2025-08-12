import * as bootstrap from 'bootstrap';
import { markAuthInitialized, isAuthInitialized, ensureAuthInitialized } from './auth-utils';

// Initialize Telegram WebApp outside the function
const webApp = window.Telegram && window.Telegram.WebApp;

const BackButton = window.Telegram.WebApp.BackButton;

// Authentication class to handle all auth operations
class TelegramAuth {
    constructor() {
        this.baseUrl = '/api';
        this.isAuthenticated = false;
        this.currentUser = null;
        this.isInitializing = false; // Prevent multiple initialization attempts
    }

    /**
     * Login user with Telegram data
     * @param {Object} userData - Telegram user data
     * @returns {Promise}
     */
    async login(userData) {
        try {
            const response = await fetch(`${this.baseUrl}/auth/login`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'include', // Important for session cookies
                body: JSON.stringify(userData)
            });

            if (!response.ok) {
                throw new Error(`Login failed: ${response.status}`);
            }

            const data = await response.json();
            
            if (data.success) {
                this.isAuthenticated = true;
                this.currentUser = data.data.user;
                this.saveUserToStorage(data.data.user);
                this.dispatchAuthEvent('login', data.data.user);
                return data;
            } else {
                throw new Error(data.message || 'Login failed');
            }
        } catch (error) {
            console.error('Login error:', error);
            this.dispatchAuthEvent('loginError', error);
            throw error;
        }
    }

    /**
     * Get current authenticated user
     * @returns {Promise}
     */
    async getCurrentUser() {
        try {
            const response = await fetch(`${this.baseUrl}/auth/me`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'include'
            });

            if (!response.ok) {
                throw new Error(`Failed to get user: ${response.status}`);
            }

            const data = await response.json();
            
            if (data.success) {
                this.isAuthenticated = true;
                this.currentUser = data.data.user;
                this.saveUserToStorage(data.data.user);
                return data.data.user;
            } else {
                this.isAuthenticated = false;
                this.currentUser = null;
                return null;
            }
        } catch (error) {
            console.error('Get current user error:', error);
            this.isAuthenticated = false;
            this.currentUser = null;
            return null;
        }
    }

    /**
     * Check if user is authenticated
     * @returns {boolean}
     */
    checkAuth() {
        return this.isAuthenticated && this.currentUser !== null;
    }

    /**
     * Make authenticated API request
     * @param {string} endpoint - API endpoint
     * @param {Object} options - Fetch options
     * @returns {Promise}
     */
    async authenticatedRequest(endpoint, options = {}) {
        if (!this.checkAuth()) {
            throw new Error('User not authenticated');
        }

        const defaultOptions = {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'include'
        };

        const finalOptions = {
            ...defaultOptions,
            ...options,
            headers: {
                ...defaultOptions.headers,
                ...options.headers
            }
        };

        const response = await fetch(`${this.baseUrl}${endpoint}`, finalOptions);
        
        if (!response.ok) {
            if (response.status === 401) {
                // User is no longer authenticated
                this.isAuthenticated = false;
                this.currentUser = null;
                this.dispatchAuthEvent('sessionExpired');
            }
            throw new Error(`API request failed: ${response.status}`);
        }

        return response.json();
    }

    /**
     * Save user data to storage
     * @param {Object} user - User data
     */
    saveUserToStorage(user) {
        sessionStorage.setItem('telegramUser', JSON.stringify(user));
        sessionStorage.setItem('isAuthenticated', 'true');
        sessionStorage.setItem('authTimestamp', Date.now().toString());
    }

    /**
     * Load user data from storage
     * @returns {Object|null}
     */
    loadUserFromStorage() {
        const userData = sessionStorage.getItem('telegramUser');
        const isAuth = sessionStorage.getItem('isAuthenticated');
        const authTimestamp = sessionStorage.getItem('authTimestamp');
        
        if (userData && isAuth === 'true' && authTimestamp) {
            // Check if session is still valid (24 hours)
            const sessionAge = Date.now() - parseInt(authTimestamp);
            const maxSessionAge = 24 * 60 * 60 * 1000; // 24 hours
            
            if (sessionAge < maxSessionAge) {
                this.currentUser = JSON.parse(userData);
                this.isAuthenticated = true;
                return this.currentUser;
            } else {
                // Session expired, clear storage
                this.clearUserFromStorage();
            }
        }
        
        return null;
    }

    /**
     * Clear user data from storage
     */
    clearUserFromStorage() {
        sessionStorage.removeItem('telegramUser');
        sessionStorage.removeItem('isAuthenticated');
        sessionStorage.removeItem('authTimestamp');
    }

    /**
     * Dispatch authentication events
     * @param {string} eventType - Event type
     * @param {*} data - Event data
     */
    dispatchAuthEvent(eventType, data = null) {
        const event = new CustomEvent(`telegramAuth:${eventType}`, {
            detail: { auth: this, data }
        });
        document.dispatchEvent(event);
    }

    /**
     * Initialize authentication (only once per session)
     * @returns {Promise<Object|null>}
     */
    async initializeAuth() {
        // Check if already initialized globally
        if (isAuthInitialized()) {
            console.log('Authentication already initialized globally, skipping...');
            return this.currentUser;
        }

        // Prevent multiple initialization attempts
        if (this.isInitializing) {
            console.log('Authentication already initializing, skipping...');
            return null;
        }

        this.isInitializing = true;

        try {
            if (webApp && webApp.initDataUnsafe?.user) {
                const telegramUser = webApp.initDataUnsafe.user;
                const userData = {
                    tgid: telegramUser.id,
                    first_name: telegramUser.first_name,
                    second_name: telegramUser.last_name || '',
                    username: telegramUser.username || ''
                };

                console.log('Authenticating with Telegram data:', userData);
                const authResult = await this.login(userData);
                markAuthInitialized();
                this.dispatchAuthEvent('ready');
                return authResult;
            }

            console.log('No authentication method available');
            markAuthInitialized();
            this.dispatchAuthEvent('ready');
            return null;

        } catch (error) {
            console.error('Authentication initialization failed:', error);
            this.dispatchAuthEvent('initError', error);
            return null;
        } finally {
            this.isInitializing = false;
        }
    }
}

// Create global auth instance
window.telegramAuth = new TelegramAuth();

// Enhanced user data sending function (only for backward compatibility)
async function sendUserDataToApi() {
    // This function is now deprecated - use telegramAuth.initializeAuth() instead
    console.log('sendUserDataToApi is deprecated. Use telegramAuth.initializeAuth() instead.');
    
    if (webApp) {
        const user = webApp.initDataUnsafe?.user;

        if (user) {
            const userData = {
                tgid: user.id,
                first_name: user.first_name,
                second_name: user.last_name || '',
                username: user.username || ''
            };

            try {
                // Store user data (for backward compatibility)
                const storeResponse = await fetch('/api/user/store', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(userData)
                });

                if (storeResponse.ok) {
                    const storeData = await storeResponse.json();
                    sessionStorage.setItem('userId', storeData.data.id);
                }

                return storeData;
            } catch (error) {
                console.error('Error storing user data:', error);
                throw error;
            }
        } else {
            console.warn('No user data available in Telegram WebApp');
            return Promise.resolve(null);
        }
    } else {
        console.warn('Not running in a Telegram Mini App environment');
        return Promise.resolve(null);
    }
}

// Initialize app when DOM is ready (only once per session)
// Use sessionStorage to persist initialization state across page navigations
const isAppInitialized = sessionStorage.getItem('appInitialized') === 'true';

document.addEventListener('DOMContentLoaded', async () => {
    // Prevent multiple initializations
    if (isAppInitialized) {
        console.log('App already initialized, skipping...');
        return;
    }

    // Mark as initialized in sessionStorage
    sessionStorage.setItem('appInitialized', 'true');

    try {
        // Initialize authentication (only once)
        const userData = await window.telegramAuth.initializeAuth();

        // Handle back button
        if (window.location.search !== "" || window.location.pathname !== "/") {
            BackButton.show();
        } else {
            BackButton.hide();
        }

        BackButton.onClick(function() {
            window.history.back();
        });

        // Dispatch user ready event (for backward compatibility)
        const userReadyEvent = new CustomEvent('userReady', { detail: userData });
        document.dispatchEvent(userReadyEvent);

    } catch (error) {
        console.error('Error during app initialization:', error);
        
        // Dispatch error event
        const errorEvent = new CustomEvent('telegramAuth:initError', { 
            detail: { error } 
        });
        document.dispatchEvent(errorEvent);
    }
});

// Export for use in other modules
export { TelegramAuth };
