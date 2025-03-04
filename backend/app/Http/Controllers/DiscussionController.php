<?php


namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\User;
use App\Service\NotificationService;
use App\Service\ReactionService;
use Exception;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{


    public function deleteDiscussion(Request $request, $id)
    {
        try {
            $user = $request->attributes->get('user');

            $comment = Discussion::findOrFail($id);

            if ($comment->owner_id != $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'No permission',
                ], 403);
            }

            $comment->delete();
            return response()->json([
                'success' => true,
                'message' => 'Delete discussion Success',
            ], 200);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete discussion!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function likeDiscussion(Request $request, $discussionId)
    {
        try {
            $user = $request->attributes->get('user');
            $discussion = Discussion::find($discussionId);

            // comment owner ( receiver_id )
            // book owner ( sender_id )
            NotificationService::storeDiscussionNotification($user->id, $discussion->owner_id, $discussionId, 'like your discussion!');

            return ReactionService::likeEntity($discussion, $discussion->id, $user->id, 'discussion');
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

            // comment owner ( receiver_id )
            // book owner ( sender_id )
            NotificationService::storeDiscussionNotification($user->id, $discussion->owner_id, $discussionId, 'dislike your discussion!');

            return ReactionService::dislikeEntity($discussion, $discussion->id, $user->id, 'discussion');
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot dislike discussion!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }


    public function fetchDiscussionById(Request $request, $id)
    {
        try {



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
        } catch (Exception $exception) {
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
            $title = $request->get('title');
            $uuid = $request->get('uuid');

            $userId = null;

            // Check if the user attribute exists and get the user ID
            if ($request->attributes->has('user')) {
                $userId = $request->attributes->get('user')->id;
            }

            $query = Discussion::query();

            if (!empty($title)) {
                $query->where('body', 'like', '%' . $title . '%');
            }

            if ($uuid) {
                $user = User::where('uuid', $uuid)->first();
                $query->where('owner_id', $user->id); // Filter by uuid
            }

            $discussions = $query
                ->orderBy('created_at', 'desc')
                ->orderBy('like', 'desc')
                ->get();

            $items = [];
            foreach ($discussions as $discussion) {
                $items[] = $discussion->getData(null, true); // userId = null => delete_able = false
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

    public function fetchMyDiscussions(Request $request)
    {
        try {
            $user = $request->attributes->get('user');

            $discussions = Discussion::where('owner_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            $items = [];
            foreach ($discussions as $discussion) {
                $items[] = $discussion->getData($user->id, true);
            }

            return response()->json([
                'success' => true,
                'message' => 'Successfully get your discussions',
                'data' => $items
            ], 200);
        } catch (Exception $exception) {

            return response()->json([
                'success' => false,
                'message' => 'Cannot get your discussions!',
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
                'like' => 0,
                'dislike' => 0,
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
