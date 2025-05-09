import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

const echo = new Echo({
    broadcaster: 'reverb',
    key: "pqxvzvc3mgtizpwfeect",
    wsHost: "localhost",
    wsPort: 8080,
    wssPort: 443,
    forceTLS: false,
    disableStats: true,
    authEndpoint: 'http://localhost:8000/api/broadcasting/auth',
    enabledTransports: ['ws', 'wss'],
    auth: {
        headers: {
            Authorization: `Bearer Vpz2U5ek7weu5dHz0lrxsSh7gVQZZuiNOEMaJHOIRX3vZ8eTmhojHMSasM4Y`, // <-- pass token from your app
        },
    },
});

export default echo;