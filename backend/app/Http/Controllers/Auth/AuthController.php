<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\ResponseUtil;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->api_token_expires_at < now()) {
                $user->generateToken();
            }

            return ResponseUtil::Success('Authentication succeeded', $user);
        } else {
            $errors = ['error' => trans('auth.failed')];
            return ResponseUtil::UnProcessable('Authentication failed', $errors);
        }
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
                'picture' => 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png',
                'uuid' => $uuid
            ]);

            $user->generateToken();

            return ResponseUtil::Success('Registered!', $user->toArray(), true);
        } catch (Exception $exception) {
            return ResponseUtil::ServerError('Cannot register user!', $exception->getMessage());
        }
    }
}
