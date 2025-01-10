<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications(Request $request) {
        try{
            $user = $request->attributes->get('user');
            $notifications = $user->notifications->sortByDesc('created_at');
            $items = [];
            
            foreach ($notifications as $notification) {
                $user = User::Find($notification->user_id);
                 $items[]=[
                        'user_picture' =>  $user->picture,
                        'user_name' =>  $user->name,
                        'book_image' => Book::Find($notification->book_id)->images,
                        'body' => $notification->body,
                        'book_id' =>  $notification->book_id,
                        'date' => $notification->created_at,
                    ];
            }
            return response()->json([
                'success' => true,
                'data' =>  $items,
                'message' => 'Get notifications successfully',
            ], 200);
        }
        catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching notifications.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}