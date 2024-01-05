<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Throwable;

trait ResponseTrait
{
    /**
     * @param array|null $datas
     * @return JsonResponse
     */
    public function successResponse(?array $datas): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $datas,
        ]);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    public function errorResponse(string $message): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 500);
    }
}
