<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Login\UserLoginRequest;
use App\Http\Requests\User\Login\UserValidateOtpRequest;
use App\Http\Requests\User\Register\UserRegisterRequest;
use App\Http\Requests\User\Verification\UserEmailVerificationRequest;
use App\Http\Requests\User\Verification\UserFormEmailVerificationRequest;
use App\Http\Requests\User\Verification\UserFormPhoneVerificationRequest;
use App\Http\Requests\User\Verification\UserPhoneVerificationRequest;
use App\Services\User\Auth\UserEmailVerificationServiceInterface;
use App\Services\User\Auth\UserLoginServiceInterface;
use App\Services\User\Auth\UserLogoutServiceInterface;
use App\Services\User\Auth\UserPhoneVerificationServiceInterface;
use App\Services\User\Auth\UserRegisterServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class UserAuthController extends Controller
{
    public function __construct(
        private readonly UserLoginServiceInterface $userLoginService,
        private readonly UserRegisterServiceInterface $userRegisterService,
        private readonly UserEmailVerificationServiceInterface $userEmailVerificationService,
        private readonly UserPhoneVerificationServiceInterface $userPhoneVerificationService,
        private readonly UserLogoutServiceInterface $userLogoutService
    )
    {}

    public function login(UserLoginRequest $request): JsonResponse
    {
       return $this->userLoginService->login($request);
    }

    public function validate(UserValidateOtpRequest $request): JsonResponse
    {
        return $this->userLoginService->validate($request);
    }

    public function register(UserRegisterRequest $request): JsonResponse
    {
        return $this->userRegisterService->register($request);
    }

    public function verifyEmailSend(UserFormEmailVerificationRequest $request): JsonResponse
    {
        return $this->userEmailVerificationService->verifyEmailSend($request);
    }

    public function verifyPhoneSend(UserFormPhoneVerificationRequest $request): JsonResponse
    {
        return $this->userPhoneVerificationService->verifyPhoneSend($request);
    }

    public function verifyPhone(UserPhoneVerificationRequest $request): JsonResponse
    {
        return $this->userPhoneVerificationService->verifyPhone($request);
    }
    public function verifyEmail(UserEmailVerificationRequest $request): JsonResponse
    {
        return $this->userEmailVerificationService->verifyEmail($request);
    }

    public function logout(Request $request): JsonResponse
    {
        return $this->userLogoutService->logout($request);
    }
}
