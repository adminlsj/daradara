<?php

namespace App\Http\Controllers;

use App\Video;
use App\Playlist;
use App\User;
use App\Subscribe;
use App\Like;
use App\Save;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Storage;
use File;
use Image;
use DB;
use Auth;
use App\Mail\Contact;
use App\Mail\ContactUser;
use Carbon\Carbon;
use Response;

class HomeController extends Controller
{
    public function index(Request $request){
        $subscribes = [];
        if (auth()->check()) {
            $subscriptions = auth()->user()->subscribes();
            if (!$subscriptions->isEmpty()) {
                $first = true;
                foreach ($subscriptions as $subscribe) {
                    if ($first) {
                        if ($subscribe->type == 'watch') {
                            $playlist = Playlist::where('title', $subscribe->tag)->first();
                            $subscribes = Video::where('playlist_id', $playlist->id);
                        } else {
                            $subscribes = Video::where('tags', 'LIKE', '%'.$subscribe->tag.'%');
                        }
                        $first = false;
                    } else {
                        if ($subscribe->type == 'watch') {
                            $playlist = Playlist::where('title', $subscribe->tag)->first();
                            $subscribes = $subscribes->orWhere('playlist_id', $playlist->id);
                        } else {
                            $subscribes = $subscribes->orWhere('tags', 'LIKE', '%'.$subscribe->tag.'%');
                        }
                    }
                }

                $subscribes = $subscribes->whereDate('uploaded_at', '>=', Carbon::now()->subMonths(6))->orderBy('uploaded_at', 'desc')->limit(16)->get();
            }
        }

        $selected = Video::where('user_id', 1809)->inRandomOrder()->limit(16)->get();
        $trendings = Video::whereDate('uploaded_at', '>=', Carbon::now()->subWeeks(2))->inRandomOrder()->limit(16)->get();
        $newest = Video::orderBy('uploaded_at', 'desc')->limit(16)->get();
        $load_more = Video::whereDate('uploaded_at', '>=', Carbon::now()->subWeeks(2))->orderBy('views', 'desc')->paginate(12);

        $html = '';
        foreach ($load_more as $video) {
            $html .= view('video.load-more', compact('video'));
        }
        if ($request->ajax()) {
            return $html;
        }

        $is_mobile = $this->checkMobile();

        return view('home.index', compact('selected', 'trendings', 'newest', 'load_more', 'is_mobile', 'subscribes'));
    }

