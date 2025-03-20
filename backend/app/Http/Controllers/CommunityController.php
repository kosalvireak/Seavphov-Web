<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Exception;
use App\Models\Community;
use App\Models\CopMember;
use App\Service\CopMemberService;
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

        $cops = $query->paginate(6); // Apply pagination 
        // $cops = $query
        //     ->orderBy('created_at', 'desc')
        //     ->get();

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
                'profile' => 'nullable|url', // Optional profile URL
            ]);

            $description = $request->get('description') ?? '';

            // Convert the string value to a boolean
            $private = filter_var($validatedData['private'], FILTER_VALIDATE_BOOLEAN);

            $cop = Community::create([
                'name' => $validatedData['name'],
                'profile' => $validatedData['profile'],
                'private' => $private,
                'route' => Community::generateSlug($validatedData['name']),
                'description' => $description,
            ]);

            // add user as cop admin
            CopMemberService::addUserAsCopAdmin($cop->id, $user->id);

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

    public function getCommunityMembers(Request $request, $route)
    {
        try {

            $user = $request->attributes->get('user');

            $cop = Community::where('route', $route)->first();

            if (!$cop) {
                return response()->json([
                    'success' => false,
                    'message' => 'Community not found',
                ], 404);
            };

            if (CopMemberService::isCopAdmin($user->id, $cop->id) == false) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not admin of this community',
                ], 404);
            }

            $copMember = CopMemberService::getCopMembers($cop->id);

            return response()->json([
                'success' => true,
                'data' => $copMember,
                'message' => 'Get Community members successfully',
            ]);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot get Community members!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function checkViewCopHomePermission(Request $request, $route)
    {
        try {

            $user = $request->attributes->get('user');

            $cop = Community::where('route', $route)->first();

            if (!$cop) {
                return response()->json([
                    'success' => false,
                    'message' => 'Community not found',
                ], 404);
            };

            $isCopMember = CopMemberService::isCopMember($user->id, $cop->id);

            $isCopAdmin = CopMemberService::isCopAdmin($user->id, $cop->id);

            // Check if the community is private and not a member or admin of cop

            if ($cop->isPrivate()) {
                if (!$isCopMember && !$isCopAdmin) {
                    return response()->json([
                        'success' => true,
                        'data' => [
                            'isCopMember' => $isCopMember,
                            'isCopAdmin' => $isCopAdmin,
                            'isPrivate' => $cop->isPrivate(),
                            'ableToViewHome' => false
                        ],
                        'message' => 'No permission to view this community',
                    ], 200);
                }
            }


            return response()->json([
                'success' => true,
                'data' => [
                    'isCopMember' => $isCopMember,
                    'isCopAdmin' => $isCopAdmin,
                    'isPrivate' => $cop->isPrivate(),
                    'ableToViewHome' => true
                ],
                'message' => 'Get Community permission successfully',
            ], 200);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot get community permission!',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}
