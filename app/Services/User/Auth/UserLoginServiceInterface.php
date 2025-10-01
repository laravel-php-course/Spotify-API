<?php

namespace App\Services\User\Auth;

use App\Http\Requests\User\Login\UserLoginRequest;
use App\Http\Requests\User\Login\UserValidateOtpRequest;
use Illuminate\Http\JsonResponse;

interface UserLoginServiceInterface
{
    /**
     * login users
     * @param UserLoginRequest $request
     * @return JsonResponse
     */
    public function login(UserLoginRequest $request): JsonResponse;

    /**
     * validate otp
     * @param UserValidateOtpRequest $request
     * @return JsonResponse
     */
    public function validate(UserValidateOtpRequest $request): JsonResponse;
}
