<?php

namespace App\Http\Controllers;

use App\Http\ResponseUtil;
use Illuminate\Http\Request;
use Exception;
use App\Models\Community;
use App\Models\User;
use App\Service\CopMemberRequestService;
use App\Service\CopMemberService;
use App\Service\NotificationService;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\QueryException;

class CommunityController extends Controller
{


    public function searchCommunity(Request $request)
    {
        try {

            $name = $request->get('name');
            $visibility = $request->get('visibility');
            $role = $request->get('role');
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

            $user = $request->attributes->get('user');

            if ($user) {
                // Filter by role using a join with cop_members table
                if ($role == 'admin' || $role == 'member') {
                    $query->whereHas('members', function ($query) use ($role, $user) {
                        // Filter by role: admin (role = 1) or member (role = 2)
                        $query->where('user_id', $user->id)
                            ->where('role', $role == 'admin' ? 1 : 2);
                    });
                }
            }

            $cops = $query->paginate(6); // Apply pagination 

            return ResponseUtil::Success('Search community success', $cops);
        } catch (QueryException  $exception) {
            return ResponseUtil::ServerError('Cannot search community!', $exception->getMessage());
        }
    }

    public function getCommunityByRoute($route)
    {
        try {

            $cop = Community::where('route', $route)->first();

            if (!$cop) {
                return ResponseUtil::NotFound('Community not found');
            };

            return ResponseUtil::Success('Get community success', $cop);
        } catch (QueryException  $exception) {
            return ResponseUtil::ServerError('Cannot get community!', $exception->getMessage());
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
                return ResponseUtil::Success('Community created successfully', $cop);
            }
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot Create Community!', $exception->getMessage());
        }
    }

    public function getCommunityMembers(Request $request, $route)
    {
        try {

            // TODO: CopAdmin Api

            $user = $request->attributes->get('user');

            $cop = Community::where('route', $route)->first();

            if (!$cop) {
                return ResponseUtil::NotFound('Community not found');
            };

            if (CopMemberService::isCopAdmin($user->id, $cop->id) == false) {
                return ResponseUtil::Unauthorized('You are not admin of this community');
            }

            $copMember = CopMemberService::getCopMembers($cop->id);

            return ResponseUtil::Success('Get Community members successfully', $copMember);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot get Community members!', $exception->getMessage());
        }
    }



    public function getCommunityMemberRequest(Request $request, $route)
    {
        try {

            // TODO: CopAdmin Api

            $user = $request->attributes->get('user');

            $cop = Community::where('route', $route)->first();


            if (!$cop) {
                return ResponseUtil::NotFound('Community not found');
            };

            if (CopMemberService::isCopAdmin($user->id, $cop->id) == false) {
                return ResponseUtil::Unauthorized('You are not admin of this community');
            }

            $memberRequests = CopMemberRequestService::getCopMemberRequest($cop->id);

            return ResponseUtil::Success('Get Community member requests successfully', $memberRequests);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot get Community member requests!', $exception->getMessage());
        }
    }


    public function checkViewCopHomePermission(Request $request, $route)
    {
        try {

            $user = $request->attributes->get('user');

            $cop = Community::where('route', $route)->first();


            if (!$cop) {
                return ResponseUtil::NotFound('Community not found');
            };

            // non login User View Cop
            if (!$user) {
                return ResponseUtil::Success('Non login User View Cop',  [
                    'isCopMember' => false,
                    'isCopAdmin' => false,
                    'isPrivate' => $cop->isPrivate(),
                    'userInPendingRequest' => false,
                    'ableToViewHome' => false
                ],);
            }

            $isCopMember = CopMemberService::isCopMember($user->id, $cop->id);

            $isCopAdmin = CopMemberService::isCopAdmin($user->id, $cop->id);

            $userInPendingRequest = CopMemberRequestService::userInPendingRequest($cop->id, $user->id);

            // Check if the community is private and not a member or admin of cop
            if ($cop->isPrivate()) {
                if (!$isCopMember && !$isCopAdmin) {
                    return ResponseUtil::Success('No permission to view this community',  [
                        'isCopMember' => $isCopMember,
                        'isCopAdmin' => $isCopAdmin,
                        'isPrivate' => $cop->isPrivate(),
                        'userInPendingRequest' => $userInPendingRequest,
                        'ableToViewHome' => false
                    ],);
                }
            }

            return ResponseUtil::Success('Get Community permission successfully',  [
                'isCopMember' => $isCopMember,
                'isCopAdmin' => $isCopAdmin,
                'isPrivate' => $cop->isPrivate(),
                'userInPendingRequest' => $userInPendingRequest,
                'ableToViewHome' => true
            ],);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot get Community permission!', $exception->getMessage());
        }
    }


    public function requestToJoinCop(Request $request, $route)
    {
        try {
            $user = $request->attributes->get('user');

            $cop = Community::where('route', $route)->first();

            if (CopMemberService::isCopMember($user->id, $cop->id)) {
                return ResponseUtil::Success('You are already a member of this community');
            }

            if (CopMemberService::isCopAdmin($user->id, $cop->id)) {
                return ResponseUtil::Success('You are already an admin of this community');
            }

            $copAdminIds = CopMemberService::getCopAdminIds($cop->id);

            foreach ($copAdminIds as $copAdminId) {
                $copAdmin = User::find($copAdminId);
                NotificationService::storeRequestToJoinCopNotification($user->id, $copAdmin->id, $cop->id, 'request to join your community ' . $cop->name);
            }

            CopMemberRequestService::createCopMemberRequest($cop->id, $user->id, 1);

            return ResponseUtil::Success('Request to join community successfully');
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot request to join community!', $exception->getMessage());
        }
    }



    public function joinCop(Request $request, $route)
    {
        try {
            $user = $request->attributes->get('user');

            $cop = Community::where('route', $route)->first();

            if (CopMemberService::isCopMember($user->id, $cop->id)) {

                return ResponseUtil::Success('You are already a member of this community');
            }

            if (CopMemberService::isCopAdmin($user->id, $cop->id)) {
                return ResponseUtil::Success('You are already an admin of this community');
            }

            $copAdminIds = CopMemberService::getCopAdminIds($cop->id);

            foreach ($copAdminIds as $copAdminId) {
                $copAdmin = User::find($copAdminId);
                NotificationService::storeJoinCopNotification($user->id, $copAdmin->id, $cop->id, 'join your community ' . $cop->name);
            }

            CopMemberService::addUserAsCopMember($cop->id, $user->id);

            return ResponseUtil::Success('Join community successfully');
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot Join community!', $exception->getMessage());
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
                return ResponseUtil::NotFound('Community not found');
            };

            if (CopMemberService::isCopAdmin($user->id, $cop->id) == false) {

                return ResponseUtil::Unauthorized('You are not admin of this community');
            }

            if (CopMemberRequestService::userInPendingRequest($cop->id, $request_user->id) == false) {
                return ResponseUtil::Success('No pending request');
            }

            CopMemberRequestService::deleteCopMemberRequest($cop->id, $request_user->id);

            $response = CopMemberService::addUserAsCopMember($cop->id, $request_user->id);

            NotificationService::storeApproveRequestToJoinCopNotification($user->id, $request_user->id, $cop->id, 'approve your request to join ' . $cop->name);

            if ($response) {
                return ResponseUtil::Success('Approve member request successfully');
            }
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot approve member request!', $exception->getMessage());
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
                return ResponseUtil::NotFound('Community not found');
            };

            if (CopMemberService::isCopAdmin($user->id, $cop->id) == false) {

                return ResponseUtil::Success('You are already an admin of this community');
            }

            if (CopMemberRequestService::userInPendingRequest($cop->id, $request_user->id) == false) {
                return ResponseUtil::Success('No pending request');
            }

            CopMemberRequestService::deleteCopMemberRequest($cop->id, $request_user->id);

            NotificationService::storeRejectRequestToJoinCopNotification($user->id, $request_user->id, $cop->id, 'reject your request to join ' . $cop->name);

            return ResponseUtil::Success('Reject member request successfully');
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot reject member request!', $exception->getMessage());
        }
    }
}
