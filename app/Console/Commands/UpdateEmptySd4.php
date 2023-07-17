<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jav;

class UpdateEmptySd4 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:update-emptysd4';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update hscangku empty sd 4';

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
        Jav::updateWithJable(5, 4);
    }
}