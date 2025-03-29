<?php


namespace App\Http\Controllers;

use App\Http\ResponseUtil;
use App\Models\Book;
use App\Models\BookReview;
use App\Service\NotificationService;
use App\Service\ReactionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BookReviewController extends Controller
{

    public function deleteReview(Request $request, $id)
    {
        try {
            $user = $request->attributes->get('user');

            $review = BookReview::findOrFail($id);

            if ($review->user_id != $user->id) {
                return ResponseUtil::NoPermission();
            }

            $review->delete();
            return ResponseUtil::Success('Deleted Review Success');
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot delete Review!');
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


    public function fetchMyReviews(Request $request)
    {
        $user = $request->attributes->get('user');

        $items = [];
        $reviews = BookReview::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        foreach ($reviews as $review) {
            $items[] = $review->getMyReview($user->id);
        }

        if (empty($items)) {
            return ResponseUtil::Success('No reviews found',);
        }

        return ResponseUtil::Success('Successfully get your reviews', $items);
    }


    public function fetchBookReviews(Request $request, $bookId)
    {

        $userId = null;

        // Check if the user attribute exists and get the user ID
        if ($request->attributes->has('user')) {
            $userId = $request->attributes->get('user')->id;
        }

        $items = [];
        $reviews = BookReview::where('book_id', $bookId)->orderBy('created_at', 'desc')->get();

        foreach ($reviews as $review) {
            $items[] = $review->getData($userId);
        }

        if (empty($items)) {
            return ResponseUtil::Success('No reviews found',);
        }

        return ResponseUtil::Success('Successfully get book reviews', $items);
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
