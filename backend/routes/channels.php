<?php

use Illuminate\Support\Facades\Broadcast;

// chat is channel name
Broadcast::channel('chat', function () {
    return true; // Allow all authenticated users (for testing)
});
