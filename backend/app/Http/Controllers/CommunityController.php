<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Exception;
use App\Models\Community;
use App\Models\CopMember;
use App\Models\User;
use App\Service\CopMemberRequestService;
use App\Service\CopMemberService;
use App\Service\NotificationService;
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
            $response = CopMemberService::addUserAsCopAdmin($cop->id, $user->id);
            if ($response) {
                return response()->json([
                    'success' => true,
                    'data' => $cop,
                    'message' => 'Community created successfully',
                ]);
            }
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



    public function getCommunityMemberRequest(Request $request, $route)
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

            $memberRequests = CopMemberRequestService::getCopMemberRequest($cop->id);

            return response()->json([
                'success' => true,
                'data' => $memberRequests,
                'message' => 'Get Community member requests successfully',
            ]);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot get Community member requests!',
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

            // non login User View Cop
            if (!$user) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'isCopMember' => false,
                        'isCopAdmin' => false,
                        'isPrivate' => $cop->isPrivate(),
                        'isPendingRequest' => false,
                        'ableToViewHome' => false
                    ],
                    'message' => 'Non login User View Cop',
                ], 200);
            }

            $isCopMember = CopMemberService::isCopMember($user->id, $cop->id);

            $isCopAdmin = CopMemberService::isCopAdmin($user->id, $cop->id);

            $isPendingRequest = CopMemberRequestService::isPendingRequest($cop->id, $user->id);

            // Check if the community is private and not a member or admin of cop
            if ($cop->isPrivate()) {
                if (!$isCopMember && !$isCopAdmin) {
                    return response()->json([
                        'success' => true,
                        'data' => [
                            'isCopMember' => $isCopMember,
                            'isCopAdmin' => $isCopAdmin,
                            'isPrivate' => $cop->isPrivate(),
                            'isPendingRequest' => $isPendingRequest,
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
                    'isPendingRequest' => $isPendingRequest,
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


    public function requestToJoinCop(Request $request, $route)
    {
        try {
            $user = $request->attributes->get('user');

            $cop = Community::where('route', $route)->first();

            if (CopMemberService::isCopMember($user->id, $cop->id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are already a member of this community',
                ], 200);
            }

            if (CopMemberService::isCopAdmin($user->id, $cop->id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are already an admin of this community',
                ], 200);
            }


            $copAdminIds = CopMemberService::getCopAdminIds($cop->id);

            foreach ($copAdminIds as $copAdminId) {
                $copAdmin = User::find($copAdminId);
                NotificationService::storeRequestToJoinCopNotification($user->id, $copAdmin->id, $cop->id, 'request to join your community ' . $cop->name);
            }

            CopMemberRequestService::createCopMemberRequest($cop->id, $user->id, 1);

            return response()->json([
                'success' => true,
                'data' => 'Waiting admin approval',
                'message' => 'Request to join community successfully',
            ], 200);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot request to join community',
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function approveMemberRequest(Request $request, $route)
    {
        try {
            $user = $request->attributes->get('user');

            $cop = Community::where('route', $route)->first();

            $uuid = $request->get('uuid');
            $request_user = User::where('uuid', $uuid)->first();

            if (!$cop) {
                return response()->json([
                    'success' => false,
                    'message' => 'Community not found',
                ], 200);
            };

            if (CopMemberService::isCopAdmin($user->id, $cop->id) == false) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not an admin of this community',
                ], 200);
            }

            if (CopMemberRequestService::isPendingRequest($cop->id, $request_user->id) == false) {
                return response()->json([
                    'success' => false,
                    'message' => 'No pending request',
                ], 200);
            }

            CopMemberRequestService::deleteCopMemberRequest($cop->id, $request_user->id);

            $response = CopMemberService::addUserAsCopMember($cop->id, $request_user->id);

            NotificationService::storeApproveRequestToJoinCopNotification($user->id, $request_user->id, $cop->id, 'approve your request to join ' . $cop->name);

            if ($response) {
                return response()->json([
                    'success' => true,
                    'message' => 'Approve member request successfully',
                ], 200);
            }
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot approve member request',
                'error' => $exception->getMessage()
            ], 500);
        }
    }


    public function rejectMemberRequest(Request $request, $route)
    {
        try {
            $user = $request->attributes->get('user');

            $cop = Community::where('route', $route)->first();

            $uuid = $request->get('uuid');
            $request_user = User::where('uuid', $uuid)->first();

            if (!$cop) {
                return response()->json([
                    'success' => false,
                    'message' => 'Community not found',
                ], 200);
            };

            if (CopMemberService::isCopAdmin($user->id, $cop->id) == false) {
                return response()->json([
                    'success' => false,
                    'message' => 'You are not an admin of this community',
                ], 200);
            }

            if (CopMemberRequestService::isPendingRequest($cop->id, $request_user->id) == false) {
                return response()->json([
                    'success' => false,
                    'message' => 'No pending request',
                ], 200);
            }

            CopMemberRequestService::deleteCopMemberRequest($cop->id, $request_user->id);

            NotificationService::storeRejectRequestToJoinCopNotification($user->id, $request_user->id, $cop->id, 'reject your request to join ' . $cop->name);

            return response()->json([
                'success' => true,
                'message' => 'Reject member request successfully',
            ], 200);
        } catch (Exception  $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot reject member request',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}
