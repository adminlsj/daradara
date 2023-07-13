<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jav;

class UpdateEmptySd5 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:update-emptysd5';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update hscangku empty sd 5';

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
        Jav::updateEmptySd(5, 5);
    }
}