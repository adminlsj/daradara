<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use App\Comic;
use App\Watch;
use Mail;
use App\Mail\UserReport;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;
use App\Rule34;
use App\Cosplayjav;
use App\Helper;
use App\Comment;
use App\User;
use Carbon\Carbon;
use App\Spankbang;
use App\Nhentai;

class BotController extends Controller
{
    public function tempMethod(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        /* $videos = Video::where('tags', 'ilike', '% 睡房 %')->get();
        foreach ($videos as $video) {
            $tags_array = $video->tags_array;
            unset($tags_array['睡房']);
            $video->tags_array = $tags_array;
            $video->tags = str_replace(' 睡房 ', ' ', $video->tags);
            $video->save();
        } */

        /* $videos = Video::where('tags', 'ilike', '%Queen Bee%')->get();
        foreach ($videos as $video) {
            $original_tags = $video->tags_array;
            $new_tags = [];
            foreach ($original_tags as $tag) {
                if ($tag == 'Queen') {
                    array_push($new_tags, 'Queen Bee');
                } elseif ($tag == 'Bee') {
                    // code...
                } else {
                    array_push($new_tags, $tag);
                }
            }
            $video->tags_array = $new_tags;
            $video->save();
        } */
    }

    public function setVideoDuration(Request $request)
    {
        $video = Video::find($request->id);
        $video->duration = round($request->duration);
        $video->save();
    }

    public function getWatchesData(Request $request)
    {
        if ($request->username == 'appieopie' && $request->password == 'd0raemOn@(!$') {
            $watches = Watch::all()->toArray();
            return $watches;
        } else {
            abort(403);
        }
    }

    public function getVideosData(Request $request)
    {
        if ($request->username == 'appieopie' && $request->password == 'd0raemOn@(!$') {
            $videos = Video::all()->toArray();
            return $videos;
        } else {
            abort(403);
        }
    }

    public function updateSpankbang()
    {
        Spankbang::updateSpankbang();
    }

    public function updateSpankbangBackup()
    {
        Spankbang::updateSpankbangBackup();
    }

    public function updateSpankbangErrors()
    {
        Spankbang::updateSpankbangErrors();
    }

    public function checkSpankbangOutdate()
    {
        Spankbang::checkSpankbangOutdate();
    }

    public function checkSpankbangUpdate()
    {
        Spankbang::checkSpankbangUpdate();
    }

    public function updateYoujizz(Request $request)
    {
        Log::info('Youjizz update started...');

        $videos = Video::where('foreign_sd', 'ilike', '%"youjizz"%')->select('id', 'title', 'sd', 'outsource', 'foreign_sd')->get();
        foreach ($videos as $video) {
            echo 'ID: '.$video->id.' STARTED<br>';
            $has_hls2e = true;
            $url = $video->foreign_sd['youjizz'];
            $url = explode('/', $url);
            $base = array_pop($url);
            $url = implode('/', $url) . '/' . urlencode($base);

            $loop = 0;
            $link = 'https://cdnc-videos.youjizz.com/';
            $data = [];
            $exist = true;
            while (strpos($link, 'https://cdnc-videos.youjizz.com/') !== false && $loop < 10) {
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                $start = explode('var dataEncodings = ', $html);
                $innerLoop = 0;
                while (!isset($start[1]) && $innerLoop < 100) {
                    $curl_connection = curl_init($url);
                    curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                    curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                    $html = curl_exec($curl_connection);
                    curl_close($curl_connection);
                    $start = explode('var dataEncodings = ', $html);
                    
                    $innerLoop++;
                    echo 'cdnc loop: '.$loop.'; offset loop: '.$innerLoop.'<br>';
                }

                if (isset($start[1])) {
                    $end = explode(';' , $start[1]);
                    $raw = $end[0];
                    $data = json_decode($raw, true);
                    if (strpos($raw, 'hls2e-') === false) {
                        $has_hls2e = false;
                        $link = '';
                    } else {
                        $target = $data[floor(count($data) / 2) - 1];
                        $link = 'https:'.$target['filename'];
                    }
                    $loop++;

                } else {
                    $exist = false;
                    break;
                }
            }

            if ($exist) {
                $m3u8 = [];
                $mp4 = [];
                foreach ($data as $source) {
                    if (strpos($source['filename'], '.m3u8') === false && is_numeric($source['quality'])) {
                        $mp4[$source['quality']] = 'https:'.$source['filename'];
                    }
                    if (strpos($source['filename'], '.m3u8') !== false && is_numeric($source['quality'])) {
                        $m3u8[$source['quality']] = 'https:'.$source['filename'];
                    }
                }

                if ($has_hls2e) {
                    $video->sd = end($mp4);
                } else {
                    $video->sd = end($m3u8);
                }

                $video->qualities = $mp4;
                $video->outsource = false;
                $video->save();
                echo 'ID: '.$video->id.' UPDATED<br>';

            } else {
                Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Youjizz update failed', $video->id, $video->title, $video->sd, 'master', 'master'));
                $temp = $video->foreign_sd;
                $temp['error'] = $video->foreign_sd['youjizz'];
                unset($temp['youjizz']);
                $video->foreign_sd = $temp;
                $video->save();
                echo 'ID: '.$video->id.' FAILED<br>';
            }
        }

        Log::info('Youjizz update ended...');
    }

