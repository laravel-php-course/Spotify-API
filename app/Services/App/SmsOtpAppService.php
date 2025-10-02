<?php

namespace App\Services\App;

use App\Jobs\SendOtpJob;
use Kavenegar\KavenegarApi;

class SmsOtpAppService extends AbstractOtpAppService
{
    public function send(string $receiver, string $message): bool
    {
        try {
            $code = $this->generateCode($receiver);
            $text = $message . ' ' . $code;
            SendOtpJob::dispatch($receiver, $text, 'sms');
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
