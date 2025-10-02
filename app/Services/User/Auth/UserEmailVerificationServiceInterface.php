<?php

namespace App\Services\User\Auth;

use App\Http\Requests\User\Verification\UserEmailVerificationRequest;
use App\Http\Requests\User\Verification\UserFormEmailVerificationRequest;
use Illuminate\Http\JsonResponse;

interface UserEmailVerificationServiceInterface
{
    /**
     * @param UserFormEmailVerificationRequest $request
     * @return JsonResponse
     */
    public function verifyEmailSend(UserFormEmailVerificationRequest $request): JsonResponse;

    /**
     * @param UserEmailVerificationRequest $request
     * @return JsonResponse
     */
    public function verifyEmail(UserEmailVerificationRequest $request): JsonResponse;
}
