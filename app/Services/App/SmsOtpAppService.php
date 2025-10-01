<?php

namespace App\Services\App;

class SmsOtpAppService extends AbstractOtpAppService
{

    public function send(string $receiver, string $message): bool
    {
        try {

            return true;
        } catch (\Exception $e){
            return false;
        }

    }
}
