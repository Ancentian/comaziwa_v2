<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;


    public $resetLink;
    public $data;

    public function __construct(string $resetLink, array $data)
    {
        $this->resetLink = $resetLink;
        $this->data = $data;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject('Password Reset')
            ->view('emails.reset_password')
            ->with([
                'resetLink' => $this->resetLink,
                'data' => $this->data,
            ]);
    }
}
