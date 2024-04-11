<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class ApiTokenAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: Missing token',
            ], 401);
        }

        $user = User::where('api_token', $token)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: Invalid token'
            ], 401);
        }

        if (now()->gt($user->api_token_expires_at)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: Token expired'
            ], 401);
        }
        $request->attributes->add(['user' => $user]);
        return $next($request);
    }
}
