<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::routes([
    'middleware' => [\App\Http\Middleware\BroadcastTokenAuth::class],
]);

// chat is channel name
Broadcast::channel('notification', function ($user, $id) {
    return true; // Allow all authenticated users (for testing)
});