    public function updateXvideos(Request $request)
    {
        Log::info('Xvideos update started...');

        $videos = Video::where('sd', 'ilike', '%xvideos%')->where('foreign_sd', 'ilike', '%"xvideos"%')->orderBy('id', 'desc')->get();
        foreach ($videos as $video) {
            $curl_connection = curl_init($video->foreign_sd['xvideos']);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            if (strpos($html, "html5player.setVideoHLS('") !== false) {
                $m3u8 = Helper::get_string_between($html, "html5player.setVideoHLS('", "');");
                $curl_connection = curl_init($m3u8);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $data = curl_exec($curl_connection);
                curl_close($curl_connection);

                $array = explode('#EXT-X-STREAM-INF', $data);
                array_shift($array);

                $qualities = [];
                $m3u8_array = explode('/', $m3u8);
                array_pop($m3u8_array);
                $preset = implode('/', $m3u8_array).'/';
                foreach ($array as $item) {
                    $quality = Helper::get_string_between($item, 'NAME="', '"');
                    $source = $preset.trim(explode('NAME="'.$quality.'"', $item)[1]);
                    $qualities[str_replace('p', '', $quality)] = $source;
                }
                if (array_key_exists(1080, $qualities)) {
                   $video->sd = $qualities[1080];
                } elseif (array_key_exists(720, $qualities)) {
                    $video->sd = $qualities[720];
                } elseif (array_key_exists(480, $qualities)) {
                    $video->sd = $qualities[480];
                } elseif (array_key_exists(360, $qualities)) {
                    $video->sd = $qualities[360];
                } elseif (array_key_exists(250, $qualities)) {
                    $video->sd = $qualities[250];
                }

                $video->outsource = false;
                $video->save();

            } else {
                Mail::to('vicky.avionteam@gmail.com')->send(new UserReport('master', 'Xvideos update failed', $video->id, $video->title, $video->sd, 'master', 'master'));
                $temp = $video->foreign_sd;
                $temp['error'] = $video->foreign_sd['xvideos'];
                unset($temp['xvideos']);
                $video->foreign_sd = $temp;
                $video->save();
            }
        }

        Log::info('Xvideos update ended...');
    }

    public function uploadRule34(Request $request)
    {
        $artists = Rule34::$artists;
        $user = array_rand($artists);
        $url = $artists[$user];

        $user = User::find($user);
        Log::info('Rule34 user '.$user->name.' upload started...');
        $video_links = [];
        $html = Browsershot::url($url)
                ->timeout(12800)
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
            if (!Video::where('sd', 'ilike', '%?'.$rule_id)->exists() && !in_array($rule_id, $duplicated)) {
                $html = Browsershot::url($link)
                ->timeout(12800)
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
                    'outsource' => false,
                    'cover' => 'https://i.imgur.com/E6mSQA2.png',
                    'created_at' => $created_at,
                    'uploaded_at' => Carbon::now(),
                ]);

