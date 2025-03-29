<?php

namespace App\Http;

use Illuminate\Http\Request;

class ResponseUtil
{
    private bool $success;
    private string $message;
    private  $data;
    private string $error;

    public static function Success($message, $data = null)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
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
