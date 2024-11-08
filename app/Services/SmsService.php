<?php
namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public static function generateOtpCode()
    {
        return rand(10000, 99999);
    }

    public static function sendOtp(string $phoneNumber, int $code)
    {
        Cache::put('otp_' . $phoneNumber, $code, 300);

        $template = config('services.sms.template');
        $message = str_replace('{CODE}', $code, $template);

        try {
            $response = Http::withoutVerifying()->withHeaders(['Content-Type' => 'application/x-www-form-urlencoded'])
                ->post(config('services.sms.api'), [
                    'username' => config('services.sms.username'),
                    'password' => config('services.sms.password'),
                    'message' => $message,
                    'destination' => self::convertToIranFormat($phoneNumber),
                ]);

            if ($response->successful()) {
                return true;
            } else {
                Log::error('ارسال SMS ناموفق', ['response' => $response->body()]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('استثنای ارسال SMS', ['message' => $e->getMessage()]);
            return false;
        }
    }

    public static function convertToIranFormat($phoneNumber)
    {

        return $phoneNumber;
    }
}
