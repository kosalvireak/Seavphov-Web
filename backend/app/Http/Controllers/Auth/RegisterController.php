<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function registered( $user)
    {
        $user->generateToken();

        return response()->json([
            'success' => true,
            'message' => 'Successfully registered!',
            'data' => $user->toArray()
        ], 201);
    }


    public function register(Request $request)
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
                'picture'=>'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png',
                'uuid'=>$uuid
            ]);


            return $this->registered($request, $user);
        } catch (ValidationException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'User validation error!',
                'error' => $exception->getMessage()
            ], 442);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot register user!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}