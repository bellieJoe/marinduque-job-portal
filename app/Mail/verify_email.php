<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class verify_email extends Mailable
{
    use Queueable, SerializesModels;

    

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($vcode)
    {
        //
        $this->vcode = $vcode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.verify_email')
        ->subject('Email Verification')
        ->with([
            'VerificationCode' => $this->vcode
        ]);
    }
}
