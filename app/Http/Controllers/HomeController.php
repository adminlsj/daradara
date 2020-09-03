<?php

namespace App\Http\Controllers;

use App\Video;
use App\Bot;
use App\Watch;
use App\Subscribe;
use App\User;
use App\Comment;
use App\Like;
use App\Save;
use App\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Response;
use Auth;
use Image;
use Mail;
use App\Mail\UserReport;
use App\Mail\UserUploadVideo;
use App\Mail\SubscribeNotify;
use SteelyWing\Chinese\Chinese;
use Redirect;
use simplehtmldom\HtmlWeb;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Schema;
use Config;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $excluded = Video::getExcludedIds();

        $banner = Video::find(12872);
        $count = 20;
        $upload = Video::where('cover', '!=', null)->orderBy('id', 'desc')->limit($count)->get();
        $trending = Video::where('cover', '!=', null)->whereNotIn('id', $excluded)->orderBy('views', 'desc')->limit($count)->get();
        $newest =Video::where('cover', '!=', null)->whereNotIn('id', $excluded)->orderBy('created_at', 'desc')->limit($count)->get();
        $tag1 = Video::where('cover', '!=', null)->where('tags', 'ilike', '%巨乳%')->inRandomOrder()->limit($count)->get();
        $tag2 = Video::where('cover', '!=', null)->where('tags', 'ilike', '%貧乳%')->inRandomOrder()->limit($count)->get();
        $tag3 = Video::where('cover', '!=', null)->where('tags', 'ilike', '%肛交%')->inRandomOrder()->limit($count)->get();
        $tag4 = Video::where(function($query) {
            $query->orWhere('tags', 'like', '%扶他%')->orWhere('tags', 'like', '%偽娘%')->orWhere('tags', 'like', '%耽美%');
        })->where('cover', '!=', null)->inRandomOrder()->limit($count)->get();
        $tag5 = Video::where('cover', '!=', null)->inRandomOrder()->limit($count)->get();

        $rows = [
            '最新上傳' => ['videos' => $upload, 'link' => '/search?query=&sort=最新上傳'], 
            '發燒影片' => ['videos' => $trending, 'link' => '/search?query=&sort=觀看次數'], 
            '最新內容' => ['videos' => $newest, 'link' => '/search?query=&sort=最新內容'], 
            '乳不巨何以聚人心' => ['videos' => $tag1, 'link' => '/search?query=&tags%5B%5D=巨乳&sort='], 
            '胸不平何以平天下' => ['videos' => $tag2, 'link' => '/search?query=&tags%5B%5D=貧乳&sort='], 
            '菊不爆何以保家園' => ['videos' => $tag3, 'link' => '/search?query=&tags%5B%5D=肛交&sort='], 
            '女不腐何以撫民心' => ['videos' => $tag4, 'link' => '/search?query=&broad=on&tags%5B%5D=扶他&tags%5B%5D=偽娘&tags%5B%5D=耽美'], 
            '更多精彩內容' => ['videos' => $tag5, 'link' => '/search']
        ];

        return view('layouts.home', compact('banner', 'rows'));
    }

    public function search(Request $request)
    {
        $tags = [];
        $brands = [];
        $videos = Video::where('cover', '!=', null);

        $excluded = Video::getExcludedIds();
        
        if ($query = request('query')) {
            $query = str_replace(' ', '', request('query'));
            $queryArray = [];
            preg_match_all('/./u', $query, $queryArray);
            $queryArray = $queryArray[0];
            if (($key = array_search(' ', $queryArray)) !== false) {
                unset($queryArray[$key]);
            }
            $searchQuery = '%'.implode('%', $queryArray).'%';
            $videos = $videos->where(function($query) use ($searchQuery) {
                $query->where('title', 'ilike', $searchQuery)->orWhere('translations', 'ilike', $searchQuery)->orWhere('tags', 'ilike', $searchQuery);
            });

        } else {
            $videos = $videos->whereNotIn('id', $excluded);
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

        switch ($request->sort) {
            case '本日排行':
                $videos = $videos->where('data', '!=', null)->select('id', 'title', 'cover', 'data')->get()->toArray();
                usort($videos, function ($a, $b) {
                    return end($b['data']['views']['increment']) - end($a['data']['views']['increment']);
                });

                $page = Input::get('page', 1); // Get the ?page=1 from the url
                $perPage = 42; // Number of items per page
                $offset = ($page * $perPage) - $perPage;

                $videos = new LengthAwarePaginator(
                    array_slice($videos, $offset, $perPage, true), // Only grab the items we need
                    count($videos), // Total items
                    $perPage, // Items per page
                    $page, // Current page
                    ['path' => $request->url(), 'query' => $request->query()] // We need this so we can keep all old query parameters from the url
                );

                return view('layouts.search', compact('tags', 'brands', 'videos'));

                break;

            case '最新內容':
                $videos = $videos->orderBy('created_at', 'desc');
                break;

            case '最新上傳':
                $videos = $videos->orderBy('id', 'desc');
                break;

            case '觀看次數':
                $videos = $videos->orderBy('views', 'desc');
                break;

            default:
                $videos = $videos->orderBy('created_at', 'desc');
                break;
        }

        $videos = $videos->distinct()->paginate(42);

        return view('layouts.search', compact('tags', 'brands', 'videos'));
    }

    public function list()
    {
        $saved = Save::where('user_id', Auth::user()->id)->pluck('foreign_id');
        $videos = Video::whereIn('id', $saved)->orderBy('created_at', 'desc')->get();
        return view('layouts.list', compact('videos'));
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
        $videos = Video::where('cover', '!=', null)->orderBy('created_at', 'desc')->get();
        $time = Carbon::now()->format('Y-m-d\Th:i:s').'+00:00';
        return Response::view('layouts.sitemap', compact('videos', 'time'))->header('Content-Type', 'application/xml');
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
        $requests = Browsershot::url('https://spankbang.com/4anle/video/lucky+man+get+to+be+sucked+by+bitch+hardly')
                    ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                    ->triggeredRequests();
        foreach ($requests as $request) {
            if (strpos($request['url'], 'spankbang.com/stream/') !== false && strpos($request['url'], '.mp4') !== false) {
                $curl_connection = curl_init();
                curl_setopt($curl_connection, CURLOPT_URL, $request['url']);
                curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, true); // follow the redirects
                curl_setopt($curl_connection, CURLOPT_NOBODY, true); // get the resource without a body
                curl_exec($curl_connection);
                $redirect = curl_getinfo($curl_connection, CURLINFO_EFFECTIVE_URL);
                curl_close($curl_connection);
                return str_replace('720p', '1080p', $redirect);
                $video->outsource = false;
                $video->save();
            }
        }
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

    public function updateSlutload(Request $request)
    {
        $videos = Video::where('tags', 'ilike', '%裏番%')->where('foreign_sd', '!=', null)->get();
        foreach ($videos as $video) {
            if (array_key_exists('slutload', $video->foreign_sd)) {
                $requests = Browsershot::url($video->foreign_sd['slutload'])
                    ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                    ->triggeredRequests();
                foreach ($requests as $request) {
                    if (strpos($request['url'], 'https://v-rn.slutload-media.com/') !== false) {
                        $video->sd = $request['url'];
                        $video->outsource = false;
                        $video->save();
                    }
                }
            }
        }
    }

    public function updateHentai(Request $request)
    {
        $videos = Video::where('tags', 'ilike', '%裏番%')->where('foreign_sd', '!=', null)->get();
        foreach ($videos as $video) {
            if (array_key_exists('spankbang', $video->foreign_sd)) {
                $requests = Browsershot::url($video->foreign_sd['spankbang'])
                    ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                    ->triggeredRequests();
                foreach ($requests as $request) {
                    if (strpos($request['url'], 'spankbang.com/stream/') !== false && strpos($request['url'], '.mp4') !== false) {
                        $second_requests = Browsershot::url($request['url'])
                            ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                            ->triggeredRequests();
                        foreach ($second_requests as $second_request) {
                            if (strpos($second_request['url'], 'vdownload') !== false && strpos($second_request['url'], '.mp4') !== false) {
                                $video->sd = str_replace('720p', '1080p', $second_request['url']);
                                $video->outsource = false;
                                $video->save();
                            }
                        }
                    }
                }
                
            } elseif (array_key_exists('youjizz', $video->foreign_sd)) {
                $requests = Browsershot::url($video->foreign_sd['youjizz'])
                    ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                    ->triggeredRequests();
                foreach ($requests as $request) {
                    if (strpos($request['url'], 'https://cdne-mobile.youjizz.com/') !== false && strpos($request['url'], '.mp4') !== false) {
                        $video->sd = $request['url'];
                        $video->outsource = false;
                        $video->save();
                    }
                }
                
            } elseif (array_key_exists('slutload', $video->foreign_sd)) {
                $requests = Browsershot::url($video->foreign_sd['slutload'])
                    ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
                    ->triggeredRequests();
                foreach ($requests as $request) {
                    if (strpos($request['url'], 'https://v-rn.slutload-media.com/') !== false) {
                        $video->sd = $request['url'];
                        $video->outsource = false;
                        $video->save();
                    }
                }
                
            }
        }
    }

    function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
