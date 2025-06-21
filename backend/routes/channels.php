<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;


// when book, discussion, community is added a new channel is created and fe will show toast
Broadcast::channel('create-asset', function () {
    return true; // Allow all authenticated users (for testing)
});

// private channel for notification auth
Broadcast::channel('users.{uuid}', function ($user, $uuid) {
    return $user->uuid === $uuid;
});

Broadcast::routes(
    ['middleware' => ['auth:api']]
);
