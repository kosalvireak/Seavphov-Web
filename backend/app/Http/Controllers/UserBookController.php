<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserBookController extends Controller
{
    public function saveBook (Request $request, $bookId){
        try{
            $user = $request->attributes->get('user');
            
            $book = Book::find($bookId);

            if(!$book){
                return response()->json([
                    'success' => false,
                    'message' => 'Book not found!',
                ], 404);
            }

            $isSaved = $user->savedBooks()->where('book_id', $bookId)->exists();
            
            if ($isSaved) {
                $user->savedBooks()->detach($bookId);
                return response()->json([
                    'success' => true,
                    'message' => 'Unsaved ' . $book->title,
                ], 200); 
            } else {
                $user->savedBooks()->attach($bookId, [
                    'created_at' => Carbon::now(),
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Saved ' . $book->title,
                ], 201);
            }
                    
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
            ], 500);
        }
      
    }
    public function fetchSavedBook (Request $request){
        try {
            
            $user = $request->attributes->get('user');
            
            $savedBooks = $user->savedBooks;
        
            return response()->json([
                'success' => true,
                'message' => $savedBooks,
            ], 200);
        } catch (QueryException  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching books.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
    public function getSavedBooksNotification (Request $request){
       
        try {
            
            
            $owner = $request->attributes->get('user');

            $myBooks = $owner->books()->get();

            $items = [];
            $userName = '';
            $bookTitle = '';

            foreach($myBooks as $book){
                $savedByUsers = $book->savedByUsers();

                foreach ($savedByUsers as $data) {
                    $user_id = $data->user_id;
                    if($user_id != $owner->id){
                    $book_id = $data->book_id;
                    $created_at = $data->created_at;
                    $differentDate = (int) Carbon::now()->diffInDays($created_at,true);
                    $userName = User::where('id',$user_id)->get(['name','picture']); 
                    $bookTitle = Book::where('id', $book_id)->get(['title','images']); 
                    $items[]=[
                        'user' => $userName,
                        'text' => 'saved your book',
                        'book' => $bookTitle,
                        'book_id' => $book_id,
                        'date' => $differentDate,
                    ];
                }
                }
            }
            
        
            return response()->json([
                'success' => true,
                'data' => $items,
            ], 200);
        } catch (QueryException  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching books.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}