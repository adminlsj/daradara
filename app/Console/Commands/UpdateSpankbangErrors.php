<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Spankbang;

class UpdateSpankbangErrors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:update-spankbangerrors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update error spankbang videos';

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
        Spankbang::updateSpankbangErrors();
    }
}
