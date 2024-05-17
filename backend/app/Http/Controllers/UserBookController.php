<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UserBookController extends Controller
{
    public function saveBook(Request $request, $bookId)
    {
        try {
            $user = $request->attributes->get('user');

            $book = Book::find($bookId);

            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Book not found!',
                ], 404);
            }

            $user->savedBooks()->attach($bookId);

            return response()->json([
                'success' => true,
                'message' => 'Successfully save "' . $book->title . '"',
            ], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
            ], 500);
        }
    }
    public function getSaveBook(Request $request)
    {
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
    public function removeBook(Request $request, $bookId)
    {
        try {

            $user = $request->attributes->get('user');

            $book = Book::find($bookId);

            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'Book not found!',
                ], 404);
            }

            $user->savedBooks()->detach($bookId);

            return response()->json([
                'success' => true,
                'message' => 'Remove from Saved',
            ], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
            ], 500);
        }
    }
}
