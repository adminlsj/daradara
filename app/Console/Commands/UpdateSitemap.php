<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Bot;

class UpdateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laughseejapan:update-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update new uploads for sitemap daily';

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
        Bot::setSitemap();
    }
}
