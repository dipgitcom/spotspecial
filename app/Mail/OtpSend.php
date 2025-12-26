<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpSend extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build(){
    return $this->subject('Forget Password Mail')
                    ->view('backend.layouts.email_otp_mail.email_otp_mail',with(['user'=>$this->user]));
   }
}
