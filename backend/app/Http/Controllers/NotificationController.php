<?php

namespace App\Http\Controllers;

use App\Http\ResponseUtil;
use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead(Request $request, $id)
    {
        try {
            $user = $request->attributes->get('user');
            $notification = Notification::where('id', $id)->first();

            if ($notification->receiver_id != $user->id) {
                return ResponseUtil::NoPermission('You do not have permission to delete this notification');
            }

            $notification->unread = true;
            $notification->save();

            return ResponseUtil::Success("Successfully mark as read");
        } catch (Exception $e) {
            return ResponseUtil::ServerError('Cannot read or unread notification', $e->getMessage());
        }
    }


    public function toggleRead(Request $request, $id)
    {
        try {
            $user = $request->attributes->get('user');
            $notification = Notification::where('id', $id)->first();

            if ($notification->receiver_id != $user->id) {
                return ResponseUtil::NoPermission('You do not have permission to delete this notification');
            }

            $notification->unread = !$notification->unread;
            $notification->save();

            $message = $notification->unread ? 'read' : 'unread';

            return ResponseUtil::Success('You mark as '  . $message);
        } catch (Exception $e) {
            return ResponseUtil::ServerError('Cannot read or unread notification', $e->getMessage());
        }
    }


    public function deleteNotification(Request $request, $id)
    {
        try {
            $user = $request->attributes->get('user');
            $notification = Notification::where('id', $id)->first();

            if ($notification->receiver_id != $user->id) {
                return ResponseUtil::NoPermission('You do not have permission to delete this notification');
            }

            $notification->delete();

            return ResponseUtil::Success('Successfully delete notification');
        } catch (Exception $e) {
            return ResponseUtil::ServerError('Cannot read or unread notification', $e->getMessage());
        }
    }

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
                    'id' => $notification->id,
                    'user_picture' => $notification->user->picture ?? null, // Handle cases where user might be null
                    'user_name' => $notification->user->name ?? 'Unknown',
                    'object_image' => $notification->getObjectImage(),
                    'body' => $notification->body,
                    'type' => $notification->type,
                    'date' => $notification->created_at->toDateTimeString(), // Format the date if needed
                    'url' => $notification->getNotificationUrl(),
                    'hasRead' => $notification->unread
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
