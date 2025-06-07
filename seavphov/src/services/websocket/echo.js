import Echo from "laravel-echo";

import Pusher from "pusher-js";
window.Pusher = Pusher;
window.Pusher.logToConsole = true;


const echo = new Echo({
  broadcaster: "reverb",
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  wsHost: import.meta.env.VITE_PUSHER_BACKEND_URL,
  wsPort: import.meta.env.VITE_PUSHER_PORT || 6001,
  wssPort: import.meta.env.VITE_PUSHER_PORT || 6001,
  forceTLS: false,
  enableStats: true,
  enabledTransports: ["ws", "wss"], // Ensures only WebSocket is used

});

export default echo;
