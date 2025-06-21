import Echo from "laravel-echo";
import { getApiToken } from "../cookie";
import store from "../../utils/store";

import Pusher from "pusher-js";
window.Pusher.logToConsole = true;

const echo = new Echo({
    broadcaster: "reverb",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    wsHost: import.meta.env.VITE_PUSHER_BACKEND_URL,
    wsPort: import.meta.env.VITE_PUSHER_PORT || 6001,
    wssPort: import.meta.env.VITE_PUSHER_PORT || 6001,
    forceTLS: false,
    encrypted: true,
    enableStats: true,
    enabledTransports: ["ws", "wss"], // Ensures only WebSocket is used
    // authEndpoint: import.meta.env.VITE_BACKEND_URL + "/api/broadcasting/auth", // Laravel backend URL
    // auth: {
    //     headers: {
    //         Authorization: `Bearer ${getApiToken()}`, // use Vuex or localStorage token
    //     }
    // }
});
window.Echo = echo;

