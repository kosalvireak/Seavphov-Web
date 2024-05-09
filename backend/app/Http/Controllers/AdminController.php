<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminGetBooks(){
        try {
             $books = Book::all();
            return response()->json([
                'success' => true,
                'data' => $books,
            ], 200);
        } catch (QueryException  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching books.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
    public function adminGetUsers(){
        try {
             $users = User::all();

            return response()->json([
                'success' => true,
                'data' => $users,
            ], 200);
        } catch (QueryException  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching users.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
    public function adminGetAuth(){
        try {
            $isAdmin = true;

            return response()->json([
                'success' => true,
                'data' => $isAdmin,
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