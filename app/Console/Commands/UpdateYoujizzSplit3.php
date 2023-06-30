<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Youjizz;

class UpdateYoujizzSplit3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:update-youjizzsplit3';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update hentai with youjizz by split 3 source';

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
        Youjizz::updateYoujizzSplit(3, 3);
    }
}
