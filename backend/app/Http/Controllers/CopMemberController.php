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

class CopMemberController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/community/{route}/member-requests",
     *     summary="Get community's member request by route",
     *     tags={"Community's Member Request"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="route",
     *         in="path",
     *         required=true,
     *         description="Route of the community",
     *         @OA\Schema(type="string", default="1mmee")
     *     ),
     *     @OA\Response(response=200, description="Get Community member requests successfully"),
     *     @OA\Response(response=500, description="Cannot get Community member requests!")
     * )
     */
    public function getCommunityMemberRequest(Request $request)
    {
        try {

            $cop = $request->attributes->get('cop');

            $memberRequests = CopMemberRequestService::getCopMemberRequest($cop->id);

            return ResponseUtil::Success('Get Community member requests successfully', $memberRequests);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot get Community member requests!', $exception->getMessage());
        }
    }

    public function leaveCommunity(Request $request, $route)
    {
        try {
            $user = $request->attributes->get('user');
            $cop = Community::where('route', $route)->first();
            if (!$cop) {
                return ResponseUtil::NotFound('Community not found');
            };

            if (!CopMemberService::isCopMember($user->id, $cop->id)) {
                return ResponseUtil::Success('You are not a member of this community', null, true, 'info');
            }
            $copMember = CopMemberService::deleteCopMember($cop->id, $user->id);

            return ResponseUtil::Success('Leave community successfully', true, true);
        } catch (Exception $e) {
            return ResponseUtil::ServerError('Cannot leave community!', $e->getMessage());
        }
    }

    public function removeMemberFromCop(Request $request)
    {
        try {
            $user = $request->attributes->get('user');
            $cop = $request->attributes->get('cop');
            $uuid = $request->get('uuid');
            $member = User::where('uuid', $uuid)->first();

            if ($user->id == $member->id) {
                if (!CopMemberService::hasOtherAdmin($cop->id, $member->id)) {
                    return ResponseUtil::Success('You cannot remove yourself, A community must have at least one admin.', true, true, 'info');
                }
            }

            return ResponseUtil::Success('Remove member from community successfully', CopMemberService::deleteCopMember($cop->id, $member->id), true);
        } catch (Exception $e) {
            return ResponseUtil::ServerError('Cannot remove member from community!', $e->getMessage());
        }
    }

    public function changeUserRole(Request $request)
    {
        try {
            $cop = $request->attributes->get('cop');
            $uuid = $request->get('uuid');
            $member = User::where('uuid', $uuid)->first();
            $newRole = $request->get('role');

            if ($newRole != 'Admin' && $newRole != 'Member') {
                return ResponseUtil::Success('Role is not valid', [], true);
            }

            // check if user change themselves to member and no admin left 
            if ($newRole == 'Member') {
                if (!CopMemberService::hasOtherAdmin($cop->id, $member->id)) {
                    return ResponseUtil::Success('You cannot change yourself to member, A community must have at least one admin.', true, true, 'info');
                }
            }

            $newRole = ($newRole == 'Admin') ? 1 : 2;

            if (CopMemberService::isAdminOrMember($member->id, $cop->id) == false) {
                return ResponseUtil::Success('User is not admin or member of this community');
            }

            $copMember = CopMemberService::changeUserRole($cop->id, $member->id, $newRole);
            return ResponseUtil::Success('Change user role successfully', $copMember, true);
        } catch (Exception $exception) {
            return ResponseUtil::ServerError('Cannot change user role!', $exception->getMessage());
        }
    }



    /**
     * @OA\Get(
     *     path="/api/community/{route}/members",
     *     summary="Get community's member by route",
     *     tags={"Community's Member"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="route",
     *         in="path",
     *         required=true,
     *         description="Route of the community",
     *         @OA\Schema(type="string", default="1mmee")
     *     ),
     *     @OA\Response(response=200, description="Get Community members successfully"),
     *     @OA\Response(response=500, description="Cannot get Community members!")
     * )
     */
    public function getCommunityMembers(Request $request)
    {
        try {
            $cop = $request->attributes->get('cop');
            $copMember = CopMemberService::getCopMembers($cop->id);

            return ResponseUtil::Success('Get Community members successfully', $copMember);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot get Community members!', $exception->getMessage());
        }
    }


    public function requestToJoinCop(Request $request, $route)
    {
        try {
            $user = $request->attributes->get('user');

            $cop = Community::where('route', $route)->first();

            if (CopMemberService::isAdminOrMember($user->id, $cop->id)) {
                return ResponseUtil::Success('You are already a member of this community');
            }

            $copAdminIds = CopMemberService::getCopAdminIds($cop->id);

            foreach ($copAdminIds as $copAdminId) {
                $copAdmin = User::find($copAdminId);
                NotificationService::storeRequestToJoinCopNotification($user->id, $copAdmin->id, $cop->id, 'request to join your community ' . $cop->name);
            }

            CopMemberRequestService::createCopMemberRequest($cop->id, $user->id, 1);

            return ResponseUtil::Success('Request to join community successfully', true, true);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot request to join community!', $exception->getMessage());
        }
    }


    public function joinCop(Request $request, $route)
    {
        try {
            $user = $request->attributes->get('user');

            $cop = Community::where('route', $route)->first();

            if (CopMemberService::isAdminOrMember($user->id, $cop->id)) {
                return ResponseUtil::Success('You are already a member of this community');
            }

            $copAdminIds = CopMemberService::getCopAdminIds($cop->id);

            foreach ($copAdminIds as $copAdminId) {
                $copAdmin = User::find($copAdminId);
                NotificationService::storeJoinCopNotification($user->id, $copAdmin->id, $cop->id, 'join your community ' . $cop->name);
            }

            CopMemberService::addUserAsCopMember($cop->id, $user->id);

            return ResponseUtil::Success('Join community successfully', true);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot Join community!', $exception->getMessage());
        }
    }


    public function approveMemberRequest(Request $request)
    {
        try {
            $user = $request->attributes->get('user');
            $cop = $request->attributes->get('cop');
            $uuid = $request->get('uuid');

            $request_user = User::where('uuid', $uuid)->first();

            if (CopMemberRequestService::userInPendingRequest($cop->id, $request_user->id) == false) {
                return ResponseUtil::Success('No pending request');
            }

            CopMemberRequestService::deleteCopMemberRequest($cop->id, $request_user->id);

            $response = CopMemberService::addUserAsCopMember($cop->id, $request_user->id);

            NotificationService::storeApproveRequestToJoinCopNotification($user->id, $request_user->id, $cop->id, 'approve your request to join ' . $cop->name);

            if ($response) {
                return ResponseUtil::Success('Approve member request successfully', true, true);
            }
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot approve member request!', $exception->getMessage());
        }
    }


    public function rejectMemberRequest(Request $request, $route)
    {
        try {
            $user = $request->attributes->get('user');
            $cop = $request->attributes->get('cop');
            $uuid = $request->get('uuid');

            $request_user = User::where('uuid', $uuid)->first();

            if (CopMemberRequestService::userInPendingRequest($cop->id, $request_user->id) == false) {
                return ResponseUtil::Success('No pending request');
            }

            CopMemberRequestService::deleteCopMemberRequest($cop->id, $request_user->id);

            NotificationService::storeRejectRequestToJoinCopNotification($user->id, $request_user->id, $cop->id, 'reject your request to join ' . $cop->name);

            return ResponseUtil::Success('Reject member request successfully', true, true, 'danger');
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot reject member request!', $exception->getMessage());
        }
    }
}
