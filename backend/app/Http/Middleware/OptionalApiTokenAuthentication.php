<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OptionalApiTokenAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       $token = $request->bearerToken();

        if ($token) {
            $user = User::where('api_token', $token)->first();

            if ($user && now()->lte($user->api_token_expires_at)) {
                // Add the authenticated user to the request attributes
                $request->attributes->add(['user' => $user]);
            }
        }

        // Proceed with the next middleware or request handler
        return $next($request);
    }
}