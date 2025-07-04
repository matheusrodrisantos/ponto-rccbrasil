<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

trait ResponseTrait
{
    protected function createErrorResponse(string $message, int $statusCode): JsonResponse
    {
        return new JsonResponse([
            'status' => 'error',
            'message' => $message,
        ], $statusCode);
    }

    protected function createSuccessResponse(array $data, int $statusCode = 200): JsonResponse
    {
        return new JsonResponse([
            'status' => 'success',
            'data' => $data,
        ], $statusCode);
    }
}