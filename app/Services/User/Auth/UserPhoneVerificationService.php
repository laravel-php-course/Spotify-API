<?php

namespace App\Services\User\Auth;

use App\Http\Requests\User\Verification\UserFormPhoneVerificationRequest;
use App\Http\Requests\User\Verification\UserPhoneVerificationRequest;
use App\Repositories\UserRepositoryInterface;
use App\Services\App\SmsOtpAppService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

readonly class UserPhoneVerificationService implements UserPhoneVerificationServiceInterface
{
    use ApiResponse;
    public function __construct(
        private SmsOtpAppService $smsOtpAppService,
        private UserRepositoryInterface $userRepository
    )
    {
        //
    }
    public function verifyPhoneSend(UserFormPhoneVerificationRequest $request): JsonResponse
    {
        $user = $this->userRepository->findByField('phone', $request->phone);
        if (!$user)
        {
            return self::error('phone not found', 404);
        }
        $sendOtp = $this->smsOtpAppService->send($request->phone, 'OTP code:');
        if (!$sendOtp)
        {
            return self::error('there is a problem, try again later', 500);
        }
        return self::success('OTP successfully sent',null,201);
    }

    public function verifyPhone(UserPhoneVerificationRequest $request): JsonResponse
    {
        $user = $this->userRepository->findByField('phone', $request->phone);
        $check = $this->smsOtpAppService->validateCode($request->phone,$request->otp);
        if (!$check)
        {
            return self::error('Invalid OTP',401);
        }
        $this->userRepository->update($user->id,[
            'phone_verified_at' => now()
        ]);
        return self::success('phone number verified successfully',null,200);
    }
}
