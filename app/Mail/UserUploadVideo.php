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
    public $title;
    public $description;
    public $image;
    public $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, String $genre, String $category, String $title, String $description, String $image, String $link)
    {
        $this->user = $user;
        $this->genre = $genre;
        $this->category = $category;
        $this->title = $title;
        $this->description = $description;
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
