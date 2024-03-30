<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        try {
            return response()->json([
                'success' => true,
                'message' => Book::paginate(5),
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
        $book = Book::create($request->all());
        return response()->json($book, 201);
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
