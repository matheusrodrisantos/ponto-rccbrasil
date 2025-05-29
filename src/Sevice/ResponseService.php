<?php

namespace App\Sevice;

use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseService extends JsonResponse
{

    public function createErrorResponse(string $message, int $statusCode): JsonResponse
    {
        return new JsonResponse([
            'status' => 'error',
            'message' => $message,
        ], $statusCode);
    }

    public function createSuccessResponse(array $data, int $statusCode = 200): JsonResponse
    {
        return new JsonResponse([
            'status' => 'success',
            'data' => $data,
        ], $statusCode);
    }
}
