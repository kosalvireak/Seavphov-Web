<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->attributes->get('user');
        if ($user->uuid !== "b8WbMnM7C9C9rN5e9fXwDpJ4bC3lZh") {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        return $next($request);
    }
}