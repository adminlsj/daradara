<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Meetup extends Mailable
{
    use Queueable, SerializesModels;
    public $user_email, $location, $time;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_email, $location, $time)
    {
        $this->user_email = $user_email;
        $this->location = $location;
        $this->time = $time;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.meetup');
    }
}
