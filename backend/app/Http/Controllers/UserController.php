<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    public function index(Request $request){
        $user = collect($request->attributes->get('user'));

        $filteredUser = $user->except(['api_token']);
        
        try {
            return response()->json([
                'success' => true,
                'message' => $filteredUser,
            ], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching user profile.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
    public function update(Request $request){
        
        try {
            $user = $request->attributes->get('user');
            
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users,email,'.$user->id,
                'picture' => 'nullable|string',
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
                'message' => 'Successfully update profile.',
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

    public function getUser(Request $request,$userName){
        try{
            $user = collect(User::where('email','like',$userName.'%') -> first());
            $filteredData = $user->except(['email','api_token','remember_token']);
            
            return response()->json([
                'success' => true,
                'message' => 'Successfully get user profile.',
                'data' => $filteredData,
            ], 201);
        }catch(Exception $exception){
            return response()->json([
                'success' => false,
                'message' => 'Cannot get user profile!',
                'error' => $exception->getMessage()
            ], 500);
        }
       
    }
}