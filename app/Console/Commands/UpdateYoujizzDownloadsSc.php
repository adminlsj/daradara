<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Youjizz;

class UpdateYoujizzDownloadsSc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:update-youjizzdownloadssc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update downloads sc with youjizz as source';

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
        Youjizz::updateYoujizzDownloadsSc();
    }
}
