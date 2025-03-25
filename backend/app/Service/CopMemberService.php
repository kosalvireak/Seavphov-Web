<?php

namespace App\Service;

use App\Models\CopMember;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;


class CopMemberService
{
    public static function addUserAsCopAdmin($copId, $userId)
    {

        if (empty($copId) || empty($userId)) {
            return response()->json([
                'success' => false,
                'message' => 'Community or User not found!',
            ], 200);
        }
        try {
            CopMember::create([
                'cop_id' => $copId,
                'user_id' => $userId,
                'role' => 1
            ]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function addUserAsCopMember($copId, $userId)
    {

        if (empty($copId) || empty($userId)) {
            return response()->json([
                'success' => false,
                'message' => 'Community or User not found!',
            ], 400);
        }

        try {
            CopMember::create([
                'cop_id' => $copId,
                'user_id' => $userId,
                'role' => 2
            ]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function isCopAdmin($userId, $copId)
    {
        $query = CopMember::query();
        $query->where('cop_id', $copId);
        $query->where('user_id', $userId);
        $query->where('role', 1);

        $copAdmin = $query->first();

        return $copAdmin != null ? true : false;
    }

    public static function isCopMember($userId, $copId)
    {
        $query = CopMember::query();
        $query->where('cop_id', $copId);
        $query->where('user_id', $userId);
        $query->where('role', 2);

        $copMember = $query->first();

        return $copMember != null ? true : false;
    }


    public static function getCopMembers($copId)
    {
        // Fetch the cop members with role 1 (admins)
        $copMembers = CopMember::where('cop_id', $copId)
            ->orderBy('created_at', 'desc')
            ->get(['user_id', 'role', 'created_at']); // Get user_id and role fields

        // Extract user_ids from the cop members
        $userIds = $copMembers->pluck('user_id');

        // Fetch user details for all user_ids in a single query
        $users = User::whereIn('id', $userIds)
            ->select('id', 'name', 'uuid', 'picture') // Specify the fields you want to retrieve
            ->get();

        // Map user details with their roles
        $memberDetails = [];
        foreach ($copMembers as $member) {
            $user = $users->firstWhere('id', $member->user_id);
            $user->role =  $member->role == 1 ? 'Admin' : 'Members';  // Attach role label
            $user->join_date = $member->created_at;
            $memberDetails[] = $user->makeHidden('id'); // User details
        }
        // Return the response with user details
        return $memberDetails;
    }

    public static function getCopAdminIds($copId)
    {
        $copMembers = CopMember::where('cop_id', $copId)->where('role', 1)->get(['user_id']);
        return $copMembers->pluck('user_id')->toArray();
    }
}
