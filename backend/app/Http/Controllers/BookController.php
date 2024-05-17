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
    public function fetchBooksWithFilter(Request $request)
    {
        $query = Book::query(); // Start with a base query

        // Filter based on query parameters (example filters: title, author)
        $title = $request->get('title');
        $author = $request->get('author');
        $categories = $request->get('categories');
        $uuid = $request->get('uuid');

        if ($title) {
            $query->where('title', 'like', '%' . $title . '%'); // Filter by title
        }
        if ($categories) {
            $query->where('categories', $categories); // Filter by categories
        }
        if ($author) {
            $query->where('author', $author); // Filter by author
        }
        if ($uuid) {
            $user = User::where('uuid',$uuid)->first();
            $query->where('owner_id', $user->id); // Filter by uuid
        }
        
        $books = $query->paginate(10); // Apply pagination 

        try {
            return response()->json([
                'success' => true,
                'message' => $books,
            ], 200);
        } catch (Exception $exception) {
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
        
        if(!$book){
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission' ,
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

    public function fetchBookById(Request $request, $bookId)
    {
        try {
            
            $book = Book::findOrFail($bookId);

            $book->makeHidden(['owner_id','updated_at','created_at']);

            $uuid = $request->get('uuid');
            
            $issaved = false;
            
            if($uuid!=null){
                $user = User::where('uuid',$uuid)->first();
                $savedBooks = $user->savedBooks;
                if($savedBooks){
                    $issaved = $savedBooks->contains('id',$bookId);
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

    public function store(Request $request)
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
                'message' => 'Successfully upload ' . $book->title,
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
        try{
            $user = $request->attributes->get('user');

            $book = Book::findOrFail($id);

            if($book->owner_id != $user->id){
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission' ,
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
                'message' => 'Successfully updated '.$book->title,
            ], 200);
        } catch (QueryException  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching books.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function deleteBook(Request $request, $id)
    {
        try{
            $user = $request->attributes->get('user');

            $book = Book::findOrFail($id);

            
            if($book->owner_id != $user->id){
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission' ,
                ], 403);
            }
        
            $book->delete();
            return response()->json([
                'success' => true,
                'message' => 'Successfully delete "'.$book->title.'"',
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