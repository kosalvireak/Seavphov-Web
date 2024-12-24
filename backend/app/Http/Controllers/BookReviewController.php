<?php


namespace App\Http\Controllers;

use App\Models\BookReview;
use Exception;
use Illuminate\Http\Request;

class BookReviewController extends Controller{
    public function fetchBookReviews($bookId){
        
        $items = [];
        $reviews = BookReview::where('book_id', $bookId)->get();
        
        foreach($reviews as $review){
            $items[]=$review->getData();
        }
        return response()->json([
            'success' => true,
            'message' => 'Successfully fetched book reviews',
            'data' => $items,
        ], 200);
        
    }

    public function createReview(Request $request){
        try{
            $user = $request->attributes->get('user');
            
             $validatedData = $request->validate([
                'body' => 'required|string',
                'book_id' => 'required|int',
            ]);

            $review = BookReview::create([
                'body' => $validatedData['body'],
                'book_id' => $validatedData['book_id'],
                'user_id' => $user->id,
                'helpful_vote' => 0,
                'not_helpful_vote' => 0,
            ]);
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