<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class UserController extends Controller
{
    public function fetchUserProfile(Request $request){
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
    public function modifyUserProfile(Request $request){
        
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

    public function fetchOtherUserProfile(Request $request,$uuid){
        try{
            $user = collect(User::where('uuid',$uuid) -> first());
            $filteredData = $user->except(['email','api_token','remember_token']);
            
            return response()->json([
                'success' => true,
                'message' => 'Done',
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
    public function sendEmailResetPassword(Request $request){
        try{
            $email = $request->get('email');
            
            $user = User::where('email',$email)->first();
            
            if($user){
                
                $token =  random_int(100000, 999999);
                
                DB::table('password_reset_tokens')->insert([
                    'email' => $user->email,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
                $subject = "Reset Password Token";
                $body = $token;

                Mail::to($user->email)->send(new SendMail($subject, $body));
                                
            }
            return response()->json([
                'success' => true,
                'message' => 'Token sent to your email',
            ], 200);
        }   catch(Exception $exception){
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
    public function resetPassword(Request $request){
        try{
            $validatedData = $request->validate([
                'email' => 'required|string|email|',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required',
            ]);
            
            $isResetExist = DB::table('password_reset_tokens')
            ->where([
                'email'=>$request->get('email')
            ])->first();    
                
            if( $isResetExist->token != $request->get('token')){
                return response()->json([
                    'success' => false,
                    'message' => 'Token do not match!',
                ], 400);
            }
            DB::table('password_reset_tokens')
            ->where([
                'email'=>$request->get('email')
            ])->delete();    

            User::where('email',$request->get('email'))
            ->update(['password' => bcrypt($validatedData['password'])]);
                            
                return response()->json([
                    'success' => true,
                    'message' => 'Updated password.',
                ], 200);
                                
            
            
        }   catch(Exception $exception){
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}