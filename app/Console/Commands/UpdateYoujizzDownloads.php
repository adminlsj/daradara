<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Youjizz;

class UpdateYoujizzDownloads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:update-youjizzdownloads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update downloads with youjizz as source';

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
        Youjizz::updateYoujizzDownloads();
    }
}
