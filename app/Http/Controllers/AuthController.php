<?php

namespace App\Http\Controllers;

use App\Enums\AbilityiesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\loginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Jobs\SendEmailJob;
use App\Models\User;
use App\Services\AbilityService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Trait\ApiResponse;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(private UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function register(RegisterUserRequest $request)

    {
        try {
            $start_user = microtime(true);
            $user = $this->userRepository->create($request->all()); //TODO BABACK use only() instead of all()
            $end_user_time = microtime(true) - $start_user;
            $start_email = microtime(true);
            dispatch(new SendEmailJob($user)) ; //TODO:DONE implement with job queue async
            $end_email_time = microtime(true) - $start_email;

            return $this->success('Welcome to our app. You are registered please check your email for verifications.', [
                'access_token' => $user->createToken('access token for user', AbilityService::getAbiliteis($user->role), now()->addDays(config('auth.token.access_expire')))->plainTextToken,
                'refresh_token' => $user->createToken('refresh token for user', [AbilityiesEnum::REFRESH_TOKEN->value], now()->addDays(config('auth.token.access_expire')))->plainTextToken,
                'user'  => $user,
                'time' => [
                    'email'=>$end_email_time,
                    'user' => $end_user_time
                ]
            ]);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), 500);
        }
    }

    public function login(loginRequest $request)
    {
        $user = $this->userRepository->LoginUser($request->all());

        if ($user !== false) {
            return $this->success('welcome to our apps. you are login', [
                'access_token' => $user->createToken('access token for user', AbilityService::getAbiliteis($user->role), now()->addDays(config('auth.token.access_expire')))->plainTextToken,
                'refresh_token' => $user->createToken('refresh token for user', [AbilityiesEnum::REFRESH_TOKEN->value], now()->addDays(config('auth.token.access_expire')))->plainTextToken,
                'user'  => $user
            ]); }else{
            return $this->error('رمز عبور غلط است' , 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            if (!$request->user()) {
                return $this->error('User not authenticated.', 401);
            }

            $request->user()->currentAccessToken()->delete();

            return $this->success('Logout successful', []);
        } catch (\Exception $exception) {
            return $this->error('Logout failed: ' . $exception->getMessage(), 500);
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
