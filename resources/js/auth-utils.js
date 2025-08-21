/**
 * Authentication Utilities
 * Helper functions to manage authentication state and prevent duplicate initialization
 */

// Global flag to track if authentication has been initialized
window.__telegramAuthInitialized = window.__telegramAuthInitialized || false;

/**
 * Check if authentication is already initialized
 * @returns {boolean}
 */
export function isAuthInitialized() {
    return window.__telegramAuthInitialized;
}

/**
 * Mark authentication as initialized
 */
export function markAuthInitialized() {
    window.__telegramAuthInitialized = true;
}

/**
 * Reset authentication initialization flag (useful for testing)
 */
export function resetAuthInitialization() {
    window.__telegramAuthInitialized = false;
}

/**
 * Get authentication status without triggering initialization
 * @returns {Object} Auth status object
 */
export function getAuthStatus() {
    const auth = window.telegramAuth;
    if (!auth) {
        return {
            initialized: false,
            authenticated: false,
            user: null
        };
    }

    return {
        initialized: true,
        authenticated: auth.checkAuth(),
        user: auth.currentUser
    };
}

/**
 * Wait for authentication to be ready
 * @param {number} timeout - Timeout in milliseconds (default: 5000)
 * @returns {Promise<Object>} Auth status when ready
 */
export function waitForAuth(timeout = 5000) {
    return new Promise((resolve, reject) => {
        const auth = window.telegramAuth;
        
        if (!auth) {
            reject(new Error('TelegramAuth not available'));
            return;
        }

        // If already authenticated, resolve immediately
        if (auth.checkAuth()) {
            resolve({
                authenticated: true,
                user: auth.currentUser
            });
            return;
        }

        // Set up timeout
        const timeoutId = setTimeout(() => {
            reject(new Error('Authentication timeout'));
        }, timeout);

        // Listen for auth events
        const handleReady = (event) => {
            clearTimeout(timeoutId);
            document.removeEventListener('telegramAuth:ready', handleReady);
            document.removeEventListener('telegramAuth:initError', handleError);
            
            const auth = event.detail.auth;
            resolve({
                authenticated: auth.checkAuth(),
                user: auth.currentUser
            });
        };

        const handleError = (event) => {
            clearTimeout(timeoutId);
            document.removeEventListener('telegramAuth:ready', handleReady);
            document.removeEventListener('telegramAuth:initError', handleError);
            
            reject(event.detail.error);
        };

        document.addEventListener('telegramAuth:ready', handleReady);
        document.addEventListener('telegramAuth:initError', handleError);
    });
}

/**
 * Ensure authentication is initialized (safe to call multiple times)
 * @returns {Promise<Object>} Auth status
 */
export async function ensureAuthInitialized() {
    if (isAuthInitialized()) {
        return getAuthStatus();
    }

    const auth = window.telegramAuth;
    if (!auth) {
        throw new Error('TelegramAuth not available');
    }

    try {
        await auth.initializeAuth();
        markAuthInitialized();
        return getAuthStatus();
    } catch (error) {
        throw error;
    }
}

/**
 * Check if user is authenticated (without triggering initialization)
 * @returns {boolean}
 */
export function isAuthenticated() {
    const auth = window.telegramAuth;
    return auth ? auth.checkAuth() : false;
}

/**
 * Get current user (without triggering initialization)
 * @returns {Object|null}
 */
export function getCurrentUser() {
    const auth = window.telegramAuth;
    return auth ? auth.currentUser : null;
}

/**
 * Make authenticated API request with automatic initialization
 * @param {string} endpoint - API endpoint
 * @param {Object} options - Fetch options
 * @returns {Promise}
 */
export async function authenticatedRequest(endpoint, options = {}) {
    const auth = window.telegramAuth;
    if (!auth) {
        throw new Error('TelegramAuth not available');
    }

    // Ensure authentication is initialized
    await ensureAuthInitialized();

    // Make the request
    return auth.authenticatedRequest(endpoint, options);
}

/**
 * Login with user data (with duplicate prevention)
 * @param {Object} userData - User data
 * @returns {Promise}
 */
export async function login(userData) {
    const auth = window.telegramAuth;
    if (!auth) {
        throw new Error('TelegramAuth not available');
    }

    // Check if already authenticated with same user
    if (auth.checkAuth() && auth.currentUser && auth.currentUser.tgid === userData.tgid) {
        console.log('User already authenticated with same Telegram ID');
        return { success: true, data: auth.currentUser };
    }

    return auth.login(userData);
}

/**
 * Logout current user
 * @returns {Promise}
 */
export async function logout() {
    const auth = window.telegramAuth;
    if (!auth) {
        throw new Error('TelegramAuth not available');
    }

    return auth.logout();
}
