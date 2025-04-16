<?php

namespace App\Http\Controllers;

use App\Http\ResponseUtil;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use GuzzleHttp\Psr7\Response;

class UserController extends Controller
{
    public function getProfile(Request $request)
    {
        $user = collect($request->attributes->get('user'));

        $filteredUser = $user->except(['api_token', 'remember_token', 'created_at']);

        try {
            return ResponseUtil::Success('Get user profile success', $filteredUser);
        } catch (ModelNotFoundException $exception) {
            return ResponseUtil::ServerError('An error occurred while get user profile.', $exception->getMessage());
        }
    }
    public function editProfile(Request $request)
    {
        try {
            $user = $request->attributes->get('user');

            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users,email,' . $user->id,
                'picture' => 'nullable|string',
                'bio' => 'nullable|string',
                'cover' => 'nullable|string',
                'phone' => 'nullable|string',
                'instagram' => 'nullable|string',
                'facebook' => 'nullable|string',
                'twitter' => 'nullable|string',
                'telegram' => 'nullable|string',
                'location' => 'nullable|string',
            ]);

            $user->generateToken();
            $user->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Done',
                'data' => $user,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Profile validation error!',
                'error' => $exception->getMessage()
            ], 422);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot update profile!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function getOtherProfile(Request $request, $uuid)
    {
        try {
            $user = collect(User::where('uuid', $uuid)
                ->select([
                    'name',
                    'phone',
                    'picture',
                    'cover',
                    'bio',
                    'instagram',
                    'facebook',
                    'twitter',
                    'telegram',
                    'location'
                ])
                ->first());

            return ResponseUtil::Success('Get user profile success', $user);
        } catch (Exception $exception) {
            return ResponseUtil::ServerError('An error occurred while get user profile.', $exception->getMessage());
        }
    }
}
