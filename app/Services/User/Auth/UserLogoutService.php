<?php

namespace App\Services\User\Auth;

use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLogoutService implements UserLogoutServiceInterface
{

    public function logout(Request $request): JsonResponse
    {
        if ($request->user() && $request->user()->currentAccessToken())
        {
            $request->user()->currentAccessToken()->delete();
        }
        return ApiResponse::success('user logout successfully', null, 200);
    }
}
