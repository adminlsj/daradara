<?php

namespace App\Http\Controllers;

use App\Video;
use App\Save;
use Illuminate\Http\Request;
use Response;
use Auth;
use Mail;
use App\Mail\UserReport;
use Redirect;
use Storage;
use App\Helper;
use SteelyWing\Chinese\Chinese;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $count = 28;

        $upload = Video::whereOrderBy('uploaded_at', $count, false)->where('imgur', '!=', 'WENZTSJ')->get();
        $newest = Video::whereOrderBy('created_at', $count, true)->where('title', 'not like', '[新番預告]%')->get();
        $trending = Video::whereOrderBy('views', $count, true)->get();

        $tag1 = Video::whereHasTags(['巨乳'], $count)->get();
        $tag2 = Video::whereHasTags(['貧乳'], $count)->get();
        $tag3 = Video::whereHasTags(['肛交'], $count)->get();
        $tag4 = Video::whereHasTags(['耽美'], $count)->get();
        $tag5 = Video::whereHasTags([], $count)->get();

        $rows = [
            '最新上傳' => ['videos' => $upload, 'link' => '/search?query=&genre=全部&sort=最新上傳'], 
            '最新內容' => ['videos' => $newest, 'link' => '/search?query=&genre=H動漫&sort=最新內容'],
            '發燒影片' => ['videos' => $trending, 'link' => '/search?query=&genre=H動漫&sort=觀看次數'], 
            '乳不巨何以聚人心' => ['videos' => $tag1, 'link' => '/search?query=&genre=H動漫&tags%5B%5D=巨乳&sort='], 
            '胸不平何以平天下' => ['videos' => $tag2, 'link' => '/search?query=&genre=H動漫&tags%5B%5D=貧乳&sort='], 
            '菊不爆何以保家園' => ['videos' => $tag3, 'link' => '/search?query=&genre=H動漫&tags%5B%5D=肛交&sort='], 
            '女不腐何以撫民心' => ['videos' => $tag4, 'link' => '/search?query=&genre=H動漫&broad=on&tags%5B%5D=扶他&tags%5B%5D=偽娘&tags%5B%5D=耽美'], 
            '更多精彩內容' => ['videos' => $tag5, 'link' => '/search']
        ];

        return view('layouts.home', compact('rows'));
    }

    public function search(Request $request)
    {
        $genre = '';
        $tags = [];
        $sort = '';
        $brands = [];
        $year = '';
        $month = '';
        $duration = '';
        $videos = Video::query();
        $doujin = true;
        $is_mobile = false;
        
        if ($query = request('query')) {
            $chinese = new Chinese();
            $original = '%'.$query.'%';
            $translated = '%'.$chinese->to(Chinese::ZH_HANT, $query).'%';
            $videos = $videos->where(function($query) use ($original, $translated) {
                $query->where('title', 'ilike', $original)
                      ->orWhere('translations', 'ilike', $original)
                      ->orWhere('tags_array', 'ilike', $original)
                      ->orWhere('title', 'ilike', $translated)
                      ->orWhere('translations', 'ilike', $translated)
                      ->orWhere('tags_array', 'ilike', $translated);
            });
        }

        if ($genre = $request->genre) {
            switch ($genre) {
                case '全部':
                    break;

                case 'H動漫':
                    $doujin = false;
                    break;

                case '3D動畫':
                    $videos = $videos->where(function($query) {
                        $query->orWhere('tags_array', 'ilike', '%"3D"%');
                    });
                    break;

                case '同人作品':
                    $videos = $videos->where(function($query) {
                        $query->orWhere('tags_array', 'ilike', '%"同人"%');
                    });
                    break;

                case 'Cosplay':
                    $videos = $videos->where(function($query) {
                        $query->orWhere('tags_array', 'ilike', '%"Cosplay"%');
                    });
                    break;
                
                default:
                    break;
            }
        }

        if ($duration = $request->duration) {
            if (strpos($duration, '短片') === 0) {
                $videos = $videos->where('duration', '<=', 240);

            } elseif (strpos($duration, '中長片') === 0) {
                $videos = $videos->where('duration', '>=', 240)->where('duration', '<=', 1200);

            } elseif (strpos($duration, '長片') === 0) {
                $videos = $videos->where('duration', '>=', 1200);
            }
        }

        if ($tags = $request->tags) {
            if ($request->broad) {
                $videos = $videos->where(function($query) use ($tags) {
                    foreach ($tags as $tag) {
                        $query->orWhere('tags_array', 'like', '%"'.$tag.'"%');
                    }
                });
            } else {
                foreach ($tags as $tag) {
                    $videos = $videos->where(function($query) use ($tag) {
                        $query->orWhere('tags_array', 'like', '%"'.$tag.'"%');
                    });
                }
            }
        }

        if ($brands = $request->brands) {
            $videos = $videos->where(function($query) use ($brands) {
                foreach ($brands as $brand) {
                    $query->orWhere('tags', 'like', '%'.$brand.'%');
                }
            });
        }

        if ($year = request('year')) {
            if ($month = request('month')) {
                $videos = $videos->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month);
            } else {
                $videos = $videos->whereYear('created_at', '=', $year);
            }
        }

        if ($sort = $request->sort) {
            switch ($sort) {
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
        } else {
            $videos = $videos->orderBy('created_at', 'desc');
        }

        if (is_null($tags) || !in_array('新番預告', $tags)) {
            $videos = $videos->where('title', 'not like', '[新番預告]%');
        }

        if (!$doujin) {
            $videos = $videos->where('cover', '!=', null)->where('cover', '!=', 'https://i.imgur.com/E6mSQA2.png')->where('cover', '!=', 'https://cdn.jsdelivr.net/gh/guaishushukanlifan/Project-H@latest/asset/cover/E6mSQA2.jpg')->distinct()->paginate(42);
        } else {
            $videos = $videos->with('user:id,name,avatar_temp')->where('cover', '!=', null)->distinct()->paginate(60);
            $is_mobile = Helper::checkIsMobile();
        }

        $videos->setPath('');
        
        return view('layouts.search-new', compact('genre', 'tags', 'sort', 'brands', 'year', 'month', 'duration', 'videos', 'doujin', 'is_mobile'));
    }

    public function list()
    {
        if (Auth::check()) {
            $saves = Save::with(['video' => function($query) {
                $query->where('cover', '!=', null)->select('id', 'title', 'cover', 'imgur');
            }])->where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(42);
            return view('layouts.list', compact('saves'));

        } else {
            return redirect('/login');
        }
    }

    public function about(Request $request)
    {
        return view('layouts.about-us');
    }

    public function contact()
    {
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
        return view('layouts.copyright-en');
    }

    public function p2257(Request $request)
    {
        return view('layouts.2257');
    }

    public function userReport(Request $request)
    {
        $device = '';
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if (Helper::checkIsMobile()) {
            if (strpos($user_agent, "Android") !== FALSE) {
                $device = 'Android';
            } elseif (strpos($user_agent, "iPhone") !== FALSE) {
                $device = 'iPhone';
            } elseif (strpos($user_agent, "webOS") !== FALSE) {
                $device = 'webOS';
            } else {
                $device = 'Mobile';
            }
        } else {
            if (strpos($user_agent, "Win") !== FALSE) {
                $device = 'Windows';
            } elseif (strpos($user_agent, "Mac") !== FALSE) {
                $device = 'Mac';
            } elseif (strpos($user_agent, "iPad") !== FALSE) {
                $device = 'iPad';
            } else {
                $device = 'Desktop';
            }
        }
        $device = ' ('.$device.')';

        $ip_address = isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : 'N/A';
        $country_code = isset($_SERVER["HTTP_CF_IPCOUNTRY"]) ? $_SERVER["HTTP_CF_IPCOUNTRY"] : 'N/A';
        if ($ip_address == '106.38.121.194' || $ip_address == '223.104.65.11' || $ip_address == '3.137.219.177' || $ip_address == '3.23.208.80' || $ip_address == '103.73.91.6' || $ip_address == '211.72.89.26' || $ip_address == 'N/A') {
            abort(403);
        } else {
            $request->validate([
                'userReportReason' => 'required'
            ]);
            $email = request('report-email') == null ? '' : request('report-email');
            $reason = request('userReportReason');
            if ($reason == '其他原因') {
                $reason = $reason.'：'.request('others-text');
            }
            Mail::to('vicky.avionteam@gmail.com')->send(new UserReport($email, $reason, request('video-id'), request('video-title'), request('video-sd'), $ip_address, $country_code.$device));

            if (request('video-title') == 'User Verification') {
                return Redirect::back()->withErrors('我們已收到您的申請，並會在近日內透過您的電郵地址聯繫您。');
            } else {
                return Redirect::back()->withErrors('感謝您向我們提供意見或回報任何錯誤。');
            }
        }
    }
}
