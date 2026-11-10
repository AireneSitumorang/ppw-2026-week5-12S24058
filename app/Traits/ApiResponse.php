<?php
namespace App\Traits;

trait ApiResponse
{
    protected function successResponse(
        mixed $data,
        string $message = 'Request berhasil',
        int $statusCode = 200
    ) {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    protected function errorResponse(
        string $message,
        int $statusCode = 400,
        mixed $errors = null
    ) {
        $titles = [
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            409 => 'Conflict',
            422 => 'Unprocessable Entity',
            429 => 'Too Many Requests',
            500 => 'Internal Server Error',
        ];

        $problem = [
            'type' => 'about:blank',
            'title' => $titles[$statusCode] ?? 'HTTP Error',
            'status' => $statusCode,
            'detail' => $message,
            'instance' => request()->getRequestUri(),
        ];

        if ($errors !== null) {
            $problem['errors'] = $errors;
        }

        return response()->json(
            $problem,
            $statusCode,
            ['Content-Type' => 'application/problem+json']
        );
    }
}