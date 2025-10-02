<?php

namespace App\Services\User\Auth;

use App\Enums\Database\SubscriptionTypeEnum;
use App\Http\Requests\User\Register\UserRegisterRequest;
use App\Repositories\UserRepositoryInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

readonly class UserRegisterService implements UserRegisterServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    )
    {

    }
    public function register(UserRegisterRequest $request): JsonResponse
    {
        try {
            $password = Hash::make($request->password);
            $user = $this->userRepository->create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'subscription_plan' => SubscriptionTypeEnum::FREE,
                'phone' => $request->phone ?? null,
                'email' => $request->email,
                'password' => $password,
            ]);
            $token = $user->createToken('auth_token')->plainTextToken;

            return ApiResponse::success(
                'user successfully registered',
                [
                    'user'  => $user,
                    'token' => $token,
                ],
                200
            );
        } catch (\Exception $e)
        {
            Log::error('User registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);            return ApiResponse::error(
                'Registration failed. Please try again later.',
                500,
                ['exception' => $e->getMessage()]
            );
        }
    }

}
