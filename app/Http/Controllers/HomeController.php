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
        $count = 28;

        $upload = Video::whereOrderBy('uploaded_at', $count)->where('imgur', '!=', 'CJ5svNv')->get();
        $newest = Video::whereOrderBy('created_at', $count)->get();
        $trending = Video::whereOrderBy('views', $count)->get();

        $tag1 = Video::whereHasTags(['巨乳'], $count)->get();
        $tag2 = Video::whereHasTags(['貧乳'], $count)->get();
        $tag3 = Video::whereHasTags(['肛交'], $count)->get();
        $tag4 = Video::whereHasTags(['扶他', '偽娘', '耽美'], $count)->get();
        $tag5 = Video::whereHasTags([''], $count)->get();

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

        $country_code = isset($_SERVER["HTTP_CF_IPCOUNTRY"]) ? $_SERVER["HTTP_CF_IPCOUNTRY"] : 'N/A';

        return view('layouts.home', compact('banner', 'rows', 'country_code'));
    }

    public function search(Request $request)
    {
        $tags = [];
        $brands = [];
        $videos = Video::where('cover', '!=', null);
        
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
                $videos = $videos->orderBy('current_views', 'desc')->orderBy('id', 'desc');
                break;

            case '最新內容':
                $videos = $videos->orderBy('created_at', 'desc');
                break;

            case '最新上傳':
                $videos = $videos->orderBy('uploaded_at', 'desc');
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
        $saves = Save::with(['video' => function($query) {
            $query->where('cover', '!=', null)->select('id', 'title', 'cover');
        }])->where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

        return view('layouts.list', compact('saves'));
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
        return view('layouts.copyright-en');
    }

    public function p2257(Request $request)
    {
        return view('layouts.2257');
    }

    public function userReport(Request $request)
    {
        $ip_address = isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : 'N/A';
        $country_code = isset($_SERVER["HTTP_CF_IPCOUNTRY"]) ? $_SERVER["HTTP_CF_IPCOUNTRY"] : 'N/A';
        if ($ip_address == '106.38.121.194' || $ip_address == '223.104.65.11') {
            return 'error';
        } else {
            $request->validate([
                'userReportReason' => 'required'
            ]);
            $email = request('report-email') == null ? '' : request('report-email');
            $reason = request('userReportReason');
            if ($reason == '其他原因') {
                $reason = $reason.'：'.request('others-text');
            }
            Mail::to('laughseejapan@gmail.com')->send(new UserReport($email, $reason, request('video-id'), request('video-title'), request('video-sd'), $ip_address, $country_code));
            return Redirect::back()->withErrors('感謝您向我們提供意見或回報任何錯誤。');
        }
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
        $videos = Video::where('cover', '!=', null)->get();
        foreach ($videos as $video) {
            $views = $video->data['views']['total'];
            if ($views != null) {
                $video->views = end($views);
                $video->save();
            }
        }
    }
}
