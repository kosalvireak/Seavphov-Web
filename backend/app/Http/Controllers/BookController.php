<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query(); // Start with a base query

        // Filter based on query parameters (example filters: title, author)
        $title = $request->get('title');
        $author = $request->get('author');
        $categories = $request->get('categories');

        if ($title) {
            $query->where('title', $title); // Filter by title
        }
        if ($categories) {
            $query->where('categories', $categories); // Filter by categories
        }

        if ($author) {
            $query->where('author', $author); // Filter by author
        }

        $books = $query->paginate(5); // Apply pagination 

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

    public function show($id)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => Book::findOrFail($id),
            ], 200);
        } catch (ModelNotFoundException  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found!',
                'error' => $exception->getMessage()
            ], 404);
        }
    }

    public function store(Request $request)
    {
        // return response()->json([
        //     'success' => true,
        //     'message' => $request,
        // ], 201);
        try {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'author' => 'required|string',
                'categories' => 'required|string',
                'condition' => 'required|string',
                'descriptions' => 'required|string',
                'availability' => 'required|int',
                'images' => '', // Image validation (optional)
            ]);

            $book = Book::create($validatedData);
            return response()->json([
                'success' => true,
                'message' => $book,
            ], 201);
            return response()->json([
                'success' => true,
                'message' => 'Successfully upload Book!' . $book,
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

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->update($request->all());

        return response()->json($book, 200);
    }

    public function delete(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json(
            [
                'msg' => 'Successfully delete ' . $book->title
            ],
            204
        );
    }
}
