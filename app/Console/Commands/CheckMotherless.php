<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Motherless;

class CheckMotherless extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:check-motherless';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check videos with motherless source';

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
        Motherless::checkMotherless();
    }
}
