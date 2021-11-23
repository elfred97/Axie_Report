<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $reminder;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $reminder)
    {
        $this->user = $user;
        $this->reminder = $reminder;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reminder');
    }
}
