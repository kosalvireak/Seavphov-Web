<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\ResponseUtil;
use App\Models\Book;
use App\Models\Notification;
use App\Models\User;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function getNotifications(Request $request)
    {
        try {

            $user = $request->attributes->get('user');

            $query = Notification::with(['user', 'receiver']) // Assuming there's a relationship 'user' in the Notification model
                ->where('receiver_id', $user->id)
                ->orderBy('created_at', 'desc');

            $notifications = $query->paginate(6);

            // Transform the notifications into the desired format
            $items = $notifications->map(function ($notification) {
                return [
                    'user_picture' => $notification->user->picture ?? null, // Handle cases where user might be null
                    'user_name' => $notification->user->name ?? 'Unknown',
                    'object_image' => $notification->getObjectImage(),
                    'body' => $notification->body,
                    'type' => $notification->type,
                    'date' => $notification->created_at->toDateTimeString(), // Format the date if needed
                    'url' => $notification->getNotificationUrl()
                ];
            });

            return ResponseUtil::Success('Get notifications successfully', [
                'items' => $items,
                'pagination' => [
                    'total' => $notifications->total(),
                    'current_page' => $notifications->currentPage(),
                    'last_page' => $notifications->lastPage(),
                ],
            ],);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot get notifications!', $exception->getMessage());
        }
    }
}
