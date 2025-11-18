<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Login\AdminLoginRequest;
use App\Http\Requests\Admin\Verification\AdminFormPhoneVerificationRequest;
use App\Services\Admin\AdminAuthServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function __construct(
        private readonly AdminAuthServiceInterface $adminAuthService
    )
    {}
    public function login(AdminLoginRequest $request): JsonResponse
    {
       return $this->adminAuthService->login($request);
    }

    public function verifyPhone(AdminFormPhoneVerificationRequest $request): JsonResponse
    {
        return $this->adminAuthService->verifyPhone($request);
    }

    public function logout(Request $request)
    {
        return $this->adminAuthService->logout($request);
    }
}
