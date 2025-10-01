<?php

namespace App\Services\App;

use Illuminate\Support\Facades\Cache;

abstract class AbstractOtpAppService
{
    private int $length;
    private int $ttl;
    public function __construct()
    {
        $this->length = config('app.otp_length_integer');
        $this->ttl = config('app.otp_expired_time');
    }
    protected function generateCode(string $receiver, ?int $length = null, ?int $ttl = null): string
    {
        $length = $length ?? $this->length;
        $ttl = $ttl ?? $this->ttl;
        $code = str_pad(
            (string)random_int(0,pow(10,$length) - 1),
            $length,
            '0',
            STR_PAD_LEFT
        );

        Cache::put("otp_{$receiver}", $code,$ttl);

        return $code;
    }

    public function validateCode(string $receiver, string $code): bool
    {
        return Cache::get("otp_{$receiver}") === $code;
    }

    abstract public function send(string $receiver, string $message): bool;
}
