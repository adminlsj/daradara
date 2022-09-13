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

        $user_array = Comment::whereIn('ip_address', [
                                '103.172.182.30',
                                '20.205.41.101'
                            ])
                            ->whereDate('created_at', Carbon::today())
                            ->groupBy('user_id')
                            ->pluck('user_id');
        
        User::destroy($user_array);

        Log::info('Spam remove ended...');
    }
}
