<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\Login\AdminLoginRequest;
use App\Http\Requests\Admin\Verification\AdminFormPhoneVerificationRequest;
use App\Repositories\AdminRepositoryInterface;
use App\Services\App\SmsOtpAppService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminAuthService implements AdminAuthServiceInterface
{
    use ApiResponse;
    public function __construct(
        private readonly AdminRepositoryInterface $adminRepository,
        private readonly SmsOtpAppService $smsOtpAppService
    )
    {}

    public function login(AdminLoginRequest $request): JsonResponse
    {
        $admin = $this->adminRepository->findByField('phone', $request->phone);
        if (!$admin)
        {
            return self::error('phone not found', 404);
        }

        $sendOtp = $this->smsOtpAppService->send($request->phone, "Your OTP code: ");
        if (!$sendOtp)
        {

            return self::error('try again later', 500);
        }

        return self::success('Otp code sent successfully',null ,200);
    }

    public function verifyPhone(AdminFormPhoneVerificationRequest $request): JsonResponse
    {
        $admin = $this->adminRepository->findByField('phone',$request->phone);
        if (!$admin)
        {
            return self::error('something went wrong , try again later' , 500 ,null);
        }

        $checkOtp = $this->smsOtpAppService->validateCode($request->phone, $request->otp);
        if (!$checkOtp)
        {
           return self::error('OTP code is invalid', 401);
        }

        $token = $admin->createToken('admin_api_token')->plainTextToken;
        return self::success('admin login successfully', ["data" => $token],200);
    }

    public function logout(Request $request): JsonResponse
    {
        if ($request->user() && $request->user()->currentAccessToken())
        {
            $request->user()->currentAccessToken()->delete();
        }
        return self::success('admin logout successfully', null, 200);
    }
}
