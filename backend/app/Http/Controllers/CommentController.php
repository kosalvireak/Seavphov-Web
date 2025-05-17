<?php


namespace App\Http\Controllers;

use App\Http\ResponseUtil;
use App\Models\Comment;
use App\Models\Discussion;
use App\Service\NotificationService;
use App\Service\ReactionService;
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
                return ResponseUtil::NoPermission();
            }

            $comment->delete();
            return ResponseUtil::Success('Deleted comment Success', true);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot delete comment!', $exception->getMessage());
        }
    }

    public function getMyComments(Request $request)
    {
        try {

            $user = $request->attributes->get('user');
            $items = [];
            $userComments = $user->comments;

            foreach ($userComments as $comment) {
                $items[] = [
                    'comment' => $comment->getData($user->id),
                    'discussion' => $comment->discussion
                ];
            };

            return ResponseUtil::Success('Successfully get your comments', $items);
        } catch (Exception $e) {
            return ResponseUtil::ServerError('Cannot get your comments!', $e->getMessage());
        }
    }


    public function likeComment(Request $request, $commentId)
    {
        try {
            $user = $request->attributes->get('user');
            $comment = Comment::find($commentId);

            // comment owner ( receiver_id )
            // book owner ( sender_id )
            NotificationService::storeDiscussionNotification($user->id, $comment->owner_id, $comment->discussion_id, 'like your comment!');

            return ReactionService::likeEntity($comment, $comment->id, $user->id, 'comment');
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot like comment!', $exception->getMessage());
        }
    }


    public function dislikeComment(Request $request, $commentId)
    {
        try {

            $user = $request->attributes->get('user');
            $comment = Comment::find($commentId);

            // comment owner ( receiver_id )
            // book owner ( sender_id )
            NotificationService::storeDiscussionNotification($user->id, $comment->owner_id, $comment->discussion_id, 'dislike your comment!');

            return ReactionService::dislikeEntity($comment, $comment->id, $user->id, 'comment');
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot dislike comment!', $exception->getMessage());
        }
    }


    /**
     * @OA\Get(
     *     path="/api/comment/discussion/{discussionId}",
     *     summary="Get specific discussion's comments by ID",
     *     tags={"Discussion's Comment"},*     
     *     @OA\Parameter(
     *         name="discussionId",
     *         in="path",
     *         required=true,
     *         description="Id of the discussion",
     *         @OA\Schema(type="integer", default=5)
     *     ),
     *     @OA\Response(response=200, description="Successfully get comments of this discussion"),
     *     @OA\Response(response=500, description="Cannot get comments of this discussion!")
     * )
     */
    public function getCommentsOfDiscussion(Request $request, $discussionId)
    {

        try {
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
                return ResponseUtil::Success('No comments found');
            }

            return ResponseUtil::Success('Successfully get comments of this discussion', $items);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot get comments of this discussion!', $exception->getMessage());
        }
    }

    public function editComment(Request $request, $id)
    {
        try {
            $user = $request->attributes->get('user');
            $comment = Comment::findOrFail($id);

            if ($comment->owner_id != $user->id) {
                return ResponseUtil::NoPermission();
            }

            $validatedData = $request->validate([
                'body' => 'required|string',
            ]);
            $body = $validatedData['body'];

            $comment->body = $body;
            $comment->save();

            return ResponseUtil::Success('Successfully edited comment', $body);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot edit comment!', $exception->getMessage());
        }
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
                'like' => 0,
                'dislike' => 0,
            ]);

            $discussion = Discussion::findOrFail($discussion_id);

            $discussion->comments = $discussion->comments + 1;
            $discussion->save();

            // receiver_id is book owner_id
            NotificationService::storeDiscussionNotification($user->id, $discussion->owner_id, $discussion_id, 'comment on your discussion!');

            return ResponseUtil::Success('Successfully add a comment', $comment->getData($user->id));
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot add comment!', $exception->getMessage());
        }
    }
}
