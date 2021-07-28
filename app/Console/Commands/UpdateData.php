<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Video;

class UpdateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:update-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset current views';

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
        Video::where('id', '!=', null)->update(['current_views' => 0]);
    }
}
