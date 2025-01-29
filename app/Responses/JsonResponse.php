<?php

namespace App\Responses;

class JsonResponse
{
    public static function success(string $message, array $data = [], int $statusCode = 200)
    {
        http_response_code($statusCode);

        echo json_encode([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], JSON_PRETTY_PRINT);

    }

    public static function error(string $error, string $input, int $statusCode = 400)
    {
        http_response_code($statusCode);
        
        echo json_encode([
            'status' => 'error',
            'message' => $error,
            'input' => $input,
        ], JSON_PRETTY_PRINT);
    }
}