    public function search(Request $request)
    {
        $query = str_replace(' ', '', request('query'));

        $queryArray = [];
        preg_match_all('/./u', $query, $queryArray);
        $queryArray = $queryArray[0];
        if (($key = array_search(' ', $queryArray)) !== false) {
            unset($queryArray[$key]);
        }

        $videosArray = [];
        $idsArray = [];

        // Exact Match Query [e.g. 2012.09.14]
        $lowerQuery = '';
        $upperQuery = '';
        $exactQuery = [];
        foreach ($queryArray as $char) {
            if (preg_match("/^[a-zA-Z]$/", $char)) {
                $lowerQuery = $lowerQuery.strtolower($char);
                $upperQuery = $upperQuery.strtoupper($char);
            } else {
                $lowerQuery = $lowerQuery.$char;
                $upperQuery = $upperQuery.$char;
            }
        }
        if ($lowerQuery == $upperQuery) {
            $exactQuery = Video::where('title', 'like', '%'.$lowerQuery.'%')->orderBy('uploaded_at', 'desc')->distinct()->get();
        } else {
            $exactQuery = Video::where('title', 'like', '%'.$lowerQuery.'%')->orWhere('title', 'like', '%'.$upperQuery.'%')->orderBy('uploaded_at', 'desc')->distinct()->get();
        }
        foreach ($exactQuery as $q) {
            if (!in_array($q->id, $idsArray)) {
                array_push($videosArray, $q);
                array_push($idsArray, $q->id);
            }
        }

        // Exact Order Match Query (search query in same order e.g. 2012 => 2>0>1>2) [e.g. 2012 09 14]
        $exactOrderQueryScope = '%'.implode('%', $queryArray).'%';
        $exactOrderQuery = Video::where('title', 'like', $exactOrderQueryScope)->orderBy('uploaded_at', 'desc')->get();
        foreach ($exactOrderQuery as $q) {
            if (!in_array($q->id, $idsArray)) {
                array_push($videosArray, $q);
                array_push($idsArray, $q->id);
            }
        }

        // Character Match Query (search query as a whole e.g. 2012 => contains 2/0/1/2) [e.g. 郡司桑 月曜]
        $videosSelect = Video::orderBy('uploaded_at', 'desc')->select('id', 'title', 'tags')->get()->toArray();
        $rankings = [];
        foreach ($videosSelect as $videoSelect) {
            $score = 0;
            foreach ($queryArray as $q) {
                if (is_numeric($q)) {
                    if (strpos($videoSelect['title'], $q) !== false) {
                        $score++;
                    }
                } else {
                    if (strpos($videoSelect['title'], $q) !== false) {
                        $score++;
                    }
                    if (strpos($videoSelect['tags'], $q) !== false) {
                        $score++;
                    }
                }
            }
            if ($score > 0) {
                array_push($rankings, ['score' => $score, 'id' => $videoSelect['id']]);
            }
        }
        usort($rankings, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        foreach ($rankings as $rank) {
            if (!in_array($rank['id'], $idsArray)) {
                array_push($videosArray, Video::find($rank['id']));
            }
        }

        $playlist = $videosArray[0]->playlist_id == '' ? null : $videosArray[0]->playlist();
        $topResults = array_slice($videosArray, 0, 15);

        $page = Input::get('page', 1) + 1; // Get the ?page=1 from the url
        $perPage = 15; // Number of items per page
        $offset = ($page * $perPage) - $perPage;

        $videos = new LengthAwarePaginator(
            array_slice($videosArray, $offset, $perPage, true), // Only grab the items we need
            count($videosArray), // Total items
            $perPage, // Items per page
            $page, // Current page
            ['path' => $request->url(), 'query' => $request->query()] // We need this so we can keep all old query parameters from the url
        );

        $html = $this->searchLoadHTML($videos);
        if ($request->ajax()) {
            return $html;
        }

        return view('home.search', compact('videos', 'playlist', 'query', 'topResults'));
    }

    public function searchLoadHTML($videos)
    {
        $html = '';
        $is_program = false;
        foreach ($videos as $video) {
            $html .= view('home.search-single', compact('video', 'is_program'));
        }
        return $html;
    }

    public function checkMobile()
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $is_mobile = false;
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) { 
            $is_mobile = true;
        }
        return $is_mobile;
    }

    public function aboutUs()
    {
        /*$playlist = Playlist::create([
            'id' => 1,
            'user_id' => 1,
            'title' => '超異域公主連結 Re:Demo',
            'description' => 'Cygames製作奇幻風格角色扮演手機遊戲續篇改編成動畫。在和風吹拂的美麗大地·阿斯特雷亞大陸。在大陸的一角，失去記憶的少年·佑樹醒了過來。照顧他的小小嚮導·可可蘿。總是肚子空空的美少女劍士·佩可莉露。略顯高冷的貓耳魔法少女·凱露。他們就這麼在命運引導下，建立起名為「美食殿」的公會。現在，佑樹與她們的冒險即將開幕——',
        ]);*/
        /*$video = Video::create([
            'id' => 1,
            'user_id' => 1,
            'playlist_id' => 1,
            'title' => '超異域公主連結 Re:Demo【第2話】',
            'description' => '',
            'link' => 'https://cdn-yong.bejingyongjiu.com/share/a7bf3f5462cc82062e41b3a2262e1a21',
            'imgur' => 'MnDFAw7',
            'tags' => '超異域公主連結 プリンセスコネクト Re:Dive 動漫',
            'views' => 0,
            'outsource' => true,
            'created_at' => Carbon::now(),
            'uploaded_at' => Carbon::now(),
        ]);*/
        return view('layouts.about-us');
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
            return redirect()->action('VideoController@home');
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
            return redirect()->action('VideoController@home');
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
            return redirect()->action('VideoController@home');
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
            return redirect()->action('VideoController@home');
        }
    }

    /* public function categoryEdit()
    {
        $is_program = false;
        return view('video.categoryEdit', compact('is_program')); 
    }

    public function categoryUpdate(Request $request)
    {
        $videos = Video::where('category', request('category'))->orderBy('created_at', 'asc')->get();
        $links = request('sourceLinks');
        $links = preg_split('/\r\n|\r|\n/', $links);

        for ($i = 0; $i < count($links); $i++) { 
            $links[$i] = trim($links[$i]);
            if (($pos = strpos($links[$i], "$")) !== FALSE) { 
                $links[$i] = trim(substr($links[$i], $pos + 1));
            }
        }

        for ($i = 0; $i < count($videos); $i++) { 
            $videos[$i]->sd = $links[$i];
            $videos[$i]->hd = $links[$i];
            $videos[$i]->outsource = true;
            $videos[$i]->save();
        }

        return redirect()->action('HomeController@categoryEdit', ['is_program' => false]);
    }

    public function singleNewCreate()
    {
        if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {
            $is_program = false;
            return view('video.singleNewCreate', compact('is_program')); 

        } else {
            return redirect()->action('VideoController@home');
        }
    }

    public function singleNewStore(Request $request)
    {
        if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {
            $latest = Video::where('category', request('category'))->orderBy('uploaded_at', 'desc')->first();
            $title = request('title');
            if ($title == "") {
                $prevEpisode = $this->get_string_between($latest->title, '【第', '話】');
                $episode = $prevEpisode;
                if (is_numeric($prevEpisode) && floor($prevEpisode) != $prevEpisode) {
                    $episode = $prevEpisode + 0.5;
                } else {
                    $episode = $prevEpisode + 1;
                }
                $title = str_replace($prevEpisode, $episode, $latest->title);
            }

            $video = Video::create([
                'id' => Video::orderBy('id', 'desc')->first()->id + 1,
                'title' => $title,
                'caption' => request('caption'),
                'hd' => request('link'),
                'sd' => request('link'),
                'imgur' => request('imgur'),
                'genre' => $latest->genre,
                'category' => $latest->category,
                'season' => $latest->season,
                'tags' => request('tags') == "" ? $latest->tags : request('tags'),
                'views' => request('views') == "" ? $latest->views : request('views'),
                'duration' => request('duration') == "" ? $latest->duration : request('duration'),
                'outsource' => false,
                'created_at' => Carbon::createFromFormat('Y-m-d\TH:i:s', request('created_at'))->format('Y-m-d H:i:s'),
                'uploaded_at' => Carbon::createFromFormat('Y-m-d\TH:i:s', request('uploaded_at'))->format('Y-m-d H:i:s'),
            ]);

            foreach ($video->sd() as $sd) {
                $video->sd = str_replace($sd, Video::getLinkBB($sd, $video->outsource), $video->sd);
                $video->save();
            }

            $users = [];
            $userArray = [];

            if ($video->category != 'video') {
                $watch = $video->watch();
                $watch->updated_at = $video->uploaded_at;
                $watch->save();

                $subscribes = $watch->subscribes();
                foreach ($subscribes as $subscribe) {
                    $user = $subscribe->user();
                    array_push($userArray, $user->id);
                }
            }

            foreach ($video->tags() as $tag) {
                $subscribes = Subscribe::where('tag', $tag)->get();
                foreach ($subscribes as $subscribe) {
                    if (!in_array($subscribe->user()->id, $userArray)) {
                        array_push($userArray, $subscribe->user()->id);
                    }
                }
            }

            foreach ($userArray as $user_id) {
                array_push($users, User::find($user_id));
            }

            foreach ($users as $user) {
                Mail::to($user->email)->send(new SubscribeNotify($user, $video));
                if (strpos($user->alert, 'subscribe') === false) {
                    $user->alert = $user->alert."subscribe";
                    $user->save();
                }
            }

            return redirect()->action('HomeController@singleNewCreate');

        } else {
            return redirect()->action('VideoController@home');
        }
    } */

    public function videoDurationUpdate(Request $request)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $video = Video::find(Input::get('video'));
        $video->duration = Input::get('dura');
        $out->writeln("Duration is ".Input::get('dura'));
        $video->save();
        return $video;
    }

    /* public function bccToSrt(Request $request){
        $url = request('url');
        try {
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $data = json_decode(curl_exec($curl_connection), true);
            curl_close($curl_connection);

            for ($i=0; $i < count($data['body']); $i++) { 
                $current = $data['body'][$i];
                echo ($i + 1).'<br>';

                $from_seconds = floor($current['from']);
                $from_miliseconds = floor(($current['from'] - floor($current['from'])) * 1000);
                if ($from_miliseconds < 100) {
                    $from_miliseconds = $from_miliseconds.'0';
                }

                $from_hours = floor($from_seconds / 3600);
                $from_mins = floor($from_seconds / 60 % 60);
                $from_secs = floor($from_seconds % 60);

                if ($from_hours < 10) {
                    $from_hours = '0'.$from_hours;
                }
                if ($from_mins < 10) {
                    $from_mins = '0'.$from_mins;
                }
                if ($from_secs < 10) {
                    $from_secs = '0'.$from_secs;
                }

                $to_seconds = floor($current['to']);
                $to_miliseconds = ($current['to'] - floor($current['to'])) * 1000;
                $to_miliseconds = floor(($current['from'] - floor($current['from'])) * 1000);
                if ($to_miliseconds < 100) {
                    $to_miliseconds = $to_miliseconds.'0';
                }
                
                $to_hours = floor($to_seconds / 3600);
                $to_mins = floor($to_seconds / 60 % 60);
                $to_secs = floor($to_seconds % 60);

                if ($to_hours < 10) {
                    $to_hours = '0'.$to_hours;
                }
                if ($to_mins < 10) {
                    $to_mins = '0'.$to_mins;
                }
                if ($to_secs < 10) {
                    $to_secs = '0'.$to_secs;
                }

                echo $from_hours.':'.$from_mins.':'.$from_secs.','.$from_miliseconds.' --> '.$to_hours.':'.$to_mins.':'.$to_secs.','.$to_miliseconds.'<br>';

                echo $current['content'];
                echo '<br>';
                echo '<br>';
            }

        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function tempMethods()
    {
        if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {
            $videos = Video::all();
            foreach ($videos as $video) {
                $loop = 0;
                foreach ($video->sd() as $url) {
                    if (strpos($url, "api.bilibili.com") !== FALSE) {
                        $avid = '';
                        $bvid = '';
                        $cid = '';
                        $page = 1;
                        if (strpos($url, "avid=") !== FALSE) { 
                            $avid = $this->get_string_between($url, 'avid=', '&');
                        }
                        if (strpos($url, "bvid=") !== FALSE) { 
                            $bvid = $this->get_string_between($url, 'bvid=', '&');
                        }
                        if (strpos($url, "cid=") !== FALSE) { 
                            $cid = $this->get_string_between($url, 'cid=', '&');
                        }
                        if (($pos = strpos($video->hd, "?p=")) !== FALSE) { 
                            $page = substr($video->hd, $pos + 3);
                        }

                        $video->sd = str_replace($url, '//player.bilibili.com/player.html?aid='.$avid.'&bvid='.$bvid.'&cid='.$cid.'&page='.$page.'&danmaku=0&qn=0&type=mp4&otype=json&fnver=0&fnval=1&platform=html5&html5=1&high_quality=1', $video->sd);
                        $video->outsource = true;
                        $video->save();
                    }
                    $loop++;
                }
            }
        }
        return redirect()->action('VideoController@home');
    } */

    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
