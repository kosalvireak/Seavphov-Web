<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications(Request $request)
    {
        try {
            $user = $request->attributes->get('user');
            $notifications = $user->notifications->sortByDesc('created_at');
            $items = [];

            foreach ($notifications as $notification) {
                $user = User::find($notification->user_id);

                $items[] = [
                    'user_picture' =>  $user->picture,
                    'user_name' =>  $user->name,
                    'object_image' => $notification->getObjectImage(),
                    'body' => $notification->body,
                    'object_id' =>  $notification->getNotificationObjectId(),
                    'type' => $notification->type,
                    'date' => $notification->created_at,
                ];
            }
            return response()->json([
                'success' => true,
                'data' =>  $items,
                'message' => 'Get notifications successfully',
            ], 200);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching notifications.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}
