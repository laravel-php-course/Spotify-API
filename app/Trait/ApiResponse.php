<?php

namespace App\trait;

use App\Enums\AbilityiesEnum;
use App\Services\AbilityService;

trait ApiResponse
{
    public function success(string $message,array $data = [], int $code = 200){
        return response()->json([
            'success' => true,
            'message'=> $message,
            'data' => $data,
            'errors'=>[],
            'code' => $code
        ],$code);
    }
    public function error(string $message, int $code ,array $errors = []){
        return response()->json([
            'success' => false,
            'message'=> $message,
            'data' => [],
            'errors'=>$errors,
            'code' => $code
        ],$code);
    }
    public function tokenResponse($user){
        return $this->success('به اپلیکیشن ما خوش آمدید. شما ثبت‌نام شده‌اید، لطفاً ایمیل خود را برای تأیید بررسی کنید.', [
            'access_token' => $user->createToken('access token for user', AbilityService::getAbiliteis($user->role), now()->addDays(config('auth.token.access_expire')))->plainTextToken,
            'refresh_token' => $user->createToken('refresh token for user', [AbilityiesEnum::REFRESH_TOKEN->value], now()->addDays(config('auth.token.access_expire')))->plainTextToken,
            'user'  => $user,
        ]);
    }

}
