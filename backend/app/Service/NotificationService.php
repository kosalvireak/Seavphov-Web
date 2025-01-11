<?php

namespace App\Service;

use App\Models\Notification;

class NotificationService
{
    public static function storeNotification($user_id, $receiver_id, $book_id,  $body)
    {
        if ($body == "saved your book!") {
            $existingNotification = Notification::where('user_id', $user_id)
                ->where('receiver_id', $receiver_id)
                ->where('book_id', $book_id)
                ->first();

            if ($existingNotification) {
                return;
            }
        }

        Notification::create([
            'user_id' => $user_id,
            'receiver_id' => $receiver_id,
            'book_id' => $book_id,
            'body' => $body
        ]);
    }
}