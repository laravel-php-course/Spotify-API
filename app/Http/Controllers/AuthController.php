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
    //TODO DRY For Token Response
    use ApiResponse;
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function register(RegisterUserRequest $request)

    {
        try {
            $start_user    = microtime(true);
            $user          = $this->userRepository->create($request->only(['email','password','mobile','username']));
            $end_user_time = microtime(true) - $start_user;

            $start_email   = microtime(true);
            dispatch(new SendEmailJob($user));
            $end_email_time = microtime(true) - $start_email;

            return $this->success(__("http_success_messages.form_register_success"), [
                'access_token' => $user->createToken('access token for user', AbilityService::getAbiliteis($user->role), now()->addDays(config('auth.token.access_expire')))->plainTextToken,
                'refresh_token' => $user->createToken('refresh token for user', [AbilityiesEnum::REFRESH_TOKEN->value], now()->addDays(config('auth.token.access_expire')))->plainTextToken,
                'user'  => $user,
                'time' => [
                    'email'=>$end_email_time,
                    'user' => $end_user_time
                ]
            ]);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage() ?:__('http_error_messages.server_problem'), 500);
        }
    }

    public function login(LoginRequest $request)
    {
        $phoneNumber = $request->input('phone_number');
        $user = $this->userRepository->getUserByPhone($phoneNumber);

        if ($user) {
            $otpCode = SmsService::generateOtpCode();
            if (SmsService::sendOtp($phoneNumber, $otpCode)) {
                Cache::put('otp_' . $phoneNumber, $otpCode, 300);
                return response()->json(['message' => __('http_success_messages.otp_sent')]);
            }
            return response()->json(['message' => __('http_error_messages.sms_failed')], 500);
        }

        return response()->json(['message' => __('http_error_messages.form_authentication')], 401);
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return $this->success(ــ('http_success_messages.logout_success'), []);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage() ?:__("http_error_messages.invalid_password"), 401);
        }
    }


    public function refresh(Request $request)
    {
        try {
            $user = $request->user();
            $newAccessToken = $user->createToken('access token for user', AbilityService::getAbiliteis($user->role), now()->addDays(config('auth.token.access_expire')))->plainTextToken;
            $newRefreshToken = $user->createToken('refresh token for user', [AbilityiesEnum::REFRESH_TOKEN->value], now()->addDays(config('auth.token.refresh_expire')))->plainTextToken;

            return $this->success(__('http_success_messages.refresh_token_success'), [
                'access_token' => $newAccessToken,
                'refresh_token' => $newRefreshToken,
            ]);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage() ?:__('http_error_messages.refresh_token_error'), 500);
        }
    }



    public function verify($id, Request $request)
    {
        if (!$request->hasValidSignature())
        {
            return $this->error(__('http_error_messages.url_error'), 400);
        }

        $user = User::findOrFail($id);

        if (!$user->hasVerifiedEmail())
        {
            $user->markEmailAsVerified();
        }

        return $this->success('http_success_messages.email_verify_success');
    }
}
