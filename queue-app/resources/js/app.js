import './bootstrap';

// Initialize Telegram WebApp outside the function
const webApp = window.Telegram && window.Telegram.WebApp;

function sendUserDataToApi() {
    if (webApp) {
        const user = webApp.initDataUnsafe?.user;

        if (user) {
            const userData = {
                tgid: user.id,
                first_name: user.first_name,
                second_name: user.last_name || '',
                username: user.username || ''
            };

            return fetch('/api/user/store', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(userData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                return data; // returned to the caller
            })
            .catch(error => {
                console.error('Error storing user data:', error);
                throw error; // propagate error to the caller
            });
        } else {
            console.warn('No user data available in Telegram WebApp');
            return Promise.resolve(null);
        }
    } else {
        console.warn('Not running in a Telegram Mini App environment');
        return Promise.resolve(null);
    }
}


document.addEventListener('DOMContentLoaded', () => {
    sendUserDataToApi().then(userData => {
        const userReadyEvent = new CustomEvent('userReady', {detail: userData});
        document.dispatchEvent(userReadyEvent);
    });
});
