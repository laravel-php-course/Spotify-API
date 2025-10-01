<?php

namespace App\Services\User\Auth;

use App\Http\Requests\User\Login\UserLoginRequest;
use App\Repositories\UserRepositoryInterface;
use App\Services\App\EmailOtpAppService;
use App\Services\App\SmsOtpAppService;
use Illuminate\Http\JsonResponse;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

readonly class UserLoginService implements UserLoginServiceInterface
{
    public function __construct(
        private EmailOtpAppService      $emailOtpAppService,
        private SmsOtpAppService        $smsOtpAppService,
        private UserRepositoryInterface $userRepository
    )
    {}

    public function login(UserLoginRequest $request): JsonResponse
    {
        // login by username and password
        if (isset($request->username))
        {
            $user = $this->userRepository->findByField('username', $request->username);
            if (!$user) {
                return ApiResponse::error('username not found', 404);
            }

            if (!Hash::check($request->password, $user->password)) {
                return ApiResponse::error('password or username is not current', 401);
            }

            Auth::login($user);
            $token = $user->createToken("user_api_token")->plainTextToken;

            return ApiResponse::success('login successfully', [
                'id'    => $user->id,
                'data' => $token,
                'password' => $user->password,
            ]);

        }

        // login by phone number
        if (isset($request->phone))
        {
            $user = $this->userRepository->findByField('phone' , $request->phone);
            if (!$user)
            {
                return ApiResponse::error('phone number not found', 404);
            }
            $this->smsOtpAppService->send($request->phone , 'OTP code');
            return ApiResponse::success('OTP code successfully sent' , null,200);
        }

        // login by email
        if (isset($request->email))
        {
            $user = $this->userRepository->findByField('email' , $request->email);
            if (!$user)
            {
                return ApiResponse::error('email not found' , 404);
            }
            $this->emailOtpAppService->send($request->email, 'OTP code');
            return ApiResponse::success('OTP code successfully sent' , null,200);
        }
        return ApiResponse::error('there is a problem, try again later', 500, null);
    }

    public function validate($request): JsonResponse
    {
        // email otp validation
        if (isset($request->email)) {
            $user = $this->userRepository->findByField('email', $request->email);
            $receiver = $this->emailOtpAppService->validateCode($request->email, $request->otp);
            if (!$receiver) {
                return ApiResponse::error('OTP code is invalid', 401);
            }
            Auth::login($user);
            $token = $user->createToken('user_api_token')->plainTextToken;
            return ApiResponse::success(
                'login successfully',
                ['data' => $token],
                200);
        }

        // phone otp validation
        if (isset($request->phone))
        {
            // TODO complete it
        }
        return ApiResponse::error('there is a problem, try again later', 500, null);
    }


}
