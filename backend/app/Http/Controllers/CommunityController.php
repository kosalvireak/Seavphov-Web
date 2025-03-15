<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\Community;
use App\Models\CopMember;
use Illuminate\Database\QueryException;

class CommunityController extends Controller
{


    public function fetchCommunityWithFilter(Request $request)
    {

        $name = $request->get('name');
        $visibility = $request->get('visibility');
        $query = Community::query(); // Start with a base query

        // Filter by name if name = "", it will return all
        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        // if visibility == all it won't filter
        if ($visibility == 'private') { // Filter by visibility
            $query->where('private', 1);
        } else if ($visibility == 'public') {
            $query->where('private', 0);
        }

        // $cops = $query->paginate(6); // Apply pagination 
        $cops = $query
            ->orderBy('created_at', 'desc')
            ->get();

        try {
            return response()->json([
                'success' => true,
                'data' => $cops,
                'message' => 'Fetch community success',
            ], 200);
        } catch (QueryException  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching community.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function getCommunityByRoute($route)
    {
        try {

            $cop = Community::where('route', $route)->first();

            if (!$cop) {
                return response()->json([
                    'success' => false,
                    'message' => 'Community not found',
                ], 404);
            };

            return response()->json([
                'success' => true,
                'data' => $cop,
                'message' => 'Fetch community success',
            ], 200);
        } catch (QueryException  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching community.',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function createCommunity(Request $request)
    {
        try {
            $user = $request->attributes->get('user');

            $validatedData = $request->validate([
                'name' => 'required|string|unique:communities,name|regex:/^[a-zA-Z0-9\s]+$/',
                'private' => 'required|in:true,false',
            ]);

            $profile = $request->get('profile') ?? Community::defaultProfile();
            $banner = $request->get('banner') ?? Community::defaultBanner();
            $description = $request->get('description') ?? '';

            // Convert the string value to a boolean
            $private = filter_var($validatedData['private'], FILTER_VALIDATE_BOOLEAN);

            $cop = Community::create([
                'name' => $validatedData['name'],
                'private' => $private,
                'route' => Community::generateSlug($validatedData['name']),
                'profile' => $profile,
                'banner' => $banner,
                'description' => $description,
            ]);

            // add user as cop admin
            $copMember = CopMember::create([
                'cop_id' => $cop->id,
                'user_id' => $user->id,
                'role' => 1
            ]);

            return response()->json([
                'success' => true,
                'data' => $cop,
                'message' => 'Community created successfully',
            ]);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot Create Community!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}
