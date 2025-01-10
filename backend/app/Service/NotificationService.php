<?php

namespace App\Service;

use App\Models\Notification;

class NotificationService
{
    public static function storeNotification($user_id, $receiver_id, $book_id,  $body)
    {
         Notification::create([
            'user_id' => $user_id,
            'receiver_id' => $receiver_id,
            'book_id' => $book_id,
            'body' => $body
        ]);
    }
}