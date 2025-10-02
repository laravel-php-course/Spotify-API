<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Login\UserLoginRequest;
use App\Http\Requests\User\Login\UserValidateOtpRequest;
use App\Http\Requests\User\Register\UserRegisterRequest;
use App\Services\User\Auth\UserLoginServiceInterface;
use App\Services\User\Auth\UserRegisterServiceInterface;
use Illuminate\Http\JsonResponse;


class UserAuthController extends Controller
{
    public function __construct(
        private readonly UserLoginServiceInterface $userLoginService,
        private readonly UserRegisterServiceInterface $userRegisterService
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
}
