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

    public $email;
    public $reason;
    public $video_id;
    public $video_title;
    public $video_sd;
    public $country_code;
    public $ip_address;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $email, String $reason, String $video_id, String $video_title, String $video_sd, String $ip_address, String $country_code)
    {
        $this->email = $email;
        $this->reason = $reason;
        $this->video_id = $video_id;
        $this->video_title = $video_title;
        $this->video_sd = $video_sd;
        $this->ip_address = $ip_address;
        $this->country_code = $country_code;
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
