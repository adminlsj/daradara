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

        /* $comments_short = Comment::where('created_at', '>=', Carbon::now()->subMinutes(1))->get();
        foreach ($comments_short as $comment) {
            if ($comments_short->where('text', $comment->text)->count() > 5 || $comments_short->where('ip_address', $comment->ip_address)->count() > 5) {
                $user = User::find($comment->user_id);
                $user->delete();
            }
        } */

        $comments_long = Comment::where('created_at', '>=', Carbon::now()->subMinutes(10))->get();
        foreach ($comments_long as $comment) {
            if ($comments_long->where('ip_address', $comment->ip_address)->count() > 10) {
                $user = User::find($comment->user_id);
                $user->delete();
            }
        }

        $ip_user_array = Comment::whereIn('ip_address', [
                                '139.5.108.130', '139.5.108.194', '49.0.255.6', '84.17.45.179', '2001:b400:e737:a90d:b8a3:6b9b:6433:fabd', '49.0.255.6'
                            ])
                            ->where('created_at', '>=', Carbon::now()->subDay())
                            ->groupBy('user_id')
                            ->pluck('user_id');

        User::destroy($ip_user_array);

        /* $keyword_user_array = Comment::where('text', 'ilike', '%↑%')
                            ->where('created_at', '>=', Carbon::now()->subDay())
                            ->groupBy('user_id')
                            ->pluck('user_id'); */
        // User::destroy($keyword_user_array);

        Log::info('Spam remove ended...');
    }
}
