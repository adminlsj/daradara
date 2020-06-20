<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Video;
use App\PendingVideo;
use App\Subscribe;

class UploadVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laughseejapan:upload-videos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload and delete all pending videos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pendings = PendingVideo::all();
        foreach ($pendings as $pending) {
            $video = Video::create([
                'user_id' => $pending->user_id,
                'playlist_id' => $pending->playlist_id,
                'title' => $pending->title,
                'caption' => $pending->caption,
                'sd' => $pending->sd,
                'imgur' => $pending->imgur,
                'tags' => $pending->tags,
                'views' => $pending->views,
                'outsource' => $pending->outsource,
                'created_at' => $pending->created_at,
                'uploaded_at' => $pending->uploaded_at,
            ]);

            $userArray = [];
            if ($video->playlist_id != '') {
                $watch = $video->watch;
                $watch->updated_at = $video->uploaded_at;
                $watch->save();

                $subscribes = $watch->subscribes();
                foreach ($subscribes as $subscribe) {
                    $user = $subscribe->user();
                    if (strpos($user->alert, 'subscribe') === false) {
                        $user->alert = $user->alert."subscribe";
                        $user->save();
                    }
                    array_push($userArray, $user->id);
                }
            }

            foreach ($video->tags() as $tag) {
                $subscribes = Subscribe::where('tag', $tag)->get();
                foreach ($subscribes as $subscribe) {
                    if (!in_array($subscribe->user()->id, $userArray)) {
                        $user = $subscribe->user();
                        if (strpos($user->alert, 'subscribe') === false) {
                            $user->alert = $user->alert."subscribe";
                            $user->save();
                        }
                    }
                }
            }

            $pending->delete();
        }
    }
}
