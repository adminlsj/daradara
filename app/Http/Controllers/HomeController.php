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
use App\Feedback;
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
use Illuminate\Support\Facades\Schema;
use Config;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $banner = Video::find(12872);
        $count = 20;
        $upload = Video::where('cover', '!=', null)->orderBy('created_at', 'asc')->limit($count)->get();
        $trending = Video::where('cover', '!=', null)->orderBy('views', 'desc')->limit($count)->get();
        $newest =Video::where('cover', '!=', null)->orderBy('created_at', 'desc')->limit($count)->get();
        $tag1 = Video::where('cover', '!=', null)->where('tags', 'ilike', '%巨乳%')->inRandomOrder()->limit($count)->get();
        $tag2 = Video::where('cover', '!=', null)->where('tags', 'ilike', '%貧乳%')->inRandomOrder()->limit($count)->get();
        $tag3 = Video::where('cover', '!=', null)->where('tags', 'ilike', '%肛交%')->inRandomOrder()->limit($count)->get();
        $tag4 = Video::where(function($query) {
            $query->orWhere('tags', 'like', '%扶他%')->orWhere('tags', 'like', '%偽娘%')->orWhere('tags', 'like', '%耽美%');
        })->where('cover', '!=', null)->inRandomOrder()->limit($count)->get();
        $tag5 = Video::where('cover', '!=', null)->inRandomOrder()->limit($count)->get();

        $rows = ['最新上傳' => $upload, '發燒影片' => $trending, '最新內容' => $newest, '乳不巨何以聚人心' => $tag1, '胸不平何以平天下' => $tag2, '菊不爆何以保家園' => $tag3, '女不腐何以撫民心' => $tag4, '更多精彩內容' => $tag5];

        return view('layouts.home', compact('banner', 'rows'));
    }

    public function search(Request $request)
    {
        $tags = [];
        $brands = [];
        $videos = Video::where('cover', '!=', null);

        if ($query = $request->query) {
            $query = str_replace(' ', '', request('query'));
            $queryArray = [];
            preg_match_all('/./u', $query, $queryArray);
            $queryArray = $queryArray[0];
            if (($key = array_search(' ', $queryArray)) !== false) {
                unset($queryArray[$key]);
            }
            $searchQuery = '%'.implode('%', $queryArray).'%';
            $videos = $videos->where(function($query) use ($searchQuery) {
                $query->where('title', 'ilike', $searchQuery)->orWhere('tags', 'ilike', $searchQuery);
            });
        }

        if ($tags = $request->tags) {
            if ($request->broad) {
                $videos = $videos->where(function($query) use ($tags) {
                    foreach ($tags as $tag) {
                        $query->orWhere('tags', 'ilike', '%'.$tag.'%');
                    }
                });
            } else {
                $videos = $videos->where(function($query) use ($tags) {
                    foreach ($tags as $tag) {
                        $query->where('tags', 'ilike', '%'.$tag.'%');
                    }
                });
            }
        }

        if ($brands = $request->brands) {
            $videos = $videos->where(function($query) use ($brands) {
                foreach ($brands as $brand) {
                    $query->orWhere('tags', 'ilike', '%'.$brand.'%');
                }
            });
        }

        if ($sort = $request->sort) {
            switch ($sort) {
                case '觀看次數':
                    $videos = $videos->orderBy('views', 'desc');
                    break;
            }
        }

        $videos = $videos->distinct()->orderBy('created_at', 'desc')->paginate(42);

        return view('layouts.search', compact('tags', 'brands', 'videos'));
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
        $feedbacks = Feedback::orderBy('created_at', 'desc')->get();
        return view('layouts.contact', compact('feedbacks'));
    }

    public function createFeedback()
    {
        $feedback = Feedback::create([
            'name' => request('name'),
            'email' => request('email'),
            'text' => request('text'),
        ]);

        return redirect()->action('HomeController@contact');
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
        /* if ($request->lang == 'en') {
            return view('layouts.copyright-en');
        } else {
            return view('layouts.copyright-ch');
        } */

        return view('layouts.copyright-en');
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

    public function checkKum(Request $request)
    {
        if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {

            $videos = Video::where('sd', 'ilike', '%https://cdn-videos.kum.com%')->get();
            
            echo "Video Check STARTED<br>";

            foreach ($videos as $video) {
                ini_set('memory_limit', '-1');
                ini_set('max_execution_time', 0); 
                $ch = curl_init($video->sd);
                curl_setopt($ch, CURLOPT_HEADER, 1);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:62.0) Gecko/20100101 Firefox/62.0');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                $response = curl_exec($ch);
                $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                $header = substr($response, 0, $header_size);
                $http_response_code = substr($header, 9, 3);
                if (!($http_response_code == 200)) {
                  echo "<span style='color:red; font-weight:600;'>/watch?v=".$video->id."【".$video->title."】【".$video->created_at."】</span><br>";
                }
            }

            echo "Video Check ENDED<br>";

        }
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
                $sd = $this->get_string_between($video->sd, 'vwecam.tc.qq.com%2F', '.f20.mp4');
                $qzone = urlencode(Video::getSourceQZ($sd));
                if ($qzone != '') {
                    $video->sd = 'https://www.agefans.tv/age/player/ckx1/?url='.$qzone;
                    $video->save();
                }
            }
        }
    }

    public function tempMethod()
    {
        $subscribes = Subscribe::where('playlist_id', null)->get();
        foreach ($subscribes as $subscribe) {
            $watch = Watch::where('title', $subscribe->tag)->first();
            $subscribe->playlist_id = $watch->id;
            $subscribe->save();
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
            $link = request('link');
            $created_at = new Carbon(Carbon::createFromFormat('Y-m-d\TH:i:s', request('created-at'))->format('Y-m-d H:i:s'));
            $imageLinks = explode("\n", request('images'));

            for ($i = 1; $i <= $episodes; $i++) {
                $imageLink = trim($imageLinks[$i-1]);
                $imgur = Bot::uploadUrlImage($imageLink);
                $zero = $i < 10 ? '0' : '';
                if ($imgur != "") {
                    $video = Video::create([
                        'id' => $id,
                        'user_id' => $user_id,
                        'playlist_id' => $playlist_id,
                        'title' =>  $title.'【第'.$i.'話】',
                        'caption' => $title.'【第'.$zero.$i.'話】',
                        'tags' => request('tags'),
                        'views' => 0,
                        'imgur' => $this->get_string_between($imgur, 'https://i.imgur.com/', '.'),
                        'sd' => $link,
                        'outsource' => true,
                        'created_at' => $created_at,
                        'uploaded_at' => $created_at,
                    ]);
                    $created_at = $created_at->addDays(7);
                    $id++;

                    $url = explode('?', $link)[0];
                    $query = explode('?', $link)[1];
                    $playlist = explode('_', $query)[0];
                    $episode = explode('_', $query)[1];
                    $link = $url.'?'.$playlist.'_'.($episode + 1);
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
