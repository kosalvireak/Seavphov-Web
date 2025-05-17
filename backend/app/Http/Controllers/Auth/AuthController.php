<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\ResponseUtil;
use App\Mail\SendForgotPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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


    public function resetPassword(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|string|email|',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required',
            ]);

            $email = $request->get('email');
            $token = $request->get('token');

            $isResetExist = DB::table('password_reset_tokens')
                ->where([
                    'email' => $email,
                    'token' => $token
                ])->first();

            if (!$isResetExist) {
                return ResponseUtil::UnProcessable('Token do not exist or expired!');
            }

            if ($isResetExist->token != $token) {
                return ResponseUtil::UnProcessable('Token do not match!');
            }

            DB::table('password_reset_tokens')
                ->where([
                    'email' => $email
                ])->delete();

            User::where('email', $email)
                ->update(['password' => bcrypt($validatedData['password'])]);

            return ResponseUtil::Success('Updated! Login with your new password', true, true);
        } catch (Exception $exception) {
            return ResponseUtil::ServerError('An error occurred while reset password.', $exception->getMessage());
        }
    }

    public function sendMailResetPassword(Request $request)
    {
        try {
            $email = $request->get('email');
            $user = User::where('email', $email)->first();

            if ($user) {
                $token =  random_int(100000, 999999);

                DB::table('password_reset_tokens')->insert([
                    'email' => $user->email,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
                $subject = "Your Password Reset Code";
                $body = $token;

                Mail::to($user->email)->send(new SendForgotPasswordMail($subject, $body));
            }
            return ResponseUtil::Success('Reset code sent to your email', null, true);
        } catch (Exception $exception) {
            return ResponseUtil::ServerError('An error occurred while send email reset password.', $exception->getMessage());
        }
    }
}
