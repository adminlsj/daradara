<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jav;
use App\Video;
use Illuminate\Support\Facades\Log;

class UploadHscangku extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:upload-hscangku';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload jav with hscangku as source';

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
        Jav::uploadHscangku();
        // Jav::updateEmptySd();
        // Jav::updateWithMissav();
        // Jav::updateWithJable();
        // Jav::uploadHscangkuShirouto();
    }
}