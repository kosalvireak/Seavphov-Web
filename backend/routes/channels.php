<?php

use Illuminate\Support\Facades\Broadcast;

// Broadcast::routes([
//     'middleware' => [\App\Http\Middleware\BroadcastTokenAuth::class],
// ]);

// chat is channel name
Broadcast::channel('public-messages', function () {
    return true; // Allow all authenticated users (for testing)
});
