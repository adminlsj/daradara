<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Comment;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Like;

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
            if ($comments_long->where('ip_address', $comment->ip_address)->count() > 5) {
                $user = User::find($comment->user_id);
                $user->delete();
            }
        }

        $ip_user_array = Comment::whereIn('ip_address', [
                                '139.5.108.130', '139.5.108.194', '49.0.255.6', '84.17.45.179', '2001:b400:e737:a90d:b8a3:6b9b:6433:fabd', '103.172.41.145', '172.105.47.154', '172.104.61.149', '16.163.123.103', '42.3.25.27', '205.198.121.2', '159.138.51.66', '103.59.109.27', '203.91.85.137', '58.152.186.173', '194.156.98.17', '2001:e68:5454:2d3e:1c88:367e:a3e1:f4fc', '142.0.134.81', '212.90.86.188', '114.35.99.27', '13.229.58.30', '107.148.248.93', '2a05:541:111:b::1', '116.241.206.70', '27.109.211.149', '115.135.197.54', '205.198.122.97', '163.123.192.45', '163.123.192.52', '139.5.108.209', '116.241.255.43', '194.59.220.96', '3.135.208.198', '175.159.124.166', '14.199.55.176', '2001:b400:e38e:2fe4:c135:5444:bcd0:3469', '69.25.116.208', '203.75.191.35', '34.223.242.14', '38.48.121.202', '206.119.125.48', '49.217.0.104', '182.145.161.194', '118.119.196.169', '103.160.181.26', '2409:8a0c:c23:fe20:c95:7a48:e48:f279', '213.202.233.13', '2409:8a55:ae45:3c40:84be:a7f4:8ee7:3fa0', '66.90.115.138', '111.249.11.124', '42.3.25.65', '175.148.92.220', '174.128.239.226', '18.142.91.21', '116.241.206.90', '2001:b011:a40b:507c:7124:f88a:c2bf:eadc', '2001:b011:d000:3d48:acd9:530c:4c21:9fef', '2001:b400:e785:fc14:b4fc:81b8:cd37:28ad', '2402:7500:912:3a3b:bc3f:1ba7:8d0:2064', '2001:b400:e2a8:2ce3:b537:7295:7150:82', '2408:8456:e040:2c65:259c:9061:c2c1:d43', '43.239.85.245', '46.232.120.169', '103.178.37.177', '101.44.81.105', '103.178.37.169', '240e:43d:120c:9aa:60f5:990d:9d2a:f8ee', '2401:e180:8c40:cdc:7434:98e6:75ee:3d87', '35.206.212.168', '205.178.182.78', '103.149.249.226', '205.178.182.76', '103.84.217.48', '38.65.214.103', '103.149.249.228', '103.149.249.231', '38.65.214.92', '38.65.214.106', '38.65.214.105', '38.65.214.91', '38.65.214.93', '211.22.180.37', '2001:b011:9806:9edd:b412:c927:f0d2:4b6b', '38.65.214.108', '38.65.214.111', '38.65.214.113', '103.149.249.230', '2a09:bac5:1efd:1232::1d0:25', '112.49.223.248', '2409:8a34:466:1960:ad22:3029:5059:a636', '38.65.214.13', '38.98.135.13', '35.206.232.100', '35.206.219.53', '223.73.236.187', '142.171.164.121', '13.214.30.193', '2409:8962:7613:2c3:88c8:edff:fe9b:e054', '203.218.253.205', '101.44.80.191', '38.94.108.35', '205.178.182.67', '38.94.108.36', '38.94.108.37', '205.178.182.65', '205.178.182.79', '103.84.217.44', '103.84.217.43', '103.84.217.42', '103.149.249.233', '103.149.249.236', '46.232.121.135', '103.156.242.237', '103.156.242.236', '129.154.203.71', '144.24.81.233', '138.199.12.58', '205.178.182.77', '103.149.249.238', '103.149.249.229', '103.149.249.232', '103.84.217.45', '103.84.217.46', '103.84.217.227', '103.84.217.47', '205.178.182.81', '199.249.170.151', '199.249.170.17', '38.94.108.32', '212.102.46.41', '149.102.254.15', '212.102.46.70', '103.149.249.235', '185.152.67.165', '103.149.249.234', '38.45.64.224', '38.45.64.227', '38.94.108.34', '38.94.108.33', '89.36.163.109', '88.210.37.125', '185.152.67.169', '185.152.67.164', '139.5.108.186', '139.5.108.189', '203.91.85.222', '101.44.82.253', '103.229.54.221', '112.18.214.129', '64.32.17.34', '2a0e:97c0:7da:f6f8:ee79:baab:e215:ce00', '35.213.147.211', '8.220.141.174', '35.207.236.143', '35.219.70.169', '156.59.0.46', '45.8.186.56', '16.63.250.234', '15.156.117.244', '61.238.50.228', '38.33.23.225', '51.112.129.26', '38.54.106.126', '34.0.34.168', '38.54.106.126', '15.237.9.134', '103.43.162.228', '192.74.241.129', '137.175.41.97', '18.102.47.247', '122.10.141.103', '15.157.139.241', '198.2.223.129'
                            ])
                            ->where('created_at', '>=', Carbon::now()->subDay())
                            ->groupBy('user_id')
                            ->pluck('user_id');

        User::destroy($ip_user_array);

        $ip_user_text_array = Comment::where(function($query) {
                                $query->where('text', 'ilike', "%y%t%7%x%")
                                      ->orWhere('text', 'ilike', "%y%t%6%x%")
                                      ->orWhere('text', 'ilike', "%萝莉嗷嗷叫%")
                                      ->orWhere('text', 'ilike', "%y%y%l%l%z%y%")
                                      ->orWhere('text', 'ilike', "%bulubu%")
                                      ->orWhere('text', 'ilike', "%mao%vip%")
                                      ->orWhere('text', 'ilike', "%好用的机场%")
                                      ->orWhere('text', 'ilike', "%速度快的梯子%")
                                      ->orWhere('text', 'ilike', "%d%d%6%6%m%e%")
                                      ->orWhere('text', 'ilike', "%d%d%p%p%m%e%");
                              })->where('created_at', '>=', Carbon::now()->subDay())
                                ->groupBy('user_id')
                                ->pluck('user_id');

        User::destroy($ip_user_text_array);

        $name_users = User::where(function($query) {
                                    $query->where('name', 'ilike', "%y%t%7%x%")
                                          ->orWhere('name', 'ilike', "%y%t%6%x%")
                                          ->orWhere('name', 'ilike', "%9%6%l%o%l%i%z%d%")
                                          ->orWhere('name', 'ilike', "%𝕐%𝕋%𝟞%𝕏%")
                                          ->orWhere('name', 'ilike', "%𝕐%𝕋%𝟞%𝕏%")
                                          ->orWhere('name', 'ilike', "%n%v%7%3%2%")
                                          ->orWhere('name', 'ilike', "%b%d%8%8%6%9%")
                                          ->orWhere('name', 'ilike', "%b%d%6%0%2%")
                                          ->orWhere('name', 'ilike', "%d%d%6%6%m%e%")
                                          ->orWhere('name', 'ilike', "%d%d%p%p%m%e%");
                                })->where('created_at', '>=', Carbon::now()->subDay());
        $name_users->delete();


        User::whereIn('email', ['junheipou@gmail.com', 'caigueikim149@gmail.com', 'honggoujishenme52@gmail.com', 'junexi895@gmail.com', 'ptsd258@163.com', 'sunliren456@gmail.com', 'larou712@gmail.com', 'ribendiguo98@gmail.com', '3467976946@qq.com', '747193927@qq.com', '3652601936@qq.com', 'zhongchengyudanghuguoweiquanzh@gmail.com', 'ptsd258163@gmail.com', 'hollioberyqtv41@gmail.com', '1992651193@qq.com'])->where('created_at', '>=', Carbon::now()->subWeek())->delete();

        $likes = Like::where('created_at', '>=', Carbon::now()->subWeek())->get();
        foreach ($likes as $like) {
            if (!User::where('id', $like->user_id)->exists()) {
                $like->delete();
            }
        }

        /* $keyword_user_array = Comment::where('text', 'ilike', '%↑%')
                            ->where('created_at', '>=', Carbon::now()->subDay())
                            ->groupBy('user_id')
                            ->pluck('user_id'); */
        // User::destroy($keyword_user_array);

        Log::info('Spam remove ended...');
    }
}
