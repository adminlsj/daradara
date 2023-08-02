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
                                '139.5.108.130', '139.5.108.194', '49.0.255.6', '84.17.45.179', '2001:b400:e737:a90d:b8a3:6b9b:6433:fabd', '103.172.41.145', '172.105.47.154', '172.104.61.149', '16.163.123.103', '42.3.25.27', '205.198.121.2', '159.138.51.66', '103.59.109.27', '203.91.85.137', '58.152.186.173', '194.156.98.17', '2001:e68:5454:2d3e:1c88:367e:a3e1:f4fc', '142.0.134.81', '212.90.86.188', '114.35.99.27', '13.229.58.30', '107.148.248.93', '2a05:541:111:b::1', '116.241.206.70', '27.109.211.149', '115.135.197.54', '205.198.122.97', '163.123.192.45', '163.123.192.52', '139.5.108.209', '116.241.255.43', '194.59.220.96', '3.135.208.198', '175.159.124.166', '14.199.55.176', '2001:b400:e38e:2fe4:c135:5444:bcd0:3469', '69.25.116.208', '203.75.191.35'
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
