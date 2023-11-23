<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Video_temp;

class UpdateHomeVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:update-homevideos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update home video temps';

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
        Video_temp::updateHomeVideos();
    }
}
