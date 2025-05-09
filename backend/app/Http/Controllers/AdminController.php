<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Book;
use App\Models\Discussion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Stringable;

class AdminController extends Controller
{
    public function adminGetBooks()
    {
        try {
            $books = Book::all()->map(function ($book) {
                $book->descriptions = substr($book->descriptions, 0, 200);
                return $book;
            });
            return response()->json([
                'success' => true,
                'data' => $books,
            ], 200);
        } catch (QueryException  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while get books.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
    public function adminDeleteBook($id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();
            return response()->json([
                'success' => true,
                'message' =>  'Deleted "' . $book->title . '"',
            ], 200);
        } catch (QueryException  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while get books.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
    public function adminGetUsers()
    {
        try {
            $users = User::all()->map(function ($user) {
                return [
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at,
                    'facebook' => $user->facebook,
                    'instagram' => $user->instagram,
                    'location' => $user->location,
                    'phone' => $user->phone,
                    'picture' => $user->picture,
                    'telegram' => $user->telegram,
                    'twitter' => $user->twitter,
                    'uuid' => $user->uuid,
                ];
            })->toArray();

            return response()->json([
                'success' => true,
                'data' => $users,
            ], 200);
        } catch (QueryException  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while get users.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
    public function adminGetAuth()
    {
        try {
            $isAdmin = true;

            return response()->json([
                'success' => true,
                'data' => $isAdmin,
            ], 200);
        } catch (QueryException  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while get books.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
    public function adminGetOverviewData()
    {
        try {
            $totalUsers = User::count() - 1;
            $totalBooks = Book::count();
            $totalDiscussions = Discussion::count();
            $totalBanners = Banner::count();


            return response()->json([
                'success' => true,
                'data' => [
                    'totalUsers' => $totalUsers,
                    'totalBooks' => $totalBooks,
                    'totalDiscussions' => $totalDiscussions,
                    'totalBanners' => $totalBanners
                ],
            ], 200);
        } catch (QueryException  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while get users.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}
