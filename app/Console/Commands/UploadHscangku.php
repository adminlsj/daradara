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
        // Jav::uploadHscangku();
        // Jav::updateEmptySd();
        // Jav::updateWithMissav();
        $videos = Video::where('id', '>', 85932)->where('id', '<', 300035)->get();
        foreach ($videos as $video) {
            $poster = explode('?', $video->foreign_sd['poster'])[0];
            $temp = $video->foreign_sd;
            $temp["poster"] = $poster;
            $video->foreign_sd = $temp;

            $video->cover = "https://vdownload.hembed.com/image/cover/E6mSQA2.jpg?secure=rc36ujEZGDGbhTJYIRNU3Q==,4854601037&genre=jav&poster={$poster}";
            $video->save();
        }
    }
}