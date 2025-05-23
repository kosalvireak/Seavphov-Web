<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BroadcastTokenAuth
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
            return response()->json(['message' => 'Unauthorized. No token. '], 401);
        }

        $user = User::where('api_token', $token)->first(); // or however you verify tokens

        if (!$user) {
            return response()->json(['message' => 'Unauthorized. Invalid token.'], 401);
        }

        // Auth::setUser($user); // required for Broadcast::channel closure
        auth()->setUser($user);

        return $next($request);
    }
}
