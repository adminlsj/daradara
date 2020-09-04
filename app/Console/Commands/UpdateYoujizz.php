<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Video;
use Spatie\Browsershot\Browsershot;

class UpdateYoujizz extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laughseejapan:update-youjizz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update hentai with youjizz as source';

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
        $videos = Video::where('tags', 'ilike', '%裏番%')->where('foreign_sd', '!=', null)->get();
        foreach ($videos as $video) {
            if (array_key_exists('youjizz', $video->foreign_sd)) {
                $html = Browsershot::url($video->foreign_sd['youjizz'])
                    ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                    ->bodyHtml();
                $start = explode('<source src="', $html);
                $video->sd = html_entity_decode("https:".explode('" title="' , $start[1])[0]);
                $video->outsource = false;
                $video->save();
            }
        }
    }
}
