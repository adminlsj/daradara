<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Video;

class UserAddedTags extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $reason;
    public $video_id;
    public $video_title;
    public $video_sd;
    public $country_code;
    public $ip_address;
    public $added_tags;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(String $email, String $reason, String $video_id, String $video_title, String $video_sd, String $ip_address, String $country_code, Array $added_tags_array)
    {
        $this->email = $email;
        $this->reason = $reason;
        $this->video_id = $video_id;
        $this->video_title = $video_title;
        $this->video_sd = $video_sd;
        $this->ip_address = $ip_address;
        $this->country_code = $country_code;
        $this->added_tags = implode('&tags[]=', $added_tags_array);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('用戶新增影片標籤')->markdown('mail.userAddedTags');
    }
}