                Rule34::translateRule34();
            }
        }

        Log::info('Rule34 user '.$user->name.' upload ended...');
    }

    public function translateRule34()
    {
        Rule34::translateRule34();
    }

    public function uploadCosplayjav(Request $request)
    {
        Cosplayjav::uploadCosplayjav($request->url);
    }

    public function translateCosplayjav()
    {
        Cosplayjav::translateCosplayjav();
    }

    public function uploadNhentai(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $pages = 2535;
        $url = 'https://nhentai.net/language/chinese/?page=';
        for ($i = 2533; $i <= $pages; $i++) { 
            $curl_connection = curl_init($url.$i);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $start = explode('<div class="container index-container">', $html);
            $end = explode('</div><section class="pagination">' , $start[1]);
            $galleries = $end[0];

            $dom = new \DOMDocument();
            $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$galleries);
            $links = $dom->getElementsByTagName('a');

            foreach ($links as $link) {
                Comic::create([
                    'nhentai_id' => Helper::get_string_between($link->getAttribute('href'), '/g/', '/')
                ]);
            }
        }

        $comics = Comic::where('pages', null)->orderBy('id', 'asc')->get();
        foreach ($comics as $comic) {
            if ($comic->nhentai_id != 312813) {
                $url = 'https://nhentai.net/g/'.$comic->nhentai_id.'/';
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                $galleries_id = Helper::get_string_between($html, 'data-src="https://t.nhentai.net/galleries/', '/');

                $title_n = Helper::get_string_between($html, '<h1 class="title">', '</h1>');
                $title_n_before = trim(Helper::get_string_between($title_n, '<span class="before">', '</span>'));
                $title_n_pretty = trim(Helper::get_string_between($title_n, '<span class="pretty">', '</span>'));
                $title_n_after = trim(Helper::get_string_between($title_n, '<span class="after">', '</span>'));

                $title_o = Helper::get_string_between($html, '<h2 class="title">', '</h2>');
                $title_o_before = trim(Helper::get_string_between($title_o, '<span class="before">', '</span>'));
                $title_o_pretty = trim(Helper::get_string_between($title_o, '<span class="pretty">', '</span>'));
                $title_o_after = trim(Helper::get_string_between($title_o, '<span class="after">', '</span>'));


                $parodies = $this->getNhentaiTags($html, 'Parodies:');
                $characters = $this->getNhentaiTags($html, 'Characters:');
                $tags = $this->getNhentaiTags($html, 'Tags:');
                $artists = $this->getNhentaiTags($html, 'Artists:');
                $groups = $this->getNhentaiTags($html, 'Groups:');
                $languages = $this->getNhentaiTags($html, 'Languages:');
                $categories = $this->getNhentaiTags($html, 'Categories:');
                $pages = $this->getNhentaiTags($html, 'Pages:')[0];
                $created_at = str_replace('T', ' ', explode('.', Helper::get_string_between($html, 'datetime="', '"'))[0]);

                $comic->update([
                    'galleries_id' => $galleries_id,
                    'title_n_before' => $title_n_before,
                    'title_n_pretty' => $title_n_pretty,
                    'title_n_after' => $title_n_after,
                    'title_o_before' => $title_o_before,
                    'title_o_pretty' => $title_o_pretty,
                    'title_o_after' => $title_o_after,
                    'parodies' => $parodies,
                    'characters' => $characters,
                    'tags' => $tags,
                    'artists' => $artists,
                    'groups' => $groups,
                    'languages' => $languages,
                    'categories' => $categories,
                    'pages' => $pages,
                    'created_at' => $created_at,
                ]);
            }
        }

        $comics = Comic::where('extension', null)->orderBy('id', 'asc')->get();
        foreach ($comics as $comic) {
            $url = 'https://t.nhentai.net/galleries/'.$comic->galleries_id.'/cover.jpg';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
            curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_TIMEOUT,10);
            $output = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpcode == 200) {
                $comic->extension = 'jpg';
                $comic->save();
            } elseif ($httpcode == 404) {
                $comic->extension = 'png';
                $comic->save();
            } else {
                return '<a target="_blank" href="/g/'.$comic->id.'">ID#'.$comic->id.' - '.$httpcode.'</a><br>';
            }
        }

        $comics = Comic::orderBy('id', 'asc')->get();
        foreach ($comics as $comic) {
            $comic->title_n_before = html_entity_decode($comic->title_n_before, ENT_QUOTES, 'UTF-8');
            $comic->title_n_pretty = html_entity_decode($comic->title_n_pretty, ENT_QUOTES, 'UTF-8');
            $comic->title_n_after = html_entity_decode($comic->title_n_after, ENT_QUOTES, 'UTF-8');
            $comic->title_o_before = html_entity_decode($comic->title_o_before, ENT_QUOTES, 'UTF-8');
            $comic->title_o_pretty = html_entity_decode($comic->title_o_pretty, ENT_QUOTES, 'UTF-8');
            $comic->title_o_after = html_entity_decode($comic->title_o_after, ENT_QUOTES, 'UTF-8');
            $comic->save();
        }

        $comics = Comic::where('extensions', null)->orderBy('id', 'asc')->get();
        foreach ($comics as $comic) {
            $extensions = [];
            $url = 'https://nhentai.net/g/'.$comic->nhentai_id.'/';
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $data = Helper::get_string_between($html, 'JSON.parse("', '")');
            $data = json_decode(json_decode('"'.$data.'"'), true);

            foreach ($data['images']['pages'] as $page) {
                array_push($extensions, $page['t']);
            }

            if (count($extensions) != $comic->pages) {
                return '<a target="_blank" href="/g/'.$comic->id.'">ID#'.$comic->id.' - pages count mismatch</a><br>';
            } else {
                $comic->extensions = $extensions;
                $comic->save();
            }
        }
    }

    public function getNhentaiTags(String $html, String $delimiter)
    {
        $array = [];
        $temp_array = Helper::get_string_between($html, $delimiter, '</div>');
        $temp_array = explode('<span class="name">', $temp_array);
        array_shift($temp_array);
        foreach ($temp_array as $temp) {
            array_push($array, explode('</span>', $temp)[0]);
        }
        return $array;
    }

    public function translateNhentaiTags()
    {
        Nhentai::translateNhentaiTags();
    }

    public function translateNhentaiLanguages()
    {
        Nhentai::translateNhentaiLanguages();
    }

    public function translateNhentaiCategories()
    {
        Nhentai::translateNhentaiCategories();
    }

    public function comments(Request $request)
    {   
        $comments = Comment::with('video:id,title')->orderBy('created_at', 'desc')->paginate(100);
        return view('layouts.comments', compact('comments')); 
    }
}
