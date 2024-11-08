<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class CustomException extends Exception
{
    protected $statusCode;

    // Constructor to initialize the exception message and status code
    public function __construct($message = "An error occurred.", $statusCode = 400)
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
    }

    // Method to get the status code
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    // Method to log the exception details
    public function report()
    {
        \Log::error('Custom Exception: ' . $this->getMessage(), [
            'code' => $this->getCode(),
            'status' => $this->getStatusCode(),
            'file' => $this->getFile(),
            'line' => $this->getLine(),
            'trace' => $this->getTraceAsString(),
        ]);
    }

    // Method to render the response for this exception
    public function render($request): JsonResponse
    {
        return response()->json([
            'error' => [
                'message' => $this->getMessage(),
                'code' => $this->getStatusCode(),
            ]
        ], $this->getStatusCode());
    }
}
