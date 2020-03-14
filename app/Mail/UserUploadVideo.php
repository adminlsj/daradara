<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class UserUploadVideo extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $genre;
    public $category;
    public $watchDescription;
    public $title;
    public $videoDescription;
    public $image;
    public $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, String $genre, String $category, String $watchDescription, String $title, String $videoDescription, String $image, String $link)
    {
        $this->user = $user;
        $this->genre = $genre;
        $this->category = $category;
        $this->watchDescription = $watchDescription;
        $this->title = $title;
        $this->videoDescription = $videoDescription;
        $this->image = $image;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('用戶上傳影片')->markdown('mail.userUploadVideo');
    }
}
