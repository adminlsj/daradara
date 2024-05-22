<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Video;

class SubscribeNotify extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $video;
    public $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Video $video, String $title)
    {
        $this->user = $user;
        $this->video = $video;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title.' 剛剛更新了內容')
                    ->markdown('mail.subscribeNotify');
    }
}
