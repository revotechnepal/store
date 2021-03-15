<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $mailfilespath)
    {
        $this->data = $data;
        $this->mailfilespath = $mailfilespath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $message =  $this->markdown('Email.customerMail')
                    ->subject($this->data['subject'])
                    ->with('data', $this->data);
                foreach($this->mailfilespath as $filePath){
                    $message->attach($filePath);
                }
        return $message;
    }
}
