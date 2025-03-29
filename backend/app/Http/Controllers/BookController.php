<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function getNewest()
    {
        try {
            $books = Book::orderBy('created_at', 'desc')->take(6)->get();

            return response()->json([
                'success' => true,
                'message' => $books,
            ], 200);
        } catch (QueryException  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching newest books.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function getMostReviewed()
    {
        try {
            $books = Book::withCount('reviews') // Count the number of reviews
                ->orderBy('reviews_count', 'desc') // Order by the review count
                ->take(6) // Limit the result to the top 6 books
                ->get();

            return response()->json([
                'success' => true,
                'message' => $books,
            ], 200);
        } catch (QueryException  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching most review books.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
    public function fetchBooksWithFilter(Request $request)
    {

        $all = $request->get('all');
        $title = $request->get('title');
        $author = $request->get('author');
        $categories = $request->get('categories');
        $condition = $request->get('condition');
        $uuid = $request->get('uuid');
        $max = $request->get('max');
        $excludeId = $request->get('excludeId');

        if ($all) {
            $books = Book::all();
            return response()->json([
                'success' => true,
                'message' => $books,
            ], 200);
        }

        $query = Book::query(); // Start with a base query

        if ($excludeId) {
            $query->where('id', '!=', $excludeId); // remove current view book
        }

        if ($title) {
            $query->where('title', 'like', '%' . $title . '%'); // Filter by title
        }

        if ($categories) {
            $query->where('categories', $categories); // Filter by categories
        }
        if ($condition) {
            $query->where('condition', $condition); // Filter by categories
        }

        if ($author) {
            $query->where('author', $author); // Filter by author
        }

        if ($uuid) {
            $user = User::where('uuid', $uuid)->first();
            $query->where('owner_id', $user->id); // Filter by uuid
        }


        if ($max > 0) {
            $books = $query->paginate($max); // Apply max for related book
        } else {
            $books = $query->paginate(12); // Apply pagination 
        }

        try {
            return response()->json([
                'success' => true,
                'message' => $books,
            ], 200);
        } catch (QueryException  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching books.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function getMyBooks(Request $request)
    {
        $user = $request->attributes->get('user');
        $books = $user->books()->get();

        try {
            return response()->json([
                'success' => true,
                'message' => $books,
            ], 200);
        } catch (QueryException  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching books.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
    public function getMyBook(Request $request, $id)
    {
        try {
            $user = $request->attributes->get('user');
            $book = $user->book($id);

            if (!$book) {
                return response()->json([
                    'success' => false,
                    'message' => 'No permission',
                ], 200);
            }
            return response()->json([
                'success' => true,
                'message' => $book,
            ], 200);
        } catch (QueryException  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching books.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function fetchBookDetail(Request $request, $bookId)
    {
        try {

            $book = Book::findOrFail($bookId);

            $book->makeHidden(['owner_id', 'updated_at', 'created_at']);

            $userId = null;

            // Check if the user attribute exists and get the user ID
            if ($request->attributes->has('user')) {
                $userId = $request->attributes->get('user')->id;
            }

            $issaved = false;

            if ($userId != null) {
                $user = User::where('id', $userId)->first();
                $savedBooks = $user->savedBooks;
                if ($savedBooks) {
                    $issaved = $savedBooks->contains('id', $bookId);
                }
            }
            $book->issaved = $issaved;

            return response()->json([
                'success' => true,
                'book' => $book,
                'owner' => $book->owner(),
            ], 200);
        } catch (ModelNotFoundException  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found!',
                'error' => $exception->getMessage()
            ], 404);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function createBook(Request $request)
    {
        $user = $request->attributes->get('user');
        try {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'author' => 'required|string',
                'categories' => 'required|string',
                'condition' => 'required|string',
                'descriptions' => 'required|string',
                'availability' => 'required|int',
                'images' => 'required|string',
            ]);

            $validatedData['owner_id'] = $user->id;

            $book = Book::create($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Uploaded ' . $book->title,
                'bookId' => $book->id
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Book validation error!',
                'error' => $exception->getMessage()
            ], 442);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot Upload Book!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function modifyBook(Request $request, $id)
    {
        try {
            $user = $request->attributes->get('user');

            $book = Book::findOrFail($id);

            if ($book->owner_id != $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission',
                ], 403);
            }

            $validatedData = $request->validate([
                'title' => 'required|string',
                'author' => 'required|string',
                'categories' => 'required|string',
                'condition' => 'required|string',
                'descriptions' => 'required|string',
                'availability' => 'required|int',
                'images' => 'required|string',
            ]);

            $book->update($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Updated ' . $book->title,
            ], 200);
        } catch (QueryException  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching books.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function changeAvailability(Request $request, $id)
    {
        try {
            $user = $request->attributes->get('user');
            $book = Book::findOrFail($id);

            if ($book->owner_id != $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission',
                ], 403);
            }
            $book->availability = !$book->availability;
            $book->save();

            return response()->json([
                'success' => true,
                'message' => 'Successfully changed availability',
            ], 200);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot change Book!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
    public function deleteBook(Request $request, $id)
    {
        try {
            $user = $request->attributes->get('user');

            $book = Book::findOrFail($id);

            if ($book->owner_id != $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'No permission',
                ], 403);
            }

            $book->delete();
            return response()->json([
                'success' => true,
                'message' => 'Deleted "' . $book->title . '"',
            ], 200);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete Book!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}
