<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Kavenegar\KavenegarApi;

class SendOtpJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $receiver,
        public string $message,
        public string $type // sms , email
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->type === 'email')
        {
            Mail::raw($this->message, function ($mail) {
                $mail->to($this->receiver)->subject('you OTP code');
            });
        }

        if ($this->type === 'sms') {
                $api = new KavenegarApi(config('services.kavenegar.api_key'));
                $sender   = config('services.kavenegar.sender');
                $receptor = $this->receiver;
                $message  = $this->message;

                $api->Send($sender, $receptor, $message);
        }
    }
}
