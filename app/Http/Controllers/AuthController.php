<?php

namespace App\Http\Controllers;

use App\Enums\AbilityiesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Jobs\SendEmailJob;
use App\Models\User;
use App\Services\AbilityService;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Trait\ApiResponse;

class AuthController extends Controller
{
    //TODO:DONE DRY For Token Response
    use ApiResponse;
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function register(RegisterUserRequest $request)

    {
        try {
            $user          = $this->userRepository->create($request->only(['email','password','mobile','username']));
            dispatch(new SendEmailJob($user));
            return $this->tokenResponse($user);

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), 500);
        }
    }

    public function login(LoginRequest $request)
    {
        $user = $this->userRepository->LoginUser($request->all());

        if ($user !== false) {
            return $this->tokenResponse($user);
        }

        return $this->error('رمز عبور غلط است' , 401);
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return $this->success('Logout successful', []);
        } catch (\Exception $exception) {
            return $this->error('Logout failed: ' . $exception->getMessage(), 500);
        }
    }


    public function refresh(Request $request)
    {
        try {
            $user = $request->user();
            $newAccessToken = $user->createToken('access token for user', AbilityService::getAbiliteis($user->role), now()->addDays(config('auth.token.access_expire')))->plainTextToken;
            $newRefreshToken = $user->createToken('refresh token for user', [AbilityiesEnum::REFRESH_TOKEN->value], now()->addDays(config('auth.token.refresh_expire')))->plainTextToken;

            return $this->success('Tokens refreshed successfully.', [
                'access_token' => $newAccessToken,
                'refresh_token' => $newRefreshToken,
            ]);
        } catch (\Exception $exception) {
            return $this->error('Failed to refresh tokens: ' . $exception->getMessage(), 500);
        }
    }



    public function verify($id, Request $request)
    {
        if (!$request->hasValidSignature())
        {
            return $this->error('Invalid/Expired url verification.', 400);
        }

        $user = User::findOrFail($id);

        if (!$user->hasVerifiedEmail())
        {
            $user->markEmailAsVerified();
        }

        return $this->success('your email is verified.');
    }
}
