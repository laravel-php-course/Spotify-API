<?php

namespace App\Exceptions;

use App\Trait\ApiResponse;
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
    use ApiResponse;

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
            \Log::error('Exception occurred: ', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
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

        if ($throwable instanceof InvalidRoleException) {
            return $this->handleInvalidRoleException($throwable);
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

        if ($throwable instanceof CustomException) {
            return $this->handleCustomException($throwable);
        }

        return $this->handleGeneralException($throwable);
    }

    // ModelNotFoundException (404)
    protected function handleModelNotFoundException(ModelNotFoundException $e): JsonResponse
    {
        return $this->error(__('http_error_messages.form_model_not_Found'), 404);
    }

    // ValidationException (422)
    protected function handleValidationException(ValidationException $e): JsonResponse
    {
        return $this->error(__('http_error_messages.form_validation_error'), 422, [
            'errors' => $e->errors(),
            'message' => __('http_error_messages.form_validation_error'),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }

    // InvalidRoleException (400)
    protected function handleInvalidRoleException(InvalidRoleException $e): JsonResponse
    {
        return $this->error($e->getMessage() ?: __('http_error_messages.InvalidRole'), 400);
    }

    // Custom Exception (400)
    protected function handleCustomException(CustomException $e): JsonResponse
    {
        return $this->error($e->getMessage() ?: __('http_error_messages.bad_request'), 400);
    }

    // AuthorizationException (403)
    protected function handleAuthorizationException(AuthorizationException $e): JsonResponse
    {
        return $this->error(__('http_error_messages.form_authorization'), 403);
    }

    // AuthenticationException (401)
    protected function handleAuthenticationException(AuthenticationException $e): JsonResponse
    {
        return $this->error(__('http_error_messages.form_authentication'), 401);
    }

    // HttpException (e.g., 404, 500)
    protected function handleHttpException(HttpException $e): JsonResponse
    {
        return $this->error($e->getMessage() ?: __('http_error_messages.form_http'), $e->getStatusCode());
    }

    // General exception (500)
    protected function handleGeneralException(Throwable $e): JsonResponse
    {
        return $this->error(__('http_error_messages.form_General'), 500);
    }
}
