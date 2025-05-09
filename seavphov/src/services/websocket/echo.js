import Echo from "laravel-echo";

import Pusher from "pusher-js";
import {getApiToken} from "../cookie.js";
window.Pusher = Pusher;

const echo = new Echo({
  broadcaster: "reverb",
  key: "pqxvzvc3mgtizpwfeect",
  wsHost: import.meta.env.VITE_BACKEND_URL,
  wsPort: 8080,
  wssPort: 443,
  forceTLS: false,
  disableStats: true,
  authEndpoint: import.meta.env.VITE_BACKEND_URL + "/api/broadcasting/auth",
  enabledTransports: ["ws", "wss"],
  auth: {
    headers: {
      Authorization: `Bearer ${getApiToken()}`, // <-- pass token from your app
    },
  },
});

export default echo;
