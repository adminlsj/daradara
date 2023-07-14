<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jav;

class UpdateEmptySd1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:update-emptysd1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update hscangku empty sd 1';

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
        // Jav::updateEmptySd(5, 1);
        Jav::updateWithMissav(5, 1);
        Jav::updateMissavImgur(5, 1);
    }
}