<?php

namespace App\Http\Controllers;

use App\Enums\AbilityiesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Jobs\SendEmailJob;
use App\Jobs\SendSmsJob;
use App\Models\User;
use App\Services\AbilityService;
use App\Services\SmsService;
use App\Services\VerificationService;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Trait\ApiResponse;
use Session;

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
        $user = $this->userRepository->LoginUser($request->all());
        if ($user !== false) {

            dispatch(new SendSmsJob($user));
            VerificationService::set('user' , $user);

        }
if ($user == false){
        return response()->json(['message' => __('http_error_messages.form_authentication')], 401);}
    }

    public function codeVerify(Request $request)
    {
        $user = VerificationService::get('user');

        if ($request->code == VerificationService::get($user->mobile)){
            return $this->success(__('http_success_messages.form_login_success'), [
                'access_token'  => $user->createToken('access token for user', AbilityService::getAbiliteis($user->role), now()->addDays(config('auth.token.access_expire')))->plainTextToken,
                'refresh_token' => $user->createToken('refresh token for user', [AbilityiesEnum::REFRESH_TOKEN->value], now()->addDays(config('auth.token.access_expire')))->plainTextToken,
                'user'          => $user
            ]);
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
