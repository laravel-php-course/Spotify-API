<?php

namespace App\Services\User\Auth;

use App\Http\Requests\User\Verification\UserFormPhoneVerificationRequest;
use App\Http\Requests\User\Verification\UserPhoneVerificationRequest;
use Illuminate\Http\JsonResponse;

interface UserPhoneVerificationServiceInterface
{
    /**
     * @param UserFormPhoneVerificationRequest $request
     * @return JsonResponse
     */
    public function verifyPhoneSend(UserFormPhoneVerificationRequest $request): JsonResponse;

    /**
     * @param UserPhoneVerificationRequest $request
     * @return JsonResponse
     */
    public function verifyPhone(UserPhoneVerificationRequest $request): JsonResponse;
}
