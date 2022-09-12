<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Comment;
use Illuminate\Support\Facades\Log;

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

        // Remove spam users
        User::where('name', 'ilike', '%ye9x%')->delete();

        // Remove spam comments users
        $user_array = Comment::where('text', 'ilike', '%168663%')
                           ->orWhere('text', 'ilike', '%福利宅男B站%')
                           ->orWhere('text', 'ilike', '%福利站%')
                           ->orWhere('text', 'ilike', '%麻豆%')
                           ->orWhere('text', 'ilike', '%萝莉嗷嗷叫%')
                           ->orWhere('text', 'ilike', '%地址头像%')
                           ->orWhere('text', 'ilike', '%头像拿走地址%')
                           ->groupBy('user_id')
                           ->pluck('user_id');
        
        User::destroy($user_array);

        Log::info('Spam remove ended...');
    }
}
