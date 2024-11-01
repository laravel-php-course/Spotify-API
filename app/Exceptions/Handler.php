<?php

namespace App\Exceptions;

use App\trait\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;
use Illuminate\Http\JsonResponse;

class Handler extends ExceptionHandler
{
    use ApiResponse; //TODO
    //TODO Log Exception with best practice formate;
    //TODO Koroush Localization All messages

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $throwable): JsonResponse
    {
        if ($throwable instanceof ModelNotFoundException || $throwable instanceof NotFoundHttpException) {
            return $this->handleModelNotFoundException($throwable);
        }

        if ($throwable instanceof ValidationException) {
            return $this->handleValidationException($throwable);
        }

        if ($throwable instanceof AuthorizationException) {
            return $this->handleAuthorizationException($throwable);
        }

        if ($throwable instanceof AuthenticationException) {
            return $this->handleAuthenticationException($throwable);
        }

        if ($throwable instanceof HttpException) {
            return $this->handleHttpException($throwable);
        }

        return $this->handleGeneralException($throwable);
    }

    // ModelNotFoundException (404)
    protected function handleModelNotFoundException(ModelNotFoundException $e): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Resource not found.',
            'errors'  => [],
            'data'    => [],
            'code'    => 404,
        ], 404);
    }

    // ValidationException (422)
    protected function handleValidationException(ValidationException $e): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => __('http_error_messages.form_validation_error'),
            'errors'  => $e->errors(), // Return validation errors
            'data'    => [],
            'code'    => 422,
        ], 422);
    }

    // AuthorizationException (403)
    protected function handleAuthorizationException(AuthorizationException $e): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'You are not authorized to perform this action.',
            'errors'  => [],
            'data'    => [],
            'code'    => 403,
        ], 403);
    }

    // AuthenticationException (401)
    protected function handleAuthenticationException(AuthenticationException $e): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Authentication failed.',
            'errors'  => [],
            'data'    => [],
            'code'    => 401,
        ], 401);
    }

    // HttpException (e.g., 404, 500)
    protected function handleHttpException(HttpException $e): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage() ?: 'HTTP error occurred.',
            'errors'  => [],
            'data'    => [],
            'code'    => $e->getStatusCode(),
        ], $e->getStatusCode());
    }

    // General exception (500)
    protected function handleGeneralException(Throwable $e): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred. Please try again later.',
            'errors'  => [],
            'data'    => [],
            'code'    => 500,
        ], 500);
    }
}
