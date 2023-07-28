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
                                '68.183.193.70', '143.110.189.77', '46.232.121.36', '118.193.39.9', '61.224.35.228', '45.249.247.6', '103.210.22.126', '128.14.23.1',
                                '240e:342:2c83:fe00:cdd0:b270:d1b:a8c',
                                '119.246.233.227',
                                '152.32.170.110',
                                '54.176.41.89',
                                '54.202.162.235',
                                '192.74.242.23',
                                '45.82.253.58',
                                '146.70.149.188',
                                '84.39.112.154',
                                '116.241.206.140',
                                '2602:fe90:100:5::d020:525b',
                                '91.199.84.47',
                                '34.92.182.230',
                                '43.198.103.135',
                                '91.199.84.31',
                                '91.199.84.73',
                                '34.96.249.86',
                                '103.149.249.229',
                                '103.149.249.228',
                                '45.62.172.8',
                                '45.62.172.3',
                                '69.25.117.245',
                                '103.156.242.237',
                                '199.249.170.151',
                                '103.84.217.45',
                                '103.149.249.231',
                                '218.102.244.49',
                                '136.52.34.103',
                                '45.129.228.119',
                                '91.192.81.130',
                                '2.57.169.209',
                                '45.62.172.5',
                                '18.142.253.225',
                                '18.143.190.216',
                                '3.34.127.236',
                                '3.38.165.147',
                                '2401:e180:8802:2c5f:e495:723b:ae28:5911',
                                '103.59.109.51',
                                '165.154.226.197'
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

        /* $users = User::where('name', 'like', '%习近平%')->get();
        foreach ($users as $user) {
            $user->delete();
        } */

        Log::info('Spam remove ended...');
    }
}
