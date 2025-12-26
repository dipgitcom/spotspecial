<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
      public $user;
    public function __construct($user)
    {
        $this->user = $user;
    }

   public function build(){
    return $this->subject('Forget Password Mail')
                    ->view('backend.layouts.email_otp_mail.forgetpassword',with(['user'=>$this->user]));
   }
}
