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

    public static function storeRequestToJoinCopNotification($userId, $receiverId, $copId, $body)
    {
        if ($userId == $receiverId) {
            return;
        }
        Notification::create([
            'user_id' => $userId,
            'receiver_id' => $receiverId,
            'object_id' => $copId,
            'type' => 'request-to-join-cop',
            'body' => $body
        ]);
    }


    public static function storeJoinCopNotification($userId, $receiverId, $copId, $body)
    {
        if ($userId == $receiverId) {
            return;
        }
        Notification::create([
            'user_id' => $userId,
            'receiver_id' => $receiverId,
            'object_id' => $copId,
            'type' => 'join-cop',
            'body' => $body
        ]);
    }

    public static function storeRejectRequestToJoinCopNotification($userId, $receiverId, $copId, $body)
    {
        if ($userId == $receiverId) {
            return;
        }
        Notification::create([
            'user_id' => $userId,
            'receiver_id' => $receiverId,
            'object_id' => $copId,
            'type' => 'reject-cop-join-request',
            'body' => $body
        ]);
    }

    public static function storeApproveRequestToJoinCopNotification($userId, $receiverId, $copId, $body)
    {
        if ($userId == $receiverId) {
            return;
        }
        Notification::create([
            'user_id' => $userId,
            'receiver_id' => $receiverId,
            'object_id' => $copId,
            'type' => 'approve-cop-join-request',
            'body' => $body
        ]);
    }


    public static function storeJoinReadingChallengeNotification($userId, $receiverId, $copId, $body)
    {
        if ($userId == $receiverId) {
            return;
        }
        Notification::create([
            'user_id' => $userId,
            'receiver_id' => $receiverId,
            'object_id' => $copId,
            'type' => 'join-reading-challenge',
            'body' => $body
        ]);
    }
}
