<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Comment;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class RemoveSpam extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:remove-spam';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove spam users and comments and etc...';

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
        Log::info('Spam remove started...');

        $comments = Comment::where('created_at', '>=', Carbon::now()->subDay())->get();
        foreach ($comments as $comment) {
            if ($comments->where('text', $comment->text)->count() > 5) {
                $user = User::find($comment->user_id);
                $user->delete();
            }
        }

        $ip_user_array = Comment::whereIn('ip_address', [
                                '68.183.193.70',
                                '143.110.189.77',
                                '46.232.121.36',
                                '118.193.39.9',
                                '61.224.35.228',
                                '45.249.247.6',
                                '103.210.22.126',
                                '128.14.23.1',
                                '240e:342:2c83:fe00:cdd0:b270:d1b:a8c',
                                '119.246.233.227',
                                '152.32.170.110',
                                '54.176.41.89',
                                '54.202.162.235'
                            ])
                            ->where('created_at', '>=', Carbon::now()->subDay())
                            ->groupBy('user_id')
                            ->pluck('user_id');

        $keyword_user_array = Comment::where('text', 'ilike', '%↑%')
                            ->where('created_at', '>=', Carbon::now()->subDay())
                            ->groupBy('user_id')
                            ->pluck('user_id');
        
        User::destroy($ip_user_array);
        User::destroy($keyword_user_array);

        Log::info('Spam remove ended...');
    }
}
