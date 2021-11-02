<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Spankbang;

class UpdateSpankbang2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:update-spankbang2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update hentai with spankbang as source part 2';

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
        Spankbang::updateSpankbang(2, 3);
    }
}
