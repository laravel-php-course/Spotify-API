<?php

namespace App\Services\User\Auth;

use App\Http\Requests\User\Register\UserRegisterRequest;
use Illuminate\Http\JsonResponse;

interface UserRegisterServiceInterface
{
    /**
     * @param UserRegisterRequest $request
     * @return JsonResponse
     */
    public function register(UserRegisterRequest $request): JsonResponse;
}
