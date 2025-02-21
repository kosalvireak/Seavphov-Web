<?php

namespace App\Service;

use App\Models\Notification;

class NotificationService
{
    public static function storeNotification($user_id, $receiver_id, $book_id,  $body)
    {
        if ($user_id == $receiver_id) {
            return;
        }
        Notification::create([
            'user_id' => $user_id,
            'receiver_id' => $receiver_id,
            'object_id' => $book_id,
            'type' => 'book',
            'body' => $body
        ]);
    }

    public static function storeDiscussionNotification($user_id, $receiver_id, $discussion_id,  $body)
    {
        if ($user_id == $receiver_id) {
            return;
        }
        Notification::create([
            'user_id' => $user_id,
            'receiver_id' => $receiver_id,
            'object_id' => $discussion_id,
            'type' => 'discussion',
            'body' => $body
        ]);
    }
}
