<?php


namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Service\NotificationService;
use Exception;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    
    public function likeDiscussion(Request $request, $discussionId)
    {
        try {
            $user = $request->attributes->get('user');
            $discussion = Discussion::find($discussionId);

            NotificationService::storeDiscussionNotification($user->id, $discussion->owner_id, $discussionId, 'like your discussion!');

            $discussion->helpful_vote = $discussion->helpful_vote + 1;
            $discussion->save();
            return response()->json([
                'success' => true,
                'message' => 'Successfully like discussion',
                'data' => $discussion->getData(),
            ], 200);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot like discussion!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function dislikeDiscussion(Request $request, $discussionId)
    {
        try {
             $user = $request->attributes->get('user');
            $discussion = Discussion::find($discussionId);

            NotificationService::storeDiscussionNotification($user->id, $discussion->owner_id, $discussionId, 'dislike your discussion!');

            $discussion->not_helpful_vote = $discussion->not_helpful_vote + 1;
            $discussion->save();
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot unlike discussion!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }


    public function fetchDiscussionById(Request $request,$id) {
        try{

            $userId = null;

            // Check if the user attribute exists and get the user ID
            if ($request->attributes->has('user')) {
                $userId = $request->attributes->get('user')->id;
            }
            $discussion = Discussion::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'message' => 'Successfully get discussion',
                'data' => $discussion->getData($userId)
            ], 200);
        }catch(Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot get discussion!',
                'error' => $exception->getMessage()
            ], 500);
        }
        
    }

    public function fetchDiscussions(Request $request)
    {
        try {

            $userId = null;

            // Check if the user attribute exists and get the user ID
            if ($request->attributes->has('user')) {
                $userId = $request->attributes->get('user')->id;
            }
            $discussions = Discussion::orderBy('created_at', 'desc')
                ->orderBy('helpful_vote', 'desc')
                ->get();

            $items = [];
            foreach ($discussions as $discussion) {
                $items[] = $discussion->getData($userId, true);
            }

            return response()->json([
                'success' => true,
                'message' => 'Successfully get discussions',
                'data' => $items
            ], 200);
        } catch (Exception $exception) {

            return response()->json([
                'success' => false,
                'message' => 'Cannot get discussion!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function createDiscussion(Request $request)
    {
        try {

            $user = $request->attributes->get('user');

            $validatedData = $request->validate([
                'body' => 'required|string',
                'image' => 'required|string',
            ]);

            $discussion = Discussion::create([
                'owner_id' => $user->id,
                'body' => $validatedData['body'],
                'image' => $validatedData['image'],
                'comments' => 0,
                'helpful_vote' => 0,
                'not_helpful_vote' => 0,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Successfully added a discussion',
                'data' => $discussion->getData(),
            ], 200);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot add discussion!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}