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

    public static function isPendingRequest($copId, $userId)
    {
        $query = CopMembersRequest::query();
        $query->where('cop_id', $copId);
        $query->where('user_id', $userId);
        $query->where('status', 1);
        $request = $query->first();
        return $request != null ? true : false;
    }
}
