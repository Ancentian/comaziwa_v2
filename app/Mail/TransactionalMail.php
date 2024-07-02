<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransactionalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $message;

    /**
     * Create a new message instance.
     */
    public function __construct(string $subject, string $message)
    {
        $this->subject = $subject;
        $this->message = $message;
    }

    public function build()
    {
        $msg = $this->message;
        $subject = $this->subject;
        
        $from = env('MAIL_FROM_ADDRESS');
        
        return $this->from($from, env('MAIL_FROM_NAME'))
            ->subject($this->subject)
            ->view('emails.sendtransactionalmail',compact('msg','subject'));
    }
}

