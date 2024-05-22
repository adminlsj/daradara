<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Xvideos;

class UpdateXvideos1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:update-xvideos1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update hentai with xvideos as source server 1';

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
        Xvideos::updateXvideos(1, 3);
    }
}
