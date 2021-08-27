<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Nhentai;

class UploadNhentai extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:upload-nhentai';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload new comics from nhentai';

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
        Nhentai::uploadNhentai();
    }
}
