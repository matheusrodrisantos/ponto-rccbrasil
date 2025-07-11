<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseService extends JsonResponse
{

    public function createErrorResponse(string $message, int $statusCode): self
    {
        return new self([
            'status' => 'error',
            'message' => $message,
        ], $statusCode);
    }

    public function createSuccessResponse(array $data, int $statusCode = 200): self
    {
        return new self([
            'status' => 'success',
            'data' => $data,
        ], $statusCode);
    }
}
