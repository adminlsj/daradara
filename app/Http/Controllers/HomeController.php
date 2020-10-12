<?php

namespace App\Http\Controllers;

use App\Video;
use App\Watch;
use App\Subscribe;
use App\Bot;
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
use Mail;
use App\Mail\UserReport;
use App\Mail\UserUploadVideo;
use Redirect;
use Spatie\Browsershot\Browsershot;
use Illuminate\Pagination\LengthAwarePaginator;
use Storage;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $banner = Video::find(13654);
        $excluded = Video::getExcludedIds();
        $count = 20;

        $upload = Video::whereOrderBy('id', $excluded, $count)->get();
        $newest = Video::whereOrderBy('created_at', $excluded, $count)->get();
        $trending = Video::whereOrderBy('views', $excluded, $count)->get();

        $tag1 = Video::whereHasTags(['巨乳'], $excluded, $count)->get();
        $tag2 = Video::whereHasTags(['貧乳'], $excluded, $count)->get();
        $tag3 = Video::whereHasTags(['肛交'], $excluded, $count)->get();
        $tag4 = Video::whereHasTags(['扶他', '偽娘', '耽美'], $excluded, $count)->get();
        $tag5 = Video::whereHasTags([''], $excluded, $count)->get();

        $rows = [
            '最新上傳' => ['videos' => $upload, 'link' => '/search?query=&sort=最新上傳'], 
            '最新內容' => ['videos' => $newest, 'link' => '/search?query=&sort=最新內容'],
            '發燒影片' => ['videos' => $trending, 'link' => '/search?query=&sort=觀看次數'], 
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
            $videos = $videos->whereIntegerNotInRaw('id', $excluded);
        }

        if ($tags = $request->tags) {
            if ($request->broad) {
                $videos = $videos->where(function($query) use ($tags) {
                    foreach ($tags as $tag) {
                        $query->orWhere('tags', 'ilike', $tag.'%')->orWhere('tags', 'ilike', '% '.$tag.' %');
                    }
                });
            } else {
                foreach ($tags as $tag) {
                    $videos = $videos->where(function($query) use ($tag) {
                        $query->orWhere('tags', 'ilike', $tag.'%')->orWhere('tags', 'ilike', '% '.$tag.' %');
                    });
                }
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
        $videos = Video::where('cover', '!=', null)->whereIntegerInRaw('id', Auth::user()->saves->pluck('video_id'))->orderBy('created_at', 'desc')->select('id', 'title', 'cover')->get();
        return view('layouts.list', compact('videos'));
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
        /* $requests = Browsershot::url('https://www.eporner.com/video-VGtg33oz99l/karde-im-emziriyor-yan-mama-2/')
            ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
            ->triggeredRequests();
        foreach ($requests as $request) {
            if (strpos($request['url'], 'https://www.eporner.com/xhr/video/') !== false && strpos($request['url'], 'mp4') !== false) {
                $curl_connection = curl_init($request['url']);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $data = json_decode(curl_exec($curl_connection), true);
                curl_close($curl_connection);
                return $data['sources']['mp4']['1080p HD']['src'];
            }
        } */
        return view('layouts.terms');
    }

    public function policies()
    {
        return view('layouts.policies');
    }

    public function copyright(Request $request)
    {
        return view('layouts.copyright-en');
    }

    public function p2257(Request $request)
    {
        return view('layouts.2257');
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
        $ip_address = isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : 'N/A';
        $country_code = isset($_SERVER["HTTP_CF_IPCOUNTRY"]) ? $_SERVER["HTTP_CF_IPCOUNTRY"] : 'N/A';
        Mail::to('laughseejapan@gmail.com')->send(new UserReport($reason, $video, $ip_address, $country_code));
        return Redirect::back()->withErrors('感謝您向我們提供意見或回報任何錯誤。');
    }

    public function getSitemap()
    {
        $sitemap = Storage::disk('local')->get('sitemap.xml');
        $response = Response::make($sitemap);
        $response->header('Content-Type', 'application/xml');
        return $response;
    }

    public function setSitemap()
    {
        Bot::setSitemap();
    }

    public function tempMethod()
    {

    }

    public function setExcludedIds()
    {
        $bot = Bot::where('temp', 'exclude')->first();

        $first = [];
        $playlists = $bot->data['playlists'];
        foreach ($playlists as $playlist_id) {
            array_push($first, Video::where('playlist_id', $playlist_id)->orderBy('created_at', 'desc')->first()->id);
        }

        $videos = Video::where(function($query) use ($playlists) {
            foreach ($playlists as $playlist) {
                $query->orWhere('playlist_id', $playlist);
            }
        })->whereNotIn('id', $first)->pluck('id');

        $bot->data = ['playlists' => $playlists, 'videos' => $videos];
        $bot->save();
    }
}
