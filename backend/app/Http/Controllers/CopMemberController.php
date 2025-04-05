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

            return ResponseUtil::Success('Request to join community successfully', true);
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
                return ResponseUtil::Success('Approve member request successfully', true);
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

            return ResponseUtil::Success('Reject member request successfully', true);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot reject member request!', $exception->getMessage());
        }
    }
}
