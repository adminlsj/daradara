<?php

namespace App\Http\Controllers;

use App\Video;
use App\Bot;
use App\Watch;
use App\Subscribe;
use App\User;
use App\Avatar;
use App\Comment;
use App\Like;
use App\Save;
use App\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Response;
use Mail;
use Auth;
use Image;
use App\Mail\UserReport;
use App\Mail\CopyrightReport;
use App\Mail\UserUploadVideo;
use App\Mail\SubscribeNotify;
use SteelyWing\Chinese\Chinese;
use Redirect;
use simplehtmldom\HtmlWeb;
use Spatie\Browsershot\Browsershot;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        /*$animeFirst = Video::tagsWithLimit(['正版動漫'], 1)->get();
        $animeVid = Video::where('id', '!=', $animeFirst[0]->id)->tagsWithLimit(['正版動漫', '動畫', '動漫講評', 'MAD·AMV'], 7)->get();
        $animeNews = Blog::tagsWithLimit(['動漫情報'])->get();
        $variety = Video::tagsWithLimit(['綜藝'])->get();
        $artist = Video::tagsWithLimit(['明星', '日劇'])->get();
        $meme = Video::tagsWithLimit(['迷因'])->get();
        $daily = Blog::tagsWithLimit(['生活'])->get();
        return view('video.home', compact('animeFirst', 'animeVid', 'animeNews', 'variety', 'artist', 'meme', 'daily'));*/
        return view('video.home');
    }

    public function genre(Request $request)
    {
        $genre = $request->genre;
        $title = Video::$titles[$genre];
        $tags = Video::$tagsArray[$genre];
        return view('video.genre', compact('title', 'tags'));
    }

    public function about(Request $request)
    {
        if ($request->url) {
            return urlencode($request->url);
        }
        return view('layouts.about-us');
    }

    public function contact()
    {
        /* $bot = ['name' => '魔法水果籃 第二季', 'source' => 'https://www.agefans.tv/play/20200158?playid=2_1'];
        $url = explode('?', $bot['source'])[0];
        $query = explode('_', explode('?', $bot['source'])[1])[0];
        $curl_connection = curl_init($url);
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
        $content = curl_exec($curl_connection);
        curl_close($curl_connection);

        $start = explode('<div class="main0" id="main0">', $content);
        $end = explode('<script id="DEF_PLAYINDEX">1</script>' , $start[1]);
        $remove = ['<div class="movurl" style="display:none">', '<ul>', '<li>', '</li>', '</ul>', '</div>', '<div class="movurl" style="display:block">'];
        $html = str_replace($remove, '', $end[0]);
        $dom = new \DOMDocument();
        $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$html);
        $links = $dom->getElementsByTagName('a');
        $linkArray = [];
        foreach ($links as $link){
            if (strpos($query, $link->getAttribute('href')) !== false) {
                $linkArray[] = ['href' => $link->getAttribute('href'), 'text' => ];
            }
            echo $link->nodeValue.'<br>';
        } 

        /* return $requests = Browsershot::url('https://www.agefans.tv/play/20190373?playid=2_28')
            ->useCookies(['username' => 'admin'])
            ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
            ->triggeredRequests(); */


        /*return $requests = Browsershot::url('https://www.agefans.tv/play/20190373?playid=2_1')
            ->useCookies(['username' => 'admin'])
            ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
            ->triggeredRequests();

        $episodes = 132;
        for ($i = 1; $i <= 132; $i++) { 
            $url = 'http://agefans.tw/play/20170172?playid=1_'.$i;
            $requests = Browsershot::url($url)
            ->userAgent('Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A372 Safari/604.1')
            ->triggeredRequests();
            foreach ($requests as $request) {
                if (strpos($request['url'], "http://agefans.tw/static/ck/index.html?url=") !== FALSE) {
                    echo '第'.$i.'話 '.$request['url'].'<br>';
                }
            }
        }*/

        /* $screenshot = Browsershot::url('https://mingxing.xianyongjiu.com/share/fd95ec8df5dbeea25aa8e6c808bad583')
            ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
            ->windowSize(1920, 1080)
            ->setOption('addStyleTag', json_encode(['content' => '.dplayer-controller,.dplayer-controller-mask{ display: none; }']))
            ->waitUntilNetworkIdle()
            ->screenshot();
        $image = Image::make($screenshot);
        $image = $image->crop(1440, 1080);
        $image = $image->resize(1920, null);
        $image = $image->fit(2880, 1620);
        $image = $image->stream();
        $pvars = array('image' => base64_encode($image));
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . '932b67e13e4f069'));
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
        $out = curl_exec($curl);
        curl_close ($curl);
        $pms = json_decode($out, true);
        $imgur = $pms['data']['link'];
        return $imgur;

        $start = 19026;
        $episodes = 132;
        for ($i = 0; $i < $episodes; $i++) {
            $id = $start - $i;
            $url = 'http://agefans.tw/myapp/_get_play_data?id='.$id;
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $data = json_decode(curl_exec($curl_connection), true);
            curl_close($curl_connection);
            if (array_key_exists('result', $data)) {
                echo '第'.($i + 1).'話 '.$data['result']['url'].'<br>';
            } else {
                $i--;
            }
        }

        return Browsershot::url('https://www.agefans.tv/')
                    ->userAgent('Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A372 Safari/604.1')
                    ->setDelay(10000)
                    ->bodyHtml();*/
        return view('layouts.contact');
    }

    public function terms()
    {
        return view('layouts.terms');
    }

    public function policies()
    {
        return view('layouts.policies');
    }

    public function copyright(Request $request)
    {
        if ($request->lang == 'en') {
            return view('layouts.copyright-en');
        } else {
            return view('layouts.copyright-ch');
        }
    }

    public function userReport(Request $request)
    {
        $request->validate([
            'userReportReason' => 'required'
        ]);
        $reason = request('userReportReason');
        if ($reason == '其他原因') {
            $reason = $reason.'：'.request('others-text');
        }
        $video = Video::find(request('video-id'));
        Mail::to('laughseejapan@gmail.com')->send(new UserReport($reason, $video));
        return Redirect::back()->withErrors('感謝您向我們提供意見或回報任何錯誤。');
    }

    public function copyrightReport(Request $request)
    {
        Mail::to(['acura1989akc@gmail.com', 'laughseejapan@gmail.com'])->send(new CopyrightReport($request));
        return Redirect::back()->withErrors('Your complaint has been submitted successfully. We will handle accordingly and email you the latest progress.');
    }

    public function sitemap()
    {
        $videos = Video::orderBy('created_at', 'desc')->get();
        $watches = Watch::orderBy('created_at', 'desc')->get();
        $time = Carbon::now()->format('Y-m-d\Th:i:s').'+00:00';
        return Response::view('layouts.sitemap', compact('videos', 'watches', 'time'))->header('Content-Type', 'application/xml');
    }

    public function check(Request $request)
    {
        if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {
            $videos = Video::where('outsource', false)->orderBy('id', 'desc')->paginate(1);
            $count = Video::where('outsource', false)->orderBy('id', 'desc')->count();

            if ($request->ajax()) {
                return response()->json([
                    'id' => $videos->first()->id,
                    'title' => $videos->first()->title,
                    'link' => $videos->first()->source(),
                    'count' => $count,
                ]);
            }

            return view('layouts.checkVideos', compact('videos'));

        } else {
            return redirect()->action('HomeController@index');
        }
        /*if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {
            $videos = Video::where('outsource', false)->where('sd', 'not like', "%.m3u8%")->orderBy('id', 'desc')->get();
            echo "Video Check STARTED<br>";
            foreach ($videos as $video) {
                foreach ($video->sd() as $url) {
                    if (strpos($url, 'https://www.instagram.com/p/') !== false) {
                        $url = $video->getSourceIG($url);
                        $headers = get_headers($url);
                        $http_response_code = substr($headers[0], 9, 3);
                        if (!($http_response_code == 200)) {
                          echo "<span style='color:red; font-weight:600;'>/watch?v=".$video->id."【".$video->title."】</span><br>";
                        }
                    } elseif (strpos($url, 'https://api.bilibili.com/') !== false) {
                        $curl_connection = curl_init($url);
                        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($curl_connection, CURLOPT_HTTPHEADER, [
                            'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:56.0) Gecko/20100101 Firefox/56.0',
                            'Host: api.bilibili.com',
                            'Cookie: SESSDATA=1feadc09%2C1582358038%2Ca8f2f511;'
                        ]);
                        $data = json_decode(curl_exec($curl_connection), true);
                        curl_close($curl_connection);
                        if (!array_key_exists('data', $data) || !array_key_exists('durl', $data['data'])) {
                            echo "<span style='color:red; font-weight:600;'>/watch?v=".$video->id."【".$video->title."】</span><br>";
                        }
                    }
                }
            }
            echo "Video Check ENDED<br>";
            
        } else {
            return redirect()->action('HomeController@index');
        }*/
    }

    public function checkSubscribes(Request $request)
    {
        if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {
            if ($request->has('c')) {
                $category = $request->c;
                $subscribes = Subscribe::where('tag', $category)->get();

                return view('layouts.checkSubscribesCategory', compact('subscribes'));
                
            } else {
                $subscribes = Subscribe::all();
                $rankings = [];
                foreach ($subscribes as $subscribe) {
                    $exist = false;
                    $position = 0;
                    $i = 0;
                    foreach ($rankings as $rank) {
                        if ($rank['tag'] == $subscribe->tag) {
                            $exist = true;
                            $position = $i;
                            break;
                        }
                        $i++;
                    }
                    if ($exist) {
                        $rankings[$i]['count'] = $rankings[$i]['count'] + 1;
                    } else {
                        array_push($rankings, ['tag' => $subscribe->tag, 'count' => 1]);
                    }
                }
                usort($rankings, function ($a, $b) {
                    return $b['count'] <=> $a['count'];
                });

                return view('layouts.checkSubscribes', compact('rankings'));
            }

        } else {
            return redirect()->action('HomeController@index');
        }
    }

    public function checkZeroSubscribes(Request $request)
    {
        if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {

            $watches = Watch::all();
            $rankings = [];
            foreach ($watches as $watch) {
                if ($watch->subscribes()->count() == 0) {
                    array_push($rankings, ['tag' => $watch->title, 'count' => 0]);
                }
            }

            return view('layouts.checkSubscribes', compact('rankings'));

        } else {
            return redirect()->action('HomeController@index');
        }
    }

    public function videoDurationUpdate(Request $request)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $video = Video::find(Input::get('video'));
        $video->duration = Input::get('dura');
        $out->writeln("Duration is ".Input::get('dura'));
        $video->save();
        return $video;
    }

    public function updateVideos()
    {
        if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {
            $quan = Video::where('sd', 'like', '%1098\_%')->get();
            $qzone = Video::where('sd', 'like', '%1006\_%')->orWhere('sd', 'like', '%1097\_%')->get();
            
            foreach ($quan as $video) {
                $sd = $this->get_string_between($video->sd, 'vmtt.tc.qq.com%2F', '.f0.mp4');
                $video->sd = 'https://www.agefans.tv/age/player/ckx1/?url='.urlencode(Video::getSourceQQ("https://quan.qq.com/video/".$sd));
                $video->save();
            }

            foreach ($qzone as $video) {
                $sd = $this->get_string_between($video->sd, 'vwecam.tc.qq.com%2F', '.f0.mp4');
                $video->sd = 'https://www.agefans.tv/age/player/ckx1/?url='.urlencode(Video::getSourceQZ($sd));
                $video->save();
            }
        }
    }

    public function tempMethod()
    {
        $videos = Video::where('sd', 'like', '%https://www.agefans.tv/age/player/ckx1/?url=https%3A%2F%2Fapd-vliveachy.apdcdn.tc.qq.com%2Fvmtt.tc.qq.com%2F.com%2Fvideo%2F1098_%')->get();
        foreach ($videos as $video) {
            if (strpos($video->sd, 'f0.mp4') === false) {
                $sd = str_replace('https://www.agefans.tv/age/player/ckx1/?url=https%3A%2F%2Fapd-vliveachy.apdcdn.tc.qq.com%2Fvmtt.tc.qq.com%2F.com%2Fvideo%2F', '', $video->sd);
                $video->sd = 'https://www.agefans.tv/age/player/ckx1/?url='.urlencode(Video::getSourceQQ("https://quan.qq.com/video/".$sd));
                $video->outsource = true;
                $video->save();
            }
        }
        return redirect()->action('HomeController@index');
    }

    public function youtubePre(Request $request)
    {
        $video_id = 8355;
        $user_id = 9318;
        $playlist_id = 749;
        Bot::youtubePre($video_id, $user_id, $playlist_id);
    }

    public function bilibiliPrePre(Request $request)
    {
        $mid = 5382023;
        Bot::bilibiliPre($mid);
    }

    public function bilibiliPre(Request $request)
    {
        $mid = 5382023;
        Bot::bilibiliPre($mid);
    }

    public function createDummyVideos(Request $request)
    {
        if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {
            for ($i = 0; $i < $request->count; $i++) {
                $video = Video::create([
                    'user_id' => 1,
                    'playlist_id' => 1,
                    'title' => 'demo',
                    'description' => 'demo',
                    'link' => 'demo',
                    'imgur' => 'demo',
                    'tags' => 'demo',
                    'views' => 0,
                    'outsource' => true,
                    'created_at' => Carbon::now(),
                    'uploaded_at' => Carbon::now(),
                ]);
                $video->delete();
            }
        }
        return redirect()->action('HomeController@index');
    }

    public function editSingleton()
    {
        if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {
            return view('video.editSingleton');
        } else {
            return redirect()->action('HomeController@index');
        }
    }

    public function uploadSingleton(Request $request)
    {
        if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {
            $id = request('video-id');
            $episodes = request('episodes');
            $user_id = request('user-id');
            $playlist_id = request('playlist-id');
            $title = request('title');
            $created_at = new Carbon(Carbon::createFromFormat('Y-m-d\TH:i:s', request('created-at'))->format('Y-m-d H:i:s'));
            $sd = explode(' ', request('sd'));
            for ($i = 1; $i <= $episodes; $i++) {
                $image = Image::make($_FILES["images"]["tmp_name"][$i - 1]);
                $image = $image->fit(2880, 1620);
                $image = $image->stream();
                $pvars = array('image' => base64_encode($image));

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
                curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . '932b67e13e4f069'));
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
                $out = curl_exec($curl);
                curl_close ($curl);
                $pms = json_decode($out, true);
                $url = $pms['data']['link'];

                $zero = $i < 10 ? '0' : '';
                if ($url != "") {
                    $video = Video::create([
                        'id' => $id,
                        'user_id' => $user_id,
                        'playlist_id' => $playlist_id,
                        'title' =>  $title.'【第'.$i.'話】',
                        'caption' => $title.'【第'.$zero.$i.'話】',
                        'tags' => request('tags'),
                        'views' => 0,
                        'imgur' => $this->get_string_between($url, 'https://i.imgur.com/', '.'),
                        'sd' => '',
                        'outsource' => false,
                        'created_at' => $created_at,
                        'uploaded_at' => $created_at,
                    ]);
                    $created_at = $created_at->addDays(7);
                    $id++;
                }
            }
        }

        return redirect()->action('HomeController@index');
    }

    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
