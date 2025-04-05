<?php

namespace App\Http\Middleware;

use App\Http\ResponseUtil;
use App\Models\Community;
use App\Service\CopMemberService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CopAdminAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->attributes->get('user');

        $route = $request->route('route');
        if (!$route) {
            return ResponseUtil::UnProcessable('Route parameter is missing');
        }

        $cop = Community::where('route', $route)->first();

        if (!$cop) {
            return ResponseUtil::NotFound('Community not found');
        };

        if (CopMemberService::isCopAdmin($user->id, $cop->id) == false) {
            return ResponseUtil::Unauthorized('You are not admin of this community');
        }

        $request->attributes->add(['cop' => $cop]);

        return $next($request);
    }
}
