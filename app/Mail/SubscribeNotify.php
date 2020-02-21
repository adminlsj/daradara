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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Video $video)
    {
        $this->user = $user;
        $this->video = $video;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = $this->video->watch()->title;
        return $this->subject($title.' 剛剛更新了內容')
                    ->markdown('mail.subscribeNotify');
    }
}
