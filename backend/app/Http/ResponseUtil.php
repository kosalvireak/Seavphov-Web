<?php

namespace App\Http;

class ResponseUtil
{
    public static function Success($message, $data = null, $showToast = false, $toastType = 'success')
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'toast' => [
                'show' => $showToast,
                'type' => $toastType,
            ]
        ], 200);
    }



    public static function Unauthorized($message, $error = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $error
        ], 401);
    }


    public static function NoPermission($message = "No permission", $error = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $error
        ], 403);
    }


    public static function NotFound($message, $error = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $error
        ], 404);
    }


    public static function UnProcessable($message, $error = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $error
        ], 422);
    }



    public static function ServerError($message, $error = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $error
        ], 500);
    }
}
