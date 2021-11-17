<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SlpUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $slp_value;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $slp_value)
    {
        $this->user = $user;
        $this->subject = 'SLP Updated ' . Carbon::now()->format('Y-m-d h:i:s');
        $this->slp_value = $slp_value;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.slp_update');
    }
}
