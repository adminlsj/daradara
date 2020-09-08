<?php

namespace App\Http\Controllers;

use App\Video;
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
use Mail;
use App\Mail\UserReport;
use App\Mail\UserUploadVideo;
use Redirect;
use Spatie\Browsershot\Browsershot;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $excluded = Video::getExcludedIds();

        $banner = Video::find(12872);
        $count = 20;
        $upload = Video::where('cover', '!=', null)->orderBy('id', 'desc')->limit($count)->get();
        $newest =Video::where('cover', '!=', null)->whereNotIn('id', $excluded)->orderBy('created_at', 'desc')->limit($count)->get();
        $trending = Video::where('cover', '!=', null)->whereNotIn('id', $excluded)->orderBy('views', 'desc')->limit($count)->get();
        $tag1 = Video::where('cover', '!=', null)->where('tags', 'ilike', '%巨乳%')->whereNotIn('id', $excluded)->inRandomOrder()->limit($count)->get();
        $tag2 = Video::where('cover', '!=', null)->where('tags', 'ilike', '%貧乳%')->whereNotIn('id', $excluded)->inRandomOrder()->limit($count)->get();
        $tag3 = Video::where('cover', '!=', null)->where('tags', 'ilike', '%肛交%')->whereNotIn('id', $excluded)->inRandomOrder()->limit($count)->get();
        $tag4 = Video::where(function($query) {
            $query->orWhere('tags', 'like', '%扶他%')->orWhere('tags', 'like', '%偽娘%')->orWhere('tags', 'like', '%耽美%');
        })->where('cover', '!=', null)->whereNotIn('id', $excluded)->inRandomOrder()->limit($count)->get();
        $tag5 = Video::where('cover', '!=', null)->whereNotIn('id', $excluded)->inRandomOrder()->limit($count)->get();

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
            $videos = $videos->whereNotIn('id', $excluded);
        }

        if ($tags = $request->tags) {
            //if ($request->broad) {
                $videos = $videos->where(function($query) use ($tags) {
                    foreach ($tags as $tag) {
                        $query->orWhere('tags', 'ilike', '%'.$tag.'%');
                    }
                });
            /* } else {
                $videos = $videos->where(function($query) use ($tags) {
                    foreach ($tags as $tag) {
                        $query->where('tags', 'ilike', '%'.$tag.'%');
                    }
                });
            } */
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

    public function sitemap()
    {
        $videos = Video::where('cover', '!=', null)->orderBy('created_at', 'desc')->get();
        $time = Carbon::now()->format('Y-m-d\Th:i:s').'+00:00';
        return Response::view('layouts.sitemap', compact('videos', 'time'))->header('Content-Type', 'application/xml');
    }

    public function tempMethod()
    {
        
    }
}
