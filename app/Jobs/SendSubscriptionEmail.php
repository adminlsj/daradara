<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\User;
use App\Video;
use Mail;
use App\Mail\SubscribeNotify;

class SendSubscriptionEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $video;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Video $video)
    {
        $this->user = $user;
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {        
        if (strpos($this->user->alert, 'subscribe') === false) {
            $this->user->alert = $this->user->alert."subscribe";
            $this->user->save();
        }
        Mail::to($this->user->email)->send(new SubscribeNotify($this->user, $this->video));
    }
}
