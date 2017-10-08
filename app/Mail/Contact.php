<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    public $user_email;
    public $title;
    public $text;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_email, $title, $text)
    {
        $this->user_email = $user_email;
        $this->title = $title;
        $this->text = $text;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.contact');
    }
}
