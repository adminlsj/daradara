<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Video;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;
use App\Rule34;
use App\Helper;
use Carbon\Carbon;

class UploadRule34 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hanime1:upload-rule34';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload Rule34 videos';

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
        $artists = Rule34::$artists;
        $user = array_rand($artists);
        $url = $artists[$user];

        $user = User::find($user);
        Log::info('Rule34 user '.$user->name.' upload started...');
        $video_links = [];
        $html = Browsershot::url($url)
                ->timeout(3600)
                ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                ->bodyHtml();

        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        $links = $dom->getElementsByTagName('a');
        foreach ($links as $link) {
            $id = $link->getAttribute('id');
            if ($id != '') {
                array_push($video_links, 'https://rule34.xxx/'.$link->getAttribute('href'));
            }
        }

        $playlist = $user->watches->first();
        $duplicated = Rule34::$duplicated;
        foreach ($video_links as $link) {
            $queries = [];
            parse_str($link, $queries);
            $rule_id = $queries['id'];
            if (!empty($rule_id) && !Video::where('sd', 'like', '%?'.$rule_id)->exists() && !Video::where('foreign_sd', 'like', '%'.$rule_id.'"%')->exists() && !in_array($rule_id, $duplicated)) {
                $html = Browsershot::url($link)
                ->timeout(3600)
                ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                ->bodyHtml();

                $character = Helper::get_string_between($html, '<li class="tag-type-character tag">', '</li>');
                $dom = new \DOMDocument();
                $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$character);
                $hyperlinks = $dom->getElementsByTagName('a');
                foreach ($hyperlinks as $hyperlink) {
                    $character = $hyperlink->nodeValue;
                }

                $copyright = Helper::get_string_between($html, '<li class="tag-type-copyright tag">', '</li>');
                $dom = new \DOMDocument();
                $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$copyright);
                $hyperlinks = $dom->getElementsByTagName('a');
                foreach ($hyperlinks as $hyperlink) {
                    $copyright = $hyperlink->nodeValue;
                }

                $title = '['.$user->name.'] '.$character.' ['.$copyright.']';

                $tags = [];
                $tag_sidebar = Helper::get_string_between($html, '<ul id="tag-sidebar">', '</ul>');
                $dom = new \DOMDocument();
                $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$tag_sidebar);
                $hyperlinks = $dom->getElementsByTagName('a');
                foreach ($hyperlinks as $hyperlink) {
                    $tags[$hyperlink->nodeValue] = 10;
                }
                $tags['同人'] = 10;

                $sd = Helper::get_string_between($html, '<source src="', '"');
                $created_at = Helper::get_string_between($html, 'Posted: ', '<br>');

                $video = Video::create([
                    'user_id' => $user->id,
                    'playlist_id' => $playlist->id,
                    'title' => $title,
                    'translations' => ['JP' => $title],
                    'caption' => $title,
                    'sd' => $sd,
                    'imgur' => 'WENZTSJ',
                    'tags' => implode(' ', array_keys($tags)),
                    'tags_array' => $tags,
                    'current_views' => 0,
                    'views' => 0,
                    'outsource' => true,
                    'foreign_sd' => ['rule34' => $sd],
                    'cover' => 'https://i.imgur.com/E6mSQA2.png',
                    'created_at' => $created_at,
                    'uploaded_at' => Carbon::now(),
                ]);

                Rule34::translateRule34();
            }
        }

        Log::info('Rule34 user '.$user->name.' upload ended...');
    }
}
