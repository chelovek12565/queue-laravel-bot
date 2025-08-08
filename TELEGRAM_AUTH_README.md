# Telegram ID Authentication for Laravel

This implementation provides a complete authentication system for Laravel using Telegram IDs (tgid). The system is designed to work with your existing User model in `App\Domain\User\Domain\Entities\User`.

## Features

- ✅ Telegram ID-based authentication
- ✅ Session-based authentication guard
- ✅ Automatic user creation/update on login
- ✅ Middleware protection for routes
- ✅ Helper trait for controllers
- ✅ API endpoints for login/logout/user info

## Setup

The authentication system has been configured with the following components:

### 1. Auth Configuration (`config/auth.php`)
- Added `telegram` guard using session driver
- Added `telegram_users` provider pointing to your User model

### 2. User Model (`app/Domain/User/Domain/Entities/User.php`)
- Extended `Authenticatable` class
- Implemented authentication interfaces
- Added helper methods: `findByTgid()`, `createOrUpdateByTgid()`

### 3. Authentication Service (`app/Services/TelegramAuthService.php`)
- Handles login/logout logic
- Manages user creation and updates
- Provides authentication checks

### 4. Authentication Controller (`app/Http/Api/Controllers/AuthController.php`)
- Login endpoint
- Logout endpoint
- User info endpoint
- Authentication check endpoint

### 5. Middleware (`app/Http/Middleware/TelegramAuth.php`)
- Protects routes requiring authentication
- Returns 401 for unauthenticated requests

### 6. Helper Trait (`app/Traits/HasTelegramAuth.php`)
- Provides easy access to authenticated user in controllers
- Helper methods for authentication checks

## API Endpoints

### Authentication Routes

```bash
# Login with Telegram ID
POST /api/auth/login
{
    "tgid": 123456789,
    "first_name": "John",
    "second_name": "Doe",
    "username": "johndoe"
}

# Logout (requires authentication)
POST /api/auth/logout

# Get current user info (requires authentication)
GET /api/auth/me

# Check if specific tgid is authenticated
POST /api/auth/check
{
    "tgid": 123456789
}
```

### Protected Routes

All these routes now require Telegram authentication:

```bash
# User routes
PUT /api/user/room/assign
PUT /api/user/room/remove
PUT /api/user/queue/assign
PUT /api/user/queue/remove

# Room routes
GET /api/room/{id}
POST /api/room
PUT /api/room/{id}
DELETE /api/room/{id}

# Queue routes
GET /api/queue/{id}
POST /api/queue
PUT /api/queue/{id}
DELETE /api/queue/{id}
```

## Usage Examples

### 1. Login User

```php
use App\Services\TelegramAuthService;

$authService = new TelegramAuthService();

$user = $authService->authenticateByTgid(123456789, [
    'first_name' => 'John',
    'second_name' => 'Doe',
    'username' => 'johndoe'
]);
```

### 2. In Controllers (using the trait)

```php
use App\Traits\HasTelegramAuth;

class MyController extends Controller
{
    use HasTelegramAuth;

    public function someMethod()
    {
        // Get authenticated user
        $user = $this->getTelegramUser();
        
        // Get Telegram ID
        $tgid = $this->getTelegramUserId();
        
        // Check if authenticated
        if ($this->isTelegramAuthenticated()) {
            // Do something
        }
        
        // Require authentication (throws 401 if not authenticated)
        $user = $this->requireTelegramAuth();
    }
}
```

### 3. Manual Authentication Check

```php
use Illuminate\Support\Facades\Auth;

// Check if user is authenticated
if (Auth::guard('telegram')->check()) {
    $user = Auth::guard('telegram')->user();
    echo "User: " . $user->first_name;
}

// Logout
Auth::guard('telegram')->logout();
```

### 4. Find User by Telegram ID

```php
use App\Domain\User\Domain\Entities\User;

$user = User::findByTgid(123456789);
```

## Database Requirements

Your `users` table should have these fields:
- `id` (primary key)
- `tgid` (unique Telegram ID)
- `first_name`
- `second_name`
- `username`
- `created_at`
- `updated_at`

## Security Notes

1. **Session-based**: This implementation uses Laravel's session-based authentication
2. **No passwords**: Telegram users don't have passwords, authentication is based on Telegram ID
3. **Automatic user creation**: Users are automatically created/updated when they login
4. **Unique tgid**: The `tgid` field should be unique in your database

## Testing the Authentication

### 1. Login
```bash
curl -X POST http://your-app.com/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "tgid": 123456789,
    "first_name": "John",
    "second_name": "Doe",
    "username": "johndoe"
  }'
```

### 2. Access Protected Route
```bash
curl -X PUT http://your-app.com/api/user/room/assign \
  -H "Content-Type: application/json" \
  -H "Cookie: laravel_session=your_session_cookie" \
  -d '{
    "room_id": 1
  }'
```

### 3. Get User Info
```bash
curl -X GET http://your-app.com/api/auth/me \
  -H "Cookie: laravel_session=your_session_cookie"
```

## Integration with Telegram Bot

When a user interacts with your Telegram bot, you can:

1. Extract their Telegram ID from the message
2. Call the login endpoint with their information
3. Store the session cookie for subsequent requests
4. Use the authenticated session for protected operations

This system provides a secure and convenient way to authenticate users using their Telegram IDs while maintaining session state for your API endpoints.
