<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\User;
use App\Video;
use App\Watch;
use App\Subscribe;
use Mail;
use App\Mail\SubscribeNotify;

class SendSubscriptionEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {        
        $userArray = [];

        if ($this->video->playlist_id != '') {
            $watch = $this->video->watch();
            $watch->updated_at = $this->video->uploaded_at;
            $watch->save();

            $subscribes = $watch->subscribes();
            foreach ($subscribes as $subscribe) {
                $user = $subscribe->user();
                if (strpos($user->alert, 'subscribe') === false) {
                    $user->alert = $user->alert."subscribe";
                    $user->save();
                }
                Mail::to($user->email)->send(new SubscribeNotify($user, $this->video, $subscribe->tag));
                array_push($userArray, $user->id);
            }
        }

        foreach ($this->video->tags() as $tag) {
            $subscribes = Subscribe::where('tag', $tag)->get();
            foreach ($subscribes as $subscribe) {
                if (!in_array($subscribe->user()->id, $userArray)) {
                    $user = $subscribe->user();
                    if (strpos($user->alert, 'subscribe') === false) {
                        $user->alert = $user->alert."subscribe";
                        $user->save();
                    }
                    Mail::to($user->email)->send(new SubscribeNotify($user, $this->video, $subscribe->tag));
                }
            }
        }
    }
}
