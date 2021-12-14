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
use App\Motherless;
use App\Nhentai;
use Storage;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class BotController extends Controller
{
    public function tempMethod(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $videos = Video::where('sd', 'like', '%rule34%')->get();
        foreach ($videos as $video) {
            $video->outsource = true;
            $video->save();
        }

        /* $url = 'https://spankbang.com/5yx9r/video/convenient+sex+friends+2';

        if ($request->method == 'curl') {
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

        } elseif ($request->method == 'browsershot') {
            $html = Spankbang::getBrowsershotHtml($url);
        }

        return $html; */


        /* $videos = Video::where('sd', 'ilike', '%xvideos%')->where('foreign_sd', 'ilike', '%"error"%')->orderBy('id', 'desc')->get();
        foreach ($videos as $video) {
            $temp = $video->foreign_sd;
            $temp['xvideos'] = $video->foreign_sd['error'];
            unset($temp['error']);
            $video->foreign_sd = $temp;
            $video->save();
        } */

        /* $comics = Comic::orderBy('id', 'asc')->get();
        foreach ($comics as $comic) {
            $searchtext = $comic->title_n_before
                         .$comic->title_n_pretty
                         .$comic->title_n_after
                         .$comic->title_o_before
                         .$comic->title_o_pretty
                         .$comic->title_o_after
                         .implode($comic->parodies)
                         .implode($comic->characters)
                         .implode($comic->tags)
                         .implode($comic->artists)
                         .implode($comic->groups)
                         .implode($comic->languages)
                         .implode($comic->categories);
            $searchtext = mb_strtolower($searchtext);
            $searchtext = preg_replace('/\s+/', '', $searchtext);
            $searchtext = preg_split('//u', $searchtext, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($searchtext as &$character) {
                if (strlen($character) != mb_strlen($character, 'utf-8')) {
                    $character = bin2hex(iconv('UTF-8', 'UTF-16BE', $character));
                }
            }
            $searchtext = implode($searchtext);
            $comic->searchtext = $searchtext;
            $comic->save();
        } */

        /* $tags_array = [];
        $comics = Comic::orderBy('id', 'asc')->get();
        foreach ($comics as $comic) {
            $tags = $comic->tags;
            foreach ($tags as $tag) {
                if (array_key_exists($tag, $tags_array)) {
                    $tags_array[$tag] = $tags_array[$tag] + 1;
                } else {
                    $tags_array[$tag] = 1;
                }
            }
        }
        arsort($tags_array);
        return $tags_array; */

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

    public function checkAvbebeEporner(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $eporner_list = [];
        for ($i = 1; $i <= 66; $i++) { 
            if ($i == 1) {
                $url = 'https://avbebe.com/archives/category/h%e5%8b%95%e7%95%ab%e5%bd%b1%e7%89%87';
            } else {
                $url = 'https://avbebe.com/archives/category/h%E5%8B%95%E7%95%AB%E5%BD%B1%E7%89%87/page/'.$i;
            }
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $start = explode('<h1 class="archive-title">動畫卡通 Archive</h1>', $html);
            $end = explode('<!-- .posts-default -->' , $start[1]);
            $videos = $end[0];
            $videos = str_replace('【動畫卡通】異種族風俗娘評鑑指南<', '', $videos);
            $videos = str_replace('>[中文字幕]', '', $videos);

            $dom = new \DOMDocument();
            $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$videos);
            $links = $dom->getElementsByTagName('a');
            foreach ($links as $link) {
                $href = $link->getAttribute('href');

                $curl_connection = curl_init($href);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                if (strpos($html, 'https://www.eporner.com/embed/') !== false) {
                    $eporner = Helper::get_string_between($html, 'https://www.eporner.com/embed/', '/');
                    $eporner = 'https://www.eporner.com/embed/'.$eporner.'/';
                    if (!in_array($eporner, $eporner_list)) {
                        $curl_connection = curl_init($eporner);
                        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                        $html = curl_exec($curl_connection);
                        curl_close($curl_connection);

                        if (strpos($html, 'This video is no longer available.') === false) {
                            array_push($eporner_list, $eporner);
                            echo $eporner.'<br>';
                        }
                    }
                }
            }
        }
    }

    public function checkAvbebeMotherless(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $motherless_list = [];
        for ($i = 1; $i <= 66; $i++) { 
            if ($i == 1) {
                $url = 'https://avbebe.com/archives/category/h%e5%8b%95%e7%95%ab%e5%bd%b1%e7%89%87';
            } else {
                $url = 'https://avbebe.com/archives/category/h%E5%8B%95%E7%95%AB%E5%BD%B1%E7%89%87/page/'.$i;
            }
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $start = explode('<h1 class="archive-title">動畫卡通 Archive</h1>', $html);
            $end = explode('<!-- .posts-default -->' , $start[1]);
            $videos = $end[0];
            $videos = str_replace('【動畫卡通】異種族風俗娘評鑑指南<', '', $videos);
            $videos = str_replace('>[中文字幕]', '', $videos);

            $dom = new \DOMDocument();
            $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$videos);
            $links = $dom->getElementsByTagName('a');
            foreach ($links as $link) {
                $href = $link->getAttribute('href');

                $curl_connection = curl_init($href);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                if (strpos($html, 'motherless') !== false) {
                    if (strpos($html, '<iframe src="https://avbebe.com/wp-content/plugins/wp-tube-plugin/inc/tools/jwplayer/player.php?') !== false) {
                        $motherless = Helper::get_string_between($html, '<iframe src="https://avbebe.com/wp-content/plugins/wp-tube-plugin/inc/tools/jwplayer/player.php?', '"');
                        $motherless = explode('&id=', $motherless);
                        $motherless = 'https://motherless.com/'.end($motherless);

                    } elseif (strpos($html, 'https://cdn5-videos.motherlessmedia.com/videos/') !== false) {
                        $motherless = Helper::get_string_between($html, 'https://cdn5-videos.motherlessmedia.com/videos/', '.mp4');
                        $motherless = 'https://motherless.com/'.$motherless;
                    }

                    if (!in_array($motherless, $motherless_list)) {
                        $video = 'https://cdn5-videos.motherlessmedia.com/videos/'.str_replace('https://motherless.com/', '', $motherless).'.mp4';
                        $ch = curl_init($video);
                        curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
                        curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                        curl_setopt($ch, CURLOPT_TIMEOUT,10);
                        $output = curl_exec($ch);
                        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        curl_close($ch);

                        if ($httpcode != 302) {
                            array_push($motherless_list, $motherless);
                            echo $motherless.'<br>';
                        }
                    }
                }
            }
        }
    }

    public function checkAvbebeOdysee(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $odysee_list = [];
        for ($i = 1; $i <= 66; $i++) { 
            if ($i == 1) {
                $url = 'https://avbebe.com/archives/category/h%e5%8b%95%e7%95%ab%e5%bd%b1%e7%89%87';
            } else {
                $url = 'https://avbebe.com/archives/category/h%E5%8B%95%E7%95%AB%E5%BD%B1%E7%89%87/page/'.$i;
            }
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $start = explode('<h1 class="archive-title">動畫卡通 Archive</h1>', $html);
            $end = explode('<!-- .posts-default -->' , $start[1]);
            $videos = $end[0];
            $videos = str_replace('【動畫卡通】異種族風俗娘評鑑指南<', '', $videos);
            $videos = str_replace('>[中文字幕]', '', $videos);

            $dom = new \DOMDocument();
            $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$videos);
            $links = $dom->getElementsByTagName('a');
            foreach ($links as $link) {
                $href = $link->getAttribute('href');

                $curl_connection = curl_init($href);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                if (strpos($html, 'odysee') !== false) {
                    $odysee = 'https://odysee.com/'.Helper::get_string_between($html, 'src="https://odysee.com/', '"');
                    $name = Helper::get_string_between($odysee, 'https://odysee.com/$/embed/', '/');
                    $id = explode($name.'/', $odysee)[1];
                    $odysee = 'https://odysee.com/'.$name.':'.$id;
                    if (!in_array($odysee, $odysee_list)) {
                        array_push($odysee_list, $odysee);
                        echo '<a href="'.$odysee.'" target="_blank">'.$odysee.'</a><br>';
                    }
                }
            }
        }
    }

    public function checkAvbebeYoujizz(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $youjizz_list = [];
        for ($i = 66; $i >= 1; $i--) { 
            if ($i == 1) {
                $url = 'https://avbebe.com/archives/category/h%e5%8b%95%e7%95%ab%e5%bd%b1%e7%89%87';
            } else {
                $url = 'https://avbebe.com/archives/category/h%E5%8B%95%E7%95%AB%E5%BD%B1%E7%89%87/page/'.$i;
            }
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $start = explode('<h1 class="archive-title">動畫卡通 Archive</h1>', $html);
            $end = explode('<!-- .posts-default -->' , $start[1]);
            $videos = $end[0];
            $videos = str_replace('【動畫卡通】異種族風俗娘評鑑指南<', '', $videos);
            $videos = str_replace('>[中文字幕]', '', $videos);

            $dom = new \DOMDocument();
            $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$videos);
            $links = $dom->getElementsByTagName('a');
            foreach ($links as $link) {
                $href = $link->getAttribute('href');

                $curl_connection = curl_init($href);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                if (strpos($html, 'youjizz') !== false) {
                    $youjizz = 'https://www.youjizz.com/videos/embed/'.Helper::get_string_between($html, 'https://www.youjizz.com/videos/embed/', '"');
                    if (!in_array($youjizz, $youjizz_list)) {
                        array_push($youjizz_list, $youjizz);
                        echo '<a href="'.$youjizz.'" target="_blank">'.$youjizz.'</a><br>';
                    }
                }
            }
        }
    }

    public function checkAvbebeXvideos(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $xvideos_list = [];
        for ($i = 66; $i >= 1; $i--) { 
            if ($i == 1) {
                $url = 'https://avbebe.com/archives/category/h%e5%8b%95%e7%95%ab%e5%bd%b1%e7%89%87';
            } else {
                $url = 'https://avbebe.com/archives/category/h%E5%8B%95%E7%95%AB%E5%BD%B1%E7%89%87/page/'.$i;
            }
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $start = explode('<h1 class="archive-title">動畫卡通 Archive</h1>', $html);
            $end = explode('<!-- .posts-default -->' , $start[1]);
            $videos = $end[0];
            $videos = str_replace('【動畫卡通】異種族風俗娘評鑑指南<', '', $videos);
            $videos = str_replace('>[中文字幕]', '', $videos);

            $dom = new \DOMDocument();
            $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$videos);
            $links = $dom->getElementsByTagName('a');
            foreach ($links as $link) {
                $href = $link->getAttribute('href');

                $curl_connection = curl_init($href);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                if (strpos($html, 'xvideos') !== false) {
                    $xvideos = 'https://www.xvideos.com/embedframe/'.Helper::get_string_between($html, 'https://www.xvideos.com/embedframe/', '"');
                    if (!in_array($xvideos, $xvideos_list)) {
                        array_push($xvideos_list, $xvideos);
                        echo '<a href="'.$xvideos.'" target="_blank">'.$xvideos.'</a><br>';
                        echo '<a href="'.$href.'" target="_blank">'.$href.'</a><br>';
                        echo '<br>';
                    }
                }
            }
        }
    }

    public function checkAvbebeFembed(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $fembed_list = [];
        for ($i = 66; $i >= 1; $i--) { 
            if ($i == 1) {
                $url = 'https://avbebe.com/archives/category/h%e5%8b%95%e7%95%ab%e5%bd%b1%e7%89%87';
            } else {
                $url = 'https://avbebe.com/archives/category/h%E5%8B%95%E7%95%AB%E5%BD%B1%E7%89%87/page/'.$i;
            }
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $start = explode('<h1 class="archive-title">動畫卡通 Archive</h1>', $html);
            $end = explode('<!-- .posts-default -->' , $start[1]);
            $videos = $end[0];
            $videos = str_replace('【動畫卡通】異種族風俗娘評鑑指南<', '', $videos);
            $videos = str_replace('>[中文字幕]', '', $videos);

            $dom = new \DOMDocument();
            $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$videos);
            $links = $dom->getElementsByTagName('a');
            foreach ($links as $link) {
                $href = $link->getAttribute('href');

                $curl_connection = curl_init($href);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                if (strpos($html, 'https://www.fembed.com/v/') !== false) {
                    $fembed = 'https://www.fembed.com/v/'.Helper::get_string_between($html, 'https://www.fembed.com/v/', '"');
                    if (!in_array($fembed, $fembed_list)) {
                        array_push($fembed_list, $fembed);
                        echo '<a href="'.$fembed.'" target="_blank">'.$fembed.'</a><br>';
                    }
                } elseif (strpos($html, 'https://www.fembed.com/f/') !== false) {
                    $fembed = 'https://www.fembed.com/v/'.Helper::get_string_between($html, 'https://www.fembed.com/f/', '"');
                    if (!in_array($fembed, $fembed_list)) {
                        array_push($fembed_list, $fembed);
                        echo '<a href="'.$fembed.'" target="_blank">'.$fembed.'</a><br>';
                    }
                }
            }
        }
    }

    public function checkAvbebeMp4(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $avgigi_list = [];
        for ($i = 1; $i <= 66; $i++) { 
            if ($i == 1) {
                $url = 'https://avbebe.com/archives/category/h%e5%8b%95%e7%95%ab%e5%bd%b1%e7%89%87';
            } else {
                $url = 'https://avbebe.com/archives/category/h%E5%8B%95%E7%95%AB%E5%BD%B1%E7%89%87/page/'.$i;
            }
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $start = explode('<h1 class="archive-title">動畫卡通 Archive</h1>', $html);
            $end = explode('<!-- .posts-default -->' , $start[1]);
            $videos = $end[0];
            $videos = str_replace('【動畫卡通】異種族風俗娘評鑑指南<', '', $videos);
            $videos = str_replace('>[中文字幕]', '', $videos);

            $dom = new \DOMDocument();
            $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$videos);
            $links = $dom->getElementsByTagName('a');
            foreach ($links as $link) {
                $href = $link->getAttribute('href');

                $curl_connection = curl_init($href);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                $html = str_replace('&quot;', '"', $html);
                curl_close($curl_connection);

                while (strpos($html, 'https:\/\/v.avgigi.com') !== false || strpos($html, 'http:\/\/v.avgigi.com') !== false || strpos($html, 'https://v.avgigi.com') !== false || strpos($html, 'http://v.avgigi.com') !== false) {

                    if (strpos($html, 'https:\/\/v.avgigi.com') !== false) {
                        $avgigi = 'https:\/\/v.avgigi.com'.Helper::get_string_between($html, 'https:\/\/v.avgigi.com', '"');
                        $html = str_replace($avgigi, '', $html);
                        $avgigi = str_replace('\\', '', $avgigi);
                        if (!in_array($avgigi, $avgigi_list) && strpos($avgigi, '.mp4') !== false) {
                            array_push($avgigi_list, $avgigi);
                            echo $avgigi.' (viewable on <a href="'.$href.'" target="_blank">'.$href.'</a>)<br>';
                        }
                    }

                    if (strpos($html, 'http:\/\/v.avgigi.com') !== false) {
                        $avgigi = 'http:\/\/v.avgigi.com'.Helper::get_string_between($html, 'http:\/\/v.avgigi.com', '"');
                        $html = str_replace($avgigi, '', $html);
                        $avgigi = str_replace('\\', '', $avgigi);
                        if (!in_array($avgigi, $avgigi_list) && strpos($avgigi, '.mp4') !== false) {
                            array_push($avgigi_list, $avgigi);
                            echo $avgigi.' (viewable on <a href="'.$href.'" target="_blank">'.$href.'</a>)<br>';
                        }
                    }

                    if (strpos($html, 'https://v.avgigi.com') !== false) {
                        $avgigi = 'https://v.avgigi.com'.Helper::get_string_between($html, 'https://v.avgigi.com', '"');
                        $html = str_replace($avgigi, '', $html);
                        $avgigi = str_replace('\\', '', $avgigi);
                        if (!in_array($avgigi, $avgigi_list) && strpos($avgigi, '.mp4') !== false) {
                            array_push($avgigi_list, $avgigi);
                            echo $avgigi.' (viewable on <a href="'.$href.'" target="_blank">'.$href.'</a>)<br>';
                        }
                    }

                    if (strpos($html, 'http://v.avgigi.com') !== false) {
                        $avgigi = 'http://v.avgigi.com'.Helper::get_string_between($html, 'http://v.avgigi.com', '"');
                        $html = str_replace($avgigi, '', $html);
                        $avgigi = str_replace('\\', '', $avgigi);
                        if (!in_array($avgigi, $avgigi_list) && strpos($avgigi, '.mp4') !== false) {
                            array_push($avgigi_list, $avgigi);
                            echo $avgigi.' (viewable on <a href="'.$href.'" target="_blank">'.$href.'</a>)<br>';
                        }
                    }
                }
            }
        }
    }

    public function checkAvbebeM3u8(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $avgigi_list = [];
        for ($i = 1; $i <= 66; $i++) { 
            if ($i == 1) {
                $url = 'https://avbebe.com/archives/category/h%e5%8b%95%e7%95%ab%e5%bd%b1%e7%89%87';
            } else {
                $url = 'https://avbebe.com/archives/category/h%E5%8B%95%E7%95%AB%E5%BD%B1%E7%89%87/page/'.$i;
            }
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $start = explode('<h1 class="archive-title">動畫卡通 Archive</h1>', $html);
            $end = explode('<!-- .posts-default -->' , $start[1]);
            $videos = $end[0];
            $videos = str_replace('【動畫卡通】異種族風俗娘評鑑指南<', '', $videos);
            $videos = str_replace('>[中文字幕]', '', $videos);

            $dom = new \DOMDocument();
            $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$videos);
            $links = $dom->getElementsByTagName('a');
            foreach ($links as $link) {
                $href = $link->getAttribute('href');

                $curl_connection = curl_init($href);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                $html = str_replace('&quot;', '"', $html);
                curl_close($curl_connection);

                while (strpos($html, '.m3u8') !== false) {

                    if (strpos($html, 'https:\/\/v.avgigi.com') !== false) {
                        $avgigi = 'https:\/\/v.avgigi.com'.Helper::get_string_between($html, 'https:\/\/v.avgigi.com', '"');
                        $html = str_replace($avgigi, '', $html);
                        $avgigi = str_replace('\\', '', $avgigi);
                        if (!in_array($avgigi, $avgigi_list) && strpos($avgigi, '.m3u8') !== false) {
                            array_push($avgigi_list, $avgigi);
                            echo $avgigi.' (viewable on <a href="'.$href.'" target="_blank">'.$href.'</a>)<br>';
                        }
                    }

                    if (strpos($html, 'http:\/\/v.avgigi.com') !== false) {
                        $avgigi = 'http:\/\/v.avgigi.com'.Helper::get_string_between($html, 'http:\/\/v.avgigi.com', '"');
                        $html = str_replace($avgigi, '', $html);
                        $avgigi = str_replace('\\', '', $avgigi);
                        if (!in_array($avgigi, $avgigi_list) && strpos($avgigi, '.m3u8') !== false) {
                            array_push($avgigi_list, $avgigi);
                            echo $avgigi.' (viewable on <a href="'.$href.'" target="_blank">'.$href.'</a>)<br>';
                        }
                    }

                    if (strpos($html, 'https://v.avgigi.com') !== false) {
                        $avgigi = 'https://v.avgigi.com'.Helper::get_string_between($html, 'https://v.avgigi.com', '"');
                        $html = str_replace($avgigi, '', $html);
                        $avgigi = str_replace('\\', '', $avgigi);
                        if (!in_array($avgigi, $avgigi_list) && strpos($avgigi, '.m3u8') !== false) {
                            array_push($avgigi_list, $avgigi);
                            echo $avgigi.' (viewable on <a href="'.$href.'" target="_blank">'.$href.'</a>)<br>';
                        }
                    }

                    if (strpos($html, 'http://v.avgigi.com') !== false) {
                        $avgigi = 'http://v.avgigi.com'.Helper::get_string_between($html, 'http://v.avgigi.com', '"');
                        $html = str_replace($avgigi, '', $html);
                        $avgigi = str_replace('\\', '', $avgigi);
                        if (!in_array($avgigi, $avgigi_list) && strpos($avgigi, '.m3u8') !== false) {
                            array_push($avgigi_list, $avgigi);
                            echo $avgigi.' (viewable on <a href="'.$href.'" target="_blank">'.$href.'</a>)<br>';
                        }
                    }
                }
            }
        }
    }

    public function checkAvbebeOthers(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $others_list = [];
        for ($i = 1; $i <= 66; $i++) { 
            if ($i == 1) {
                $url = 'https://avbebe.com/archives/category/h%e5%8b%95%e7%95%ab%e5%bd%b1%e7%89%87';
            } else {
                $url = 'https://avbebe.com/archives/category/h%E5%8B%95%E7%95%AB%E5%BD%B1%E7%89%87/page/'.$i;
            }
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);

            $start = explode('<h1 class="archive-title">動畫卡通 Archive</h1>', $html);
            $end = explode('<!-- .posts-default -->' , $start[1]);
            $videos = $end[0];
            $videos = str_replace('【動畫卡通】異種族風俗娘評鑑指南<', '', $videos);
            $videos = str_replace('>[中文字幕]', '', $videos);

            $dom = new \DOMDocument();
            $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$videos);
            $links = $dom->getElementsByTagName('a');
            foreach ($links as $link) {
                $href = $link->getAttribute('href');

                $curl_connection = curl_init($href);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                if (strpos($html, 'fembed') === false && strpos($html, 'odysee') === false && strpos($html, 'xvideos') === false && strpos($html, 'youjizz') === false && strpos($html, 'eporner') === false && strpos($html, 'motherless') === false && strpos($html, 'https://v.avgigi.com/') === false && strpos($html, 'http://v.avgigi.com/') === false && strpos($html, 'https://18av.mm-cg.com/') === false) {
                    if (!in_array($href, $others_list)) {
                        array_push($others_list, $href);
                        echo '<a href="'.$href.'" target="_blank">'.$href.'</a><br>';
                    }
                }
            }
        }
    }

    public function editCaptions()
    {
        return view('layouts.editCaptions');
    }

    public function updateCaptions(Request $request)
    {
        $captions = $request->captions;
        $captions_array = explode(PHP_EOL, $captions);
        $originals = [];
        foreach ($captions_array as $value) {
            if (strpos($value, '-->') !== false) {
                array_push($originals, str_replace("\r", '', $value));
            }
        }

        // return $originals;

        $loop = 0;
        foreach ($originals as $original) {
            if ($loop <= count($originals) - 2) {
                $current = $innerLoop = 0;
                $current_time = explode(' --> ', $original)[1];
                $current_data = explode(':', $current_time);
                foreach ($current_data as $value) {
                    if ($value != '00') {
                        $temp = ltrim($value, '0');
                        switch ($innerLoop) {
                            case 0:
                                $current = $current + $temp * 60 * 60;
                                break;

                            case 1:
                                $current = $current + $temp * 60;
                                break;

                            case 2:
                                $current = $current + $temp;
                                break;
                        }
                    }
                    $innerLoop++;
                }

                $next = $innerLoop = 0;
                $next_time = explode(' --> ', $originals[$loop + 1])[0];
                $next_data = explode(':', $next_time);
                foreach ($next_data as $value) {
                    if ($value != '00') {
                        $temp = ltrim($value, '0');
                        switch ($innerLoop) {
                            case 0:
                                $next = $next + $temp * 60 * 60;
                                break;

                            case 1:
                                $next = $next + $temp * 60;
                                break;

                            case 2:
                                $next = $next + $temp;
                                break;
                        }
                    }
                    $innerLoop++;
                }

                if ($next - $current <= 2) {
                    $captions = str_replace($current_time, $next_time, $captions);
                }

                $loop++;
            }
        }

        return '<pre>'.$captions.'</pre>';
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

    public function updateSpankbang(Request $request)
    {
        if ($number = $request->number && $total = $request->total) {
            Spankbang::updateSpankbang($number, $total);
        } else {
            Spankbang::updateSpankbang(1, 1);
        }
    }

    public function updateSpankbangBackup()
    {
        Spankbang::updateSpankbangBackup();
    }

    public function updateSpankbangBackupReverse()
    {
        Spankbang::updateSpankbangBackupReverse();
    }

    public function updateSpankbangBackupEmergent()
    {
        Spankbang::updateSpankbangBackupEmergent();
    }

    public function updateSpankbangErrors()
    {
        Spankbang::updateSpankbangErrors();
    }

    public function checkSpankbangOutdate()
    {
        Spankbang::checkSpankbangOutdate();
    }

    public function checkSpankbangOutdateEmergent()
    {
        Spankbang::checkSpankbangOutdateEmergent();
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

                /* if ($has_hls2e) {
                    $video->sd = end($mp4);
                } else {
                    $video->sd = end($m3u8);
                } */

                $source = end($mp4);
                $video->sd = $source;
                $video->qualities = [key($mp4) => $source];

                // $video->qualities = $mp4;
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
            curl_setopt($curl_connection, CURLOPT_HTTPHEADER, [
                'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:56.0) Gecko/20100101 Firefox/56.0',
                'Host: www.xvideos.com',
                'Referer: https://www.xvideos.com/account/uploads',
                'Cookie: _ga=GA1.2.979984912.1619035848; _ym_uid=1619035986805725121; _ym_d=1619035986; session_ath=light; wpn_ad_cookie=2d7f6a1b6557fcc3541c8ebd155a6a5b; cit=269de96f64d643f8trKNZ2h_p6KD2L8rLS3CME_iWTcxNWvJR_pQBO01jq-cWTzY2DtjOOAaD2nvL3sm; static_cdn=st; html5_pref=%7B%22SQ%22%3Afalse%2C%22MUTE%22%3Afalse%2C%22VOLUME%22%3A0.2222222222222222%2C%22FORCENOPICTURE%22%3Afalse%2C%22FORCENOAUTOBUFFER%22%3Afalse%2C%22FORCENATIVEHLS%22%3Afalse%2C%22PLAUTOPLAY%22%3Atrue%2C%22CHROMECAST%22%3Afalse%2C%22EXPANDED%22%3Afalse%2C%22FORCENOLOOP%22%3Afalse%7D; xv_nbview=-1; __atssc=google%3B3; html5_networkspeed=23283; __atuvc=0%7C35%2C0%7C36%2C0%7C37%2C12%7C38%2C14%7C39; XVUPLOADSESSION=r8rhm1j3p8pnvf59plp1lq7ij8; X-Backend=12|YVSpX|YVSST; last_subs_check=1; last_views=%5B%2253036937-1619123059%22%2C%2252987433-1619123110%22%2C%2260530141-1619364342%22%2C%2260541891-1619609287%22%2C%2257081613-1619616167%22%2C%2259053767-1620147541%22%2C%2261076445-1620202020%22%2C%2262164807-1620301637%22%2C%2220041059-1620758693%22%2C%2241445071-1620758717%22%2C%2233033023-1620758722%22%2C%2211413559-1620758725%22%2C%2249865955-1620758828%22%2C%2262860583-1620980751%22%2C%2261138175-1621234385%22%2C%2243248989-1621252866%22%2C%2257718577-1622190023%22%2C%2257550447-1622190034%22%2C%2257608373-1622190044%22%2C%2263169015-1622201727%22%2C%2263169151-1622201782%22%2C%2263169499-1622201783%22%2C%2263169551-1622201948%22%2C%2263170473-1622228354%22%2C%2262628061-1623747917%22%2C%2235826351-1623747919%22%2C%2263593625-1626265676%22%2C%2263969411-1626265753%22%2C%2259686393-1626539796%22%2C%2264397887-1627707826%22%2C%2257349879-1627730261%22%2C%2264563787-1628413019%22%2C%2264608799-1628964435%22%2C%2264910597-1629790218%22%2C%2264958809-1629970793%22%2C%2265266759-1631781112%22%2C%2265286145-1631791698%22%2C%2238763731-1632030996%22%2C%2223800858-1632031061%22%2C%2229761517-1632031077%22%2C%2265379407-1632145156%22%2C%2265379637-1632145302%22%2C%2265378687-1632145718%22%2C%2265379913-1632145787%22%2C%2265401981-1632232376%22%2C%2265403877-1632242072%22%2C%2265405785-1632248395%22%2C%2265408449-1632289614%22%2C%2229297141-1632290460%22%2C%2260169631-1632290469%22%2C%2210984616-1632290512%22%2C%2264561087-1632471435%22%2C%2265436107-1632498742%22%2C%2265436219-1632498752%22%2C%2265437969-1632499410%22%2C%2258553571-1632804041%22%2C%2265554077-1632910817%22%2C%2265554185-1632910895%22%2C%2265554323-1632910998%22%2C%2265554409-1632911054%22%2C%2265554479-1632911091%22%2C%2265556777-1632923951%22%2C%2265556595-1632923953%22%2C%2265556679-1632923952%22%2C%2265557267-1632924813%22%2C%2265557401-1632924817%22%2C%2265557513-1632924824%22%2C%2265558055-1632926151%22%2C%2265558435-1632926159%22%2C%2265555977-1632926734%22%2C%2265562135-1632938470%22%5D; session_token=f724a93c1a442aadPk15NWO3TyccV19C5MmAd3HqP_yMLKsLYxD5JBA7e07_jPTwbHEhZ3tz5sY-dv4IHDqT-T7psbYsaKLcY0Pf_sBuy5pnAogivEatPnlbchcPWfoS_8CsH_gMz55qRriJz_tvuYqxcaUFSflswR3fpkhvN8MDRWeUbvCdFrb1uS8VBUP1-tW49mAiLqvI9Ok7mGXgBCUZ8K2o89xno_zl-b1SQ2RMhCuFzJQZXS5tnlSd1-wMWgkVp11-PsNCQVSb6CIFv3khK1DgnNzjD0o85MvMr-oKUSRS1QJeoRBfcUHKd_5VY_0d7aIvn6qqp1sK3Kde77xA_g9FTWhbQyHHSGye3KdBUK-LLFH8AN7sev3iyfIIjODP609CajpXmZPnEf5N8YhpemLS3dxNSOk08qroPaWNiUPz1I4kRaxCXpV2A65a2PKbuLwkeTGERkG5tq_XYKQYC-csFHwe-AeIfO_FhYPCLg1KAv9K-QqAbIvN1rq56ASq9THnuC2tGzXok1SOcDFVpvHh7-6T3ChM7g%3D%3D'
            ]);
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

    public function checkMotherless()
    {
        Motherless::checkMotherless();
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

    public function uploadNhentai()
    {
        Nhentai::uploadNhentai();
    }

    public function translateNhentaiTag(Request $request)
    {
        Nhentai::translateNhentaiTag($request->replace);
    }

    public function updateHanimeCover(Request $request)
    {   
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $videos = Video::where('cover', 'ilike', 'https://i0.wp.com/ba.alphafish.top/%')->get();
        foreach ($videos as $video) {
            $video->cover = str_replace('https://i0.wp.com/ba.alphafish.top/', 'https://i1.wp.com/ba.apperoni.top/', $video->cover);
            $video->save();
        }
    }

    public function comments(Request $request)
    {   
        $comments = Comment::with('video:id,title')->orderBy('created_at', 'desc')->paginate(100);
        return view('layouts.comments', compact('comments')); 
    }

    public function clearLaravelLogs()
    {   
        $files = Arr::where(Storage::disk('log')->files(), function($filename) {
            return Str::endsWith($filename,'.log');
        });


        $count = count($files);

        if(Storage::disk('log')->delete($files)) {
            Log::info(sprintf('Deleted %s %s!', $count, Str::plural('file', $count)));
        } else {
            Log::info('Error in deleting log files!');
        }
    }
}
