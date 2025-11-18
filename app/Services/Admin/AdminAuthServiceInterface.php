<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\Login\AdminLoginRequest;
use App\Http\Requests\Admin\Verification\AdminFormPhoneVerificationRequest;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface AdminAuthServiceInterface
{
    /**
     * Attempt to login admin and return token
     * @param AdminLoginRequest $request
     * @return JsonResponse
     */
    public function login(AdminLoginRequest $request): JsonResponse;

    /**
     * Logout admin (delete all tokens)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse;

    /**
     * otp verification
     * @param AdminFormPhoneVerificationRequest $request
     * @return JsonResponse
     */
    public function verifyPhone(AdminFormPhoneVerificationRequest $request): JsonResponse;
}
