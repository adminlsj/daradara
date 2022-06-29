<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Video;
use App\Motherless;
use Mail;
use App\Mail\UserReport;

class CheckHetznerServers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:check-hetznerservers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Hetzner hosted servers';

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
        $vod_servers = Video::$vod_servers;
        foreach ($vod_servers as $servers) {
            foreach ($servers as $server) {
                $httpcode = Motherless::getHttpcode("https://vdownload-{$server}.hembed.com/");
                echo "vdownload-{$server}.hembed.com returned status code {$httpcode}<br>";

                if ($httpcode != 200 && $httpcode != 0) {
                    Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Hetzner server #'.$server.' failed ('.$httpcode.')', 'master', 'master', "https://vdownload-{$server}.hembed.com/", 'master', 'master'));
                }
            }
        }
    }
}
