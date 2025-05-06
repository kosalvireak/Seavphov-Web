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
    enabledTransports: ['ws', 'wss'],
    // auth: {
    //     bearerToken: 'Vpz2U5ek7weu5dHz0lrxsSh7gVQZZuiNOEMaJHOIRX3vZ8eTmhojHMSasM4Y'
    // }
});

export default echo;