<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public static function generateOtpCode()
    {
        return random_int(1000, 9999);
    }

    public static function convertToIranFormat($mobileNumber)
    {
        $mobileNumber = preg_replace('/\D/', '', $mobileNumber);
        if (substr($mobileNumber, 0, 2) === '09') {
            return '98' . substr($mobileNumber, 1);
        } elseif (substr($mobileNumber, 0, 3) === '989') {
            return $mobileNumber;
        } elseif (substr($mobileNumber, 0, 4) === '+989') {
            return substr($mobileNumber, 1);
        } else {
            return false; // فرمت نامعتبر
        }
    }

    public static function sendOtp(string $phoneNumber, int $code)
    {
        $template = config('services.sms.template');
        $message = str_replace('{CODE}', $code, $template);

        try {
            $response = Http::withoutVerifying()->post(config('services.sms.api'), [
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
}
