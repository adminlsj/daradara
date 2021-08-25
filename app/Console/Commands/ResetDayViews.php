<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Comic;

class ResetDayViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:reset-day-views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset day views for videos and comics';

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
        Comic::where('id', '!=', null)->update(['day_views' => 0]);
    }
}
