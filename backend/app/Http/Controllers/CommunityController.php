<?php

namespace App\Http\Controllers;

use App\Http\ResponseUtil;
use Illuminate\Http\Request;
use Exception;
use App\Models\Community;
use App\Models\CopMember;
use App\Service\CopMemberRequestService;
use App\Service\CopMemberService;
use Illuminate\Database\QueryException;

class CommunityController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/community",
     *     summary="Search for communities by filters",
     *     tags={"Community"},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=false,
     *         description="Name of the community to search for",
     *         @OA\Schema(type="string", default="")
     *     ),
     *     @OA\Parameter(
     *         name="visibility",
     *         in="query",
     *         required=false,
     *         description="Visibility of the community: all, public, or private",
     *         @OA\Schema(type="string", enum={"all", "public", "private"}, default="all")
     *     ),
     *     @OA\Parameter(
     *         name="role",
     *         in="query",
     *         required=false,
     *         description="User's role in the community: admin or member",
     *         @OA\Schema(type="string", enum={"admin", "member"})
     *     ),
     *      @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="Paginate",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Search community success"),
     *     @OA\Response(response=500, description="Cannot search community!")
     * )
     */

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

            $query->withCount('members');

            $cops = $query->paginate(6); // Apply pagination 

            return ResponseUtil::Success('Search community success', $cops, false);
        } catch (QueryException  $exception) {
            return ResponseUtil::ServerError('Cannot search community!', $exception->getMessage());
        }
    }


    /**
     * @OA\Get(
     *     path="/api/community/route/{route}",
     *     summary="Get specific community by route",
     *     tags={"Community"},*     
     *     @OA\Parameter(
     *         name="route",
     *         in="path",
     *         required=true,
     *         description="Route of the community",
     *         @OA\Schema(type="string", default="1mmee")
     *     ),
     *     @OA\Response(response=200, description="Get community success"),
     *     @OA\Response(response=500, description="Cannot get community!")
     * )
     */
    public function getCommunityByRoute($route)
    {
        try {
            $cop = Community::where('route', $route)->first();

            if (!$cop) {
                return ResponseUtil::NotFound('Community not found');
            };

            $cop->member_count = $cop->members()->count();

            return ResponseUtil::Success('Get community success', $cop);
        } catch (QueryException  $exception) {
            return ResponseUtil::ServerError('Cannot get community!', $exception->getMessage());
        }
    }

    public function deleteCommunity(Request $request)
    {
        try {
            $cop = $request->attributes->get('cop');
            $cop->delete();

            return ResponseUtil::Success('Delete community success!', true, true);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot delete Community!', $exception->getMessage());
        }
    }

    public function editCommunity(Request $request)
    {
        try {
            $cop = $request->attributes->get('cop');

            $validatedData = $request->validate([
                'name' => 'required|string|max:50|regex:/^[a-zA-Z0-9\s]+$/',
                'description' => 'required|string',
                'private' => 'required|in:true,false',
                'profile' => 'nullable|url',
                'banner' => 'nullable|url',
            ]);

            // Convert the string value to a boolean
            $validatedData['private'] = filter_var($validatedData['private'], FILTER_VALIDATE_BOOLEAN);

            $cop->update($validatedData);

            return ResponseUtil::Success('Edit community success', $cop, true);
        } catch (Exception  $exception) {
            return ResponseUtil::ServerError('Cannot Edit Community!', $exception->getMessage());
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

    /**
     * @OA\Get(
     *     path="/api/community/{route}/permission/home",
     *     summary="Check community permission",
     *     tags={"Community"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="route",
     *         in="path",
     *         required=true,
     *         description="Route of the community",
     *         @OA\Schema(type="string", default="1mmee")
     *     ),
     *     @OA\Response(response=200, description="Get Community permission successfully"),
     *     @OA\Response(response=500, description="Cannot get Community permission!")
     * )
     */
    public function checkViewCopHomePermission(Request $request, $route)
    {
        try {
            $user = $request->attributes->get('user');

            $cop = Community::where('route', $route)->first();
            if (!$cop) {
                return ResponseUtil::NotFound('Community not found');
            };

            // Handle non-logged-in User
            if (!$user) {
                return ResponseUtil::Success('Non login User View Cop',  [
                    'isCopMember' => false,
                    'isCopAdmin' => false,
                    'isPrivate' => $cop->isPrivate(),
                    'userInPendingRequest' => false,
                    'ableToViewHome' => false
                ],);
            }

            // Check if the user is a member or admin of the community
            $copMember = CopMember::where('cop_id', $cop->id)
                ->where('user_id', $user->id)
                ->first();

            $isCopMember = $copMember && $copMember->role === 2; // Role 2 = Member
            $isCopAdmin = $copMember && $copMember->role === 1;  // Role 1 = Admin

            $userInPendingRequest = CopMemberRequestService::userInPendingRequest($cop->id, $user->id);

            // If the community is private and the user is neither a member nor an admin
            if ($cop->isPrivate() && !$isCopMember && !$isCopAdmin) {
                return ResponseUtil::Success('No permission to view content of this community', [
                    'isCopMember' => $isCopMember,
                    'isCopAdmin' => $isCopAdmin,
                    'isPrivate' => $cop->isPrivate(),
                    'userInPendingRequest' => $userInPendingRequest,
                    'ableToViewHome' => false,
                ], true, 'info');
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
}
