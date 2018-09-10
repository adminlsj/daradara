<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Job;

class JobAppliedAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $job, $resume, $haveResumeImg;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Job $job)
    {
        $this->user = $user;
        $this->job = $job;
        $this->resume = $user->resume;

        $haveResumeImg = false;
        if ($this->resume->resumeImg != null) {
            $haveResumeImg = true;
        }
        $this->haveResumeImg = $haveResumeImg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Application Received')->markdown('mail.jobAppliedAdmin');
    }
}
