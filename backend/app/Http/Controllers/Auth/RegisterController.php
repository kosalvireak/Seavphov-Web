<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }




    public function registerUser(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $uuid = Str::random(30);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'picture' => 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png',
                'uuid' => $uuid
            ]);


            $user->generateToken();

            return response()->json([
                'success' => true,
                'message' => 'Registered!',
                'data' => $user->toArray()
            ], 201);
        } catch (ValidationException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'User validation error!',
                'error' => $exception->getMessage()
            ], 422);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot register user!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}
