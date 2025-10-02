<?php

namespace App\Services\User\Auth;

use App\Http\Requests\User\Verification\UserEmailVerificationRequest;
use App\Http\Requests\User\Verification\UserFormEmailVerificationRequest;
use App\Repositories\UserRepositoryInterface;
use App\Services\App\EmailOtpAppService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

readonly class UserEmailVerificationService implements UserEmailVerificationServiceInterface
{

    public function __construct(
        private EmailOtpAppService $emailOtpAppService,
        private UserRepositoryInterface $userRepository
    )
    {
        //
    }
    public function verifyEmailSend(UserFormEmailVerificationRequest $request): JsonResponse
    {
        $user = $this->userRepository->findByField('email', $request->email);
        if (!$user)
        {
            return ApiResponse::error('email not found',404);
        }
        $sendOtp = $this->emailOtpAppService->send($request->email,'OTP code:');
        if (!$sendOtp)
        {
           return ApiResponse::error('there is a problem, try again later', 500);
        }
        return ApiResponse::success('OTP successfully sent',null,201);
    }

    public function verifyEmail(UserEmailVerificationRequest $request): JsonResponse
    {
        $user = $this->userRepository->findByField('email', $request->email);
        $check = $this->emailOtpAppService->validateCode($request->email, $request->otp);
        if (!$check)
        {
            return ApiResponse::error('Invalid OTP',401);
        }
        $this->userRepository->update($user->id,[
            'email_verified_at' => now()
        ]);
        return ApiResponse::success('email verified successfully',null,200);
    }
}
