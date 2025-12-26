<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactSubmissionMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;   // name, email, phone, area, spots, description
    }

    public function build()
    {
        return $this
            ->subject('New Contact Submission')
            ->view('backend.layouts.emails.contact_submission');
    }
}
