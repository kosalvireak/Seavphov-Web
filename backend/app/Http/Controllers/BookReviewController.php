<?php


namespace App\Http\Controllers;

use App\Http\ResponseUtil;
use App\Models\Book;
use App\Models\BookReview;
use App\Service\NotificationService;
use App\Service\ReactionService;
use Exception;
use Illuminate\Http\Request;

class BookReviewController extends Controller
{

    public function deleteReview(Request $request, $id)
    {
        try {
            $user = $request->attributes->get('user');
            $review = BookReview::findOrFail($id);
            $bookOwnerId = Book::find($review->book_id)->owner_id;

            $isReviewOwner = $user->id == $review->user_id;
            $isBookOwner = $user->id == $bookOwnerId;

            if (!$isReviewOwner && !$isBookOwner) {
                return ResponseUtil::NoPermission();
            }

            $review->delete();
            return ResponseUtil::Success('Deleted Review Success', true);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot delete Review!', $exception->getMessage());
        }
    }
    public function likeReview(Request $request, $reviewId)
    {
        try {
            $user = $request->attributes->get('user');
            $review = BookReview::find($reviewId);

            // review owner ( receiver_id )
            // book owner ( sender_id )
            NotificationService::storeNotification($user->id, $review->user_id, $review->book_id, 'like your review!');

            return ReactionService::likeEntity($review, $review->id, $user->id, 'review');
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot like review!');
        }
    }
    public function dislikeReview(Request $request, $reviewId)
    {
        try {
            $user = $request->attributes->get('user');
            $review = BookReview::find($reviewId);

            // review owner ( receiver_id )
            // book owner ( sender_id )
            NotificationService::storeNotification($user->id, $review->user_id, $review->book_id, 'dislike your review');

            return ReactionService::dislikeEntity($review, $review->id, $user->id, 'review');
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot dislike review!', $exception->getMessage());
        }
    }


    public function getMyReviews(Request $request)
    {
        try {

            $user = $request->attributes->get('user');

            $items = [];
            $reviews = BookReview::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

            foreach ($reviews as $review) {
                $items[] = $review->getMyReview($user->id);
            }

            if (empty($items)) {
                return ResponseUtil::Success('No reviews found', []);
            }

            return ResponseUtil::Success('Successfully get your reviews', $items);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot get your review!', $exception->getMessage());
        }
    }


    /**
     * @OA\Get(
     *     path="/api/review/book/{bookId}",
     *     summary="Get book's review",
     *     tags={"Book's Review"},*     
     *     @OA\Parameter(
     *         name="bookId",
     *         in="path",
     *         required=true,
     *         description="Id of the book",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successfully get book reviews"),
     *     @OA\Response(response=500, description="Cannot get review of book!")
     * )
     */
    public function getReviewsOfBook(Request $request, $bookId)
    {
        try {

            $userId = null;

            // Check if the user attribute exists and get the user ID
            if ($request->attributes->has('user')) {
                $userId = $request->attributes->get('user')->id;
            }

            // get Book owner (allow book owner to remove review)
            $bookOwnerId = Book::find($bookId)->owner_id;

            $items = [];
            $reviews = BookReview::where('book_id', $bookId)->orderBy('created_at', 'desc')->get();

            foreach ($reviews as $review) {
                $items[] = $review->getData($userId, $bookOwnerId);
            }

            if (empty($items)) {
                return ResponseUtil::Success('No reviews found',);
            }

            return ResponseUtil::Success('Successfully get book reviews', $items);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot get review of book!', $exception->getMessage());
        }
    }


    public function editReview(Request $request, $id)
    {
        try {

            $user = $request->attributes->get('user');
            $review = BookReview::findOrFail($id);

            if ($review->user_id != $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'No permission',
                ], 403);
                return ResponseUtil::NoPermission();
            }

            $validatedData = $request->validate([
                'body' => 'required|string',
            ]);
            $body = $validatedData['body'];

            $review->body = $body;
            $review->save();

            return ResponseUtil::Success('Successfully edited review', $body);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot edit review!', $exception->getMessage());
        }
    }


    public function createReview(Request $request)
    {
        try {
            $user = $request->attributes->get('user');

            $validatedData = $request->validate([
                'body' => 'required|string',
                'book_id' => 'required|int',
            ]);

            $book_id = $validatedData['book_id'];

            $review = BookReview::create([
                'body' => $validatedData['body'],
                'book_id' => $book_id,
                'user_id' => $user->id,
                'like' => 0,
                'dislike' => 0,
            ]);

            $book = Book::findOrFail($book_id);

            // receiver_id is book owner_id
            NotificationService::storeNotification($user->id, $book->owner_id, $book_id, 'added a review!');

            return ResponseUtil::Success('Successfully add a review', $review->getData());
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot add review!', $exception->getMessage());
        }
    }
}
