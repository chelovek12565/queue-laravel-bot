import './bootstrap';

// Initialize Telegram WebApp outside the function
const webApp = window.Telegram && window.Telegram.WebApp;

// Function to send user data to the API
function sendUserDataToApi() {
    console.info('pepepe');
    // Check if we're running in a Telegram Mini App
    if (webApp) {
        // Get user data from Telegram WebApp
        const user = webApp.initDataUnsafe?.user;

        if (user) {
            // Prepare the data to send
            const userData = {
                tgid: user.id,
                first_name: user.first_name,
                second_name: user.last_name || '', // last_name might be optional
                username: user.username || '' // username might be optional
            };

            console.log(userData);

            // Make the API request
            fetch('/api/user/store', {
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
                console.log('User data stored successfully:', data);
            })
            .catch(error => {
                console.error('Error storing user data:', error);
            });
        } else {
            console.warn('No user data available in Telegram WebApp');
        }
    } else {
        console.warn('Not running in a Telegram Mini App environment');
    }
}

// Call the function when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function () {
    sendUserDataToApi();
});

