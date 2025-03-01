<?php


namespace App\Http\Controllers;

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

            if ($review->user_id != $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'No permission',
                ], 403);
            }

            $review->delete();
            return response()->json([
                'success' => true,
                'message' => 'Deleted Review Success',
            ], 200);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete Review!',
                'error' => $exception->getMessage()
            ], 500);
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
            return response()->json([
                'success' => false,
                'message' => 'Cannot like review!',
                'error' => $exception->getMessage()
            ], 500);
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
            return response()->json([
                'success' => false,
                'message' => 'Cannot dislike review!',
                'error' => $exception->getMessage()
            ], 500);
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
            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'No reviews found',
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully fetched your reviews',
            'data' => $items,
        ], 200);
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
            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'No reviews found',
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Successfully fetched book reviews',
            'data' => $items,
        ], 200);
    }


    public function editReview(Request $request, $id)
    {
        $user = $request->attributes->get('user');
        $review = BookReview::findOrFail($id);

        if ($review->user_id != $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'No permission',
            ], 403);
        }

        $validatedData = $request->validate([
            'body' => 'required|string',
        ]);
        $body = $validatedData['body'];

        $review->body = $body;
        $review->save();

        return response()->json([
            'success' => true,
            'message' => 'Edited review',
            'data' => $body,
        ], 200);
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
            return response()->json([
                'success' => true,
                'message' => 'Successfully added a review',
                'data' => $review->getData(),
            ], 200);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot add review!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}
