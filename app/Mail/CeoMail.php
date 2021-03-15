<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CeoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData, $mailfilespath)
    {
        $this->mailData = $mailData;
        $this->mailfilespath = $mailfilespath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message = $this->markdown('Email.ceoMail')
                    ->subject('Sent From RevoTech')
                    ->with('mailData', $this->mailData);
                foreach($this->mailfilespath as $filePath){
                    $message->attach($filePath);
                }
        return $message;
    }
}
