<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Login\UserLoginRequest;
use App\Http\Requests\User\Login\UserValidateOtpRequest;
use App\Services\User\Auth\UserLoginServiceInterface;


class UserAuthController extends Controller
{
    public function __construct(private readonly UserLoginServiceInterface $userLoginService)
    {}

    public function login(UserLoginRequest $request)
    {
       return $this->userLoginService->login($request);
    }

    public function validate(UserValidateOtpRequest $request)
    {
        return $this->userLoginService->validate($request);
    }
}
