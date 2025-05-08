<?php

namespace App\Http\Middleware;

use App\Http\ResponseUtil;
use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="Token"
 * )
 */

class ApiTokenAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {

            $token = $request->bearerToken();
            if (!$token) {
                return ResponseUtil::Unauthorized('Unauthorized: Missing token');
            }

            $user = User::where('api_token', $token)->first();

            if (!$user) {
                return ResponseUtil::Unauthorized('Unauthorized: Invalid token');
            }

            if (now()->gt($user->api_token_expires_at)) {
                return ResponseUtil::Unauthorized('Unauthorized: Token expired');
            }
            $request->attributes->add(['user' => $user]);

            return $next($request);
        } catch (Exception $e) {
            return ResponseUtil::ServerError('Something went wrong with token!', [], $e->getMessage());
        }
    }
}
