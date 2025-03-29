<?php


namespace App\Http\Controllers;

use App\Http\ResponseUtil;
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

            $discussion = Discussion::find($id);

            if (!$discussion) {
                return ResponseUtil::NotFound('Discussion not found');
            }

            if ($discussion->owner_id != $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'No permission',
                ], 403);
                return ResponseUtil::Unauthorized('No permission');
            }

            $discussion->delete();
            return ResponseUtil::Success('Delete discussion success');
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot delete discussion!', $exception->getMessage());
        }
    }

    public function likeDiscussion(Request $request, $id)
    {
        try {
            $user = $request->attributes->get('user');

            $discussion = Discussion::find($id);

            if (!$discussion) {
                return ResponseUtil::NotFound('Discussion not found');
            }

            // comment owner ( receiver_id )
            // book owner ( sender_id )
            NotificationService::storeDiscussionNotification($user->id, $discussion->owner_id, $id, 'like your discussion!');

            return ReactionService::likeEntity($discussion, $discussion->id, $user->id, 'discussion');
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot like discussion!', $exception->getMessage());
        }
    }

    public function dislikeDiscussion(Request $request, $discussionId)
    {
        try {
            $user = $request->attributes->get('user');

            $discussion = Discussion::find($discussionId);

            if (!$discussion) {
                return ResponseUtil::NotFound('Discussion not found');
            }

            // comment owner ( receiver_id )
            // book owner ( sender_id )
            NotificationService::storeDiscussionNotification($user->id, $discussion->owner_id, $discussionId, 'dislike your discussion!');

            return ReactionService::dislikeEntity($discussion, $discussion->id, $user->id, 'discussion');
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot dislike discussion!', $exception->getMessage());
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

            $discussion = Discussion::find($id);
            if (!$discussion) {
                return ResponseUtil::NotFound('Discussion not found');
            }

            return ResponseUtil::Success('Get discussion success', $discussion->getData($userId));
        } catch (Exception $exception) {
            return ResponseUtil::ServerError('Cannot get discussion!', $exception->getMessage());
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
                $items[] = $discussion->getData($userId, true); // userId = null => delete_able = false
            }

            return ResponseUtil::Success('Successfully get discussions', $items);
        } catch (Exception $exception) {
            return ResponseUtil::ServerError('Cannot get discussion!', $exception->getMessage());
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

            return ResponseUtil::Success('Successfully get your discussions', $items);
        } catch (Exception $exception) {
            return ResponseUtil::ServerError('Cannot get your discussion!', $exception->getMessage());
        }
    }

    public function editDiscussion(Request $request, $id)
    {
        try {
            $user = $request->attributes->get('user');

            $discussion = Discussion::findOrFail($id);

            if ($discussion->owner_id != $user->id) {
                return ResponseUtil::NoPermission();
            }

            $validatedData = $request->validate([
                'body' => 'required|string',
                'image' => 'string',
            ]);

            $discussion->body = $validatedData['body'];
            $discussion->image = $validatedData['image'];
            $discussion->save();

            return ResponseUtil::Success('Successfully edited discussion', $discussion->getData($user->id));
        } catch (Exception $exception) {
            return ResponseUtil::ServerError('Cannot edit discussion!', $exception->getMessage());
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


            return ResponseUtil::Success('Successfully added a discussion', $discussion->getData());
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot add discussion!', $exception->getMessage());
        }
    }
}
