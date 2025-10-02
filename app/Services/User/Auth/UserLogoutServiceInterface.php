<?php

namespace App\Services\User\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface UserLogoutServiceInterface
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse;
}
