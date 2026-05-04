<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    public function success($results = null, string $message = ''): JsonResponse
    {
        return response()->json([
            'status'  => 1,
            'results' => $results,
            'message' => $message,
            'error'   => null,
        ]);
    }

    public function failure(string $message = '', string $error = '', int $code = 422): JsonResponse
    {
        return response()->json([
            'status'  => 0,
            'results' => null,
            'message' => $message,
            'error'   => $error,
        ], $code);
    }
}
