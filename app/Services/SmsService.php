<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsService
{
    public static function genrateOtpCode()
    {
        return random_int(1000, 9999);
    }

    public static function convertToIranFormat($mobileNumber)
    {
        $mobileNumber = preg_replace('/\D/', '', $mobileNumber);

        if (substr($mobileNumber, 0, 2) === '09') {
            return '98' . substr($mobileNumber, 1);
        }
        elseif (substr($mobileNumber, 0, 3) === '989') {
            return $mobileNumber;
        }
        elseif (substr($mobileNumber, 0, 4) === '+989') {
            return substr($mobileNumber, 1);
        }
        else {
            return false;
        }
    }

    public static function sendOtp(string $phoneNumber, int $code)
    {
        $template = config('services.sms.template');
        $search   = ['{CODE}'];
        $replace  = [$code];
        $msg      = str_replace($search , $replace , $template);
        $response = Http::withoutVerifying()->withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])->asForm()->post(config('services.sms.api'), [
                'username'    => config('services.sms.username'),
                'password'    => config('services.sms.password'),
                'source'      => config('services.sms.source'),
                'message'     => $msg,
                'destination' => self::convertToIranFormat($phoneNumber)
        ]);
        $msgId = $response->body();

        return $response->body();
    }
}
