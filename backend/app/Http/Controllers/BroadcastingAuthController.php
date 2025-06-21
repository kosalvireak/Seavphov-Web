<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;

class BroadcastingAuthController extends Controller
{
    public function authenticate(Request $request): JsonResponse
    {
        try {
            // Log the request for debugging
            Log::info('Broadcasting auth request', [
                'headers' => $request->headers->all(),
                'data' => $request->all()
            ]);

            // Get the Authorization header
            $authHeader = $request->header('Authorization');

            if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
                return response()->json(['error' => 'Unauthorized - No token provided'], 401);
            }

            // Extract JWT token
            $token = str_replace('Bearer ', '', $authHeader);

            $user = User::where('api_token', $token)->first();

            if (!$user) {
                return response()->json(['error' => 'Unauthorized: Invalid token'], 401);
            }

            if (now()->gt($user->api_token_expires_at)) {
                return response()->json(['error' => 'Unauthorized: Token expired'], 401);
            }

            // Get channel name and socket ID from request
            $channelName = $request->input('channel_name');
            $socketId = $request->input('socket_id');

            if (!$channelName || !$socketId) {
                return response()->json(['error' => 'Missing channel_name or socket_id'], 400);
            }

            // Check if user is authorized for this private channel
            if ($this->isUserAuthorizedForChannel($user, $channelName)) {
                // Generate Pusher/Reverb auth signature
                $authSignature = $this->generateAuthSignature($socketId, $channelName);

                return response()->json([
                    'auth' => $authSignature,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'uuid' => $user->uuid ?? null,
                    ]
                ]);
            }

            return response()->json(['error' => 'Unauthorized for this channel'], 403);
        } catch (Exception $e) {
            return response()->json(['error' => 'Authentication failed: ' . $e->getMessage()], 401);
        }
    }


    private function isUserAuthorizedForChannel(User $user, string $channelName): bool
    {
        // Remove 'private-' prefix from channel name
        $channelName = str_replace('private-', '', $channelName);

        // Check different channel patterns
        if (str_starts_with($channelName, 'users.')) {
            // Channel: users.{uuid}
            $userUuid = str_replace('users.', '', $channelName);
            return $user->uuid === $userUuid;
        }

        if (str_starts_with($channelName, 'user.')) {
            // Channel: user.{id}
            $userId = str_replace('user.', '', $channelName);
            return (string)$user->id === $userId;
        }

        // Add more channel authorization rules as needed
        // Example: posts.{postId} - check if user owns the post
        // if (str_starts_with($channelName, 'posts.')) {
        //     $postId = str_replace('posts.', '', $channelName);
        //     return $user->posts()->where('id', $postId)->exists();
        // }

        return false;
    }

    private function generateAuthSignature(string $socketId, string $channelName): string
    {
        // Get your Reverb/Pusher credentials
        $appKey = env('PUSHER_APP_KEY', config('broadcasting.connections.reverb.app_key'));
        $appSecret = env('PUSHER_APP_SECRET', config('broadcasting.connections.reverb.app_secret'));

        // Create the string to sign
        $stringToSign = $socketId . ':' . $channelName;

        // Generate HMAC signature
        $signature = hash_hmac('sha256', $stringToSign, $appSecret);

        // Return in Pusher format
        return $appKey . ':' . $signature;
    }
}
