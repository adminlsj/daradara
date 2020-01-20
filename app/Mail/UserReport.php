<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Video;

class UserReport extends Mailable
{
    use Queueable, SerializesModels;

    public $reason;
    public $video;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $reason, Video $video)
    {
        $this->reason = $reason;
        $this->video = $video;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('用戶回報無法觀看影片')->markdown('mail.userReport');
    }
}
