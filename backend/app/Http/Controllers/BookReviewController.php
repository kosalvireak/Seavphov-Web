<?php


namespace App\Http\Controllers;

use App\Models\BookReview;
use Exception;
use Illuminate\Http\Request;

class BookReviewController extends Controller{

    public function createReview(Request $request){
        
        $user = $request->attributes->get('user');
        
        try{
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
                'data' => $review,
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