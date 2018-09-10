<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Job;

class JobAppliedUser extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $job;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Job $job)
    {
        $this->user = $user;
        $this->job = $job;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Application was sent to '.$this->job->company->name)->markdown('mail.jobAppliedUser');
    }
}
