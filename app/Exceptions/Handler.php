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
    use ApiResponse;
    //TODO Log Exception with best practice formate;

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

        if ($throwable instanceof InvalidRoleException) {
            return $this->handleInvalidRoleExceptionException($throwable);
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
        return $this->error(__('http_error_messages.form_model_not_Found'), 404 );
    }

    // ValidationException (422)
    protected function handleValidationException(ValidationException $e): JsonResponse
    {
        return $this->error(__('http_error_messages.form_validation_error'), 422 , $e->errors());
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
        return $this->error($e->getMessage() ?:__('http_error_messages.form_http'), $e->getStatusCode()  );
    }

    // General exception (500)
    protected function handleGeneralException(Throwable $e): JsonResponse
    {
        return $this->error(__('http_error_messages.form_General'), 500 );
    }

    private function handleInvalidRoleExceptionException(Throwable $e): JsonResponse
    {
        return $this->error($e->getMessage() ?:__('http_error_messages.InvalidRole'), 400 );
    }
}
