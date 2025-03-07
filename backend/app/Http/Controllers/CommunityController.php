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

        // $all = $request->get('all');
        $name = $request->get('name');
        $private = $request->get('private');

        // if ($all) {
        //     $cops = Community::all();
        // return response()->json([
        //     'success' => true,
        //     'data' => $private,
        // ], 200);
        // }

        $query = Community::query(); // Start with a base query

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%'); // Filter by name
        }

        if ($private == 'true') { // Filter by visibility
            $query->where('private', 1);
        } else if ($private == 'false') {
            $query->where('private', 0);
        }

        $cops = $query->paginate(6); // Apply pagination 

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




    public function createCommunity(Request $request)
    {
        try {
            $user = $request->attributes->get('user');

            $validatedData = $request->validate([
                'name' => 'required|string|unique:communities,name|regex:/^[a-zA-Z0-9\s]+$/',
                'private' => 'required|boolean',
            ]);

            $profile = $request->get('profile') ?? Community::defaultProfile();
            $banner = $request->get('banner') ?? Community::defaultBanner();
            $description = $request->get('description') ?? '';

            $cop = Community::create([
                'name' => $validatedData['name'],
                'private' => $validatedData['private'],
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
