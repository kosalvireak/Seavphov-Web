<?php

namespace App\Service;

use App\Models\CopMembersRequest;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;

class CopMemberRequestService
{

    public static function createCopMemberRequest($copId, $userId, $status)
    {
        return CopMembersRequest::create([
            'cop_id' => $copId,
            'user_id' => $userId,
            'status' => $status
        ]);
    }

    public static function getCopMemberRequest($copId)
    {
        $query = CopMembersRequest::query();
        $query->where('cop_id', $copId);
        $query->where('status', 1);
        $query->orderBy('created_at', 'desc');
        $members = $query->get();

        // Extract user_ids from the cop members
        $userIds = $members->pluck('user_id');

        // Fetch user details for all user_ids in a single query
        $users = User::whereIn('id', $userIds)
            ->select('id', 'name', 'uuid', 'picture') // Specify the fields you want to retrieve
            ->get();

        // Map user details with their roles
        $memberDetails = [];
        foreach ($members as $member) {
            $user = $users->firstWhere('id', $member->user_id);
            $user->request_date = $member->created_at;
            $memberDetails[] = $user->makeHidden('id'); // User details
        }
        // Return the response with user details
        return $memberDetails;
    }

    public static function userInPendingRequest($copId, $userId)
    {
        $query = CopMembersRequest::query();
        $query->where('cop_id', $copId);
        $query->where('user_id', $userId);
        $query->where('status', 1);
        $request = $query->first();
        return $request != null ? true : false;
    }

    public static function deleteCopMemberRequest($copId, $userId)
    {
        return CopMembersRequest::where('cop_id', $copId)
            ->where('user_id', $userId)
            ->delete();
    }
}
