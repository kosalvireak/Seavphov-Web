<?php


namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Discussion;
use App\Service\NotificationService;
use Exception;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function deleteComment(Request $request, $id)
    {
        try {
            $user = $request->attributes->get('user');

            $comment = Comment::findOrFail($id);

            
            $discussion = Discussion::findOrFail($comment->discussion_id);

            $discussion->comments = $discussion->comments - 1;
            $discussion->save();

            if ($comment->owner_id != $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'No permission',
                ], 403);
            }

            $comment->delete();
            return response()->json([
                'success' => true,
                'message' => 'Deleted comment Success',
            ], 200);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete comment!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
    public function voteCommentHelpful(Request $request, $commentId)
    {
        try {
            // comment owner ( receiver_id )
            // book owner ( sender_id )
            $user = $request->attributes->get('user');
            $comment = Comment::find($commentId);

            NotificationService::storeDiscussionNotification($user->id, $comment->owner_id, $comment->discussion_id, 'like your comment!');

            $comment->helpful_vote = $comment->helpful_vote + 1;
            $comment->save();
            return response()->json([
                'success' => true,
                'message' => 'Successfully like comment',
                'data' => $comment->getData(),
            ], 200);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot like comment!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }


    public function voteCommentNotHelpful(Request $request, $commentId)
    {
        try {
            // comment owner ( receiver_id )
            // book owner ( sender_id )
            $user = $request->attributes->get('user');
            $comment = Comment::find($commentId);
            NotificationService::storeDiscussionNotification($user->id, $comment->owner_id, $comment->discussion_id, 'dislike your comment!');

            $comment->not_helpful_vote = $comment->not_helpful_vote + 1;
            $comment->save();
            return response()->json([
                'success' => true,
                'message' => 'Successfully unlike',
                'data' => $comment->getData(),
            ], 200);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot unlike comment!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function fetchDiscussionComments(Request $request, $discussionId)
    {

        $userId = null;

        // Check if the user attribute exists and get the user ID
        if ($request->attributes->has('user')) {
            $userId = $request->attributes->get('user')->id;
        }

        $items = [];
        $comments = Comment::where('discussion_id', $discussionId)->get();

        foreach ($comments as $comment) {
            $items[] = $comment->getData($userId);
        }

        if (empty($items)) {
            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'No comments found',
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully fetched discussion comments',
            'data' => $items,
        ], 200);
    }

    public function createComment(Request $request)
    {
        try {
            $user = $request->attributes->get('user');

            $validatedData = $request->validate([
                'body' => 'required|string',
                'discussion_id' => 'required|int',
            ]);

            $discussion_id = $validatedData['discussion_id'];

            $comment = Comment::create([
                'body' => $validatedData['body'],
                'discussion_id' => $discussion_id,
                'owner_id' => $user->id,
                'helpful_vote' => 0,
                'not_helpful_vote' => 0,
            ]);

            $discussion = Discussion::findOrFail($discussion_id);

            $discussion->comments = $discussion->comments + 1;
            $discussion->save();

            // receiver_id is book owner_id
            NotificationService::storeDiscussionNotification($user->id, $discussion->owner_id, $discussion_id, 'comment on your discussion!');
            return response()->json([
                'success' => true,
                'message' => 'Successfully added a comment',
                'data' => $comment->getData(),
            ], 200);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot add comment!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}