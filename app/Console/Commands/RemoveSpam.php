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

        $ip_user_array = Comment::whereIn('ip_address', [
                                '103.172.182.30',
                                '20.205.41.101',
                                '103.164.81.248',
                                '157.230.254.108',
                                '2a0e:6901:201:f:5054:ff:fe38:224',
                                '194.195.240.96',
                                '46.232.122.66',
                                '20.239.170.108',
                                '20.24.100.155',
                                '103.170.26.199',
                                '103.170.26.38',
                                '2607:f130:0:110::43',
                                '188.163.41.37',
                                '37.120.155.146',
                                '2001:67c:2628:647:f24d:a2ff:fe75:21dc',
                                '77.111.245.13',
                                '77.111.245.14',
                                '2001:67c:2628:647:94af:c9ff:feb7:fd6f',
                                '2001:67c:198c:906:7a45:c4ff:fefb:b61a',
                                '217.64.127.46',
                                '8.210.42.103',
                                '211.22.180.19',
                                '139.177.194.114',
                                '196.244.72.2',
                                '2001:67c:2628:647:12::239',
                                '103.170.26.197',
                                '61.221.110.199',
                                '103.170.26.200',
                                '103.170.26.201',
                                '211.22.180.28',
                                '43.250.187.46',
                                '18.143.134.239',
                                '20.205.57.41',
                                '165.154.227.170',
                                '154.202.60.100',
                                '20.205.14.162',
                                '46.211.98.228',
                                '20.239.168.15',
                                '20.24.204.183',
                                '20.247.3.180', 
                                '1.162.116.105',
                                '20.255.92.197',
                                '20.255.19.214',
                                '20.247.6.56',
                                '20.247.116.253',
                                '20.24.78.107',
                                '20.205.10.120',
                                '20.24.70.119',
                                '125.227.22.127',
                                '20.205.104.107',
                                '20.187.94.206'
                            ])
                            ->whereDate('created_at', Carbon::today())
                            ->groupBy('user_id')
                            ->pluck('user_id');

        $keyword_user_array = Comment::where('text', 'ilike', '%https://%')
                            ->whereDate('created_at', Carbon::today())
                            ->groupBy('user_id')
                            ->pluck('user_id');
        
        User::destroy($ip_user_array);
        User::destroy($keyword_user_array);

        Log::info('Spam remove ended...');
    }
}
