<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use App\Video;
use App\Motherless;
use App\Mail\UserReport;

class CheckOdysee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:check-odysee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check videos with odysee source';

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
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $videos = Video::where('sd', 'like', '%odycdn%')->get();
        foreach ($videos as $video) {
            $httpcode = Motherless::getHttpcode($video->sd);
            if ($httpcode != 200 && $httpcode != 0) {
                Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Odysee check failed ('.$httpcode.')', $video->id, $video->title, $video->sd, 'master', 'master'));
            }
        }
    }
}
