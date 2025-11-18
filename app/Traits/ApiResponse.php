<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    public static function success(string $message, array|null $data, int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message'=> $message,
            'data' => $data,
            'errors'=> [],
            'code' => $code
        ], $code);
    }

    public static function error(string $message, int $code, array|null $error = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message'=> $message,
            'data' => [],
            'errors' => $error,
            'code' => $code
        ], $code);
    }
}
