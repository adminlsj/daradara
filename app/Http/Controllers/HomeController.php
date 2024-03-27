<?php

namespace App\Http\Controllers;

use App\User;
use App\Video;
use App\Save;
use App\Like;
use App\Subscribe;
use App\Playlist;
use App\Playitem;
use App\Bot;
use Illuminate\Http\Request;
use Response;
use Auth;
use Mail;
use App\Mail\UserReport;
use Redirect;
use Storage;
use App\Helper;
use SteelyWing\Chinese\Chinese;
use Illuminate\Database\Eloquent\Builder;
use App\Video_temp;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $hCount = 16;
        $dCountFirst = 18;
        $dCount = 12;

        $variables = Video_temp::with('user:id,name')->where('route', '/')->get();

        $最新裏番 = $variables->where('name', '最新裏番')->sortByDesc('created_at');
        /* $最新裏番 = Video::where('genre', '裏番')->orWhere(function($query) {
                            $query->where('genre', '泡麵番')->where('foreign_sd', 'like', '%"bangumi"%');
                        })->orderBy('created_at', 'desc')->select('id', 'title', 'translations', 'caption', 'cover', 'imgur')->limit($hCount)->get(); */

        $random = $最新裏番->random();

        $最新上市 = $variables->where('name', '最新上市')->sortByDesc('created_at');
        /* $最新上市 = Video::with('user:id,name')->whereIn('genre', Video::$genre)->orderBy('created_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration')->limit($dCountFirst)->get(); */

        $最新上傳 = $variables->where('name', '最新上傳')->sortByDesc('uploaded_at');
        /* $最新上傳 = Video::with('user:id,name')->whereIn('genre', Video::$genre)->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration')->limit($dCountFirst)->get(); */

        $中文字幕 = $variables->where('name', '中文字幕')->sortByDesc('uploaded_at');
        /* $中文字幕 = Video::with('user:id,name')->whereIn('genre', ['Motion Anime', '3D動畫', '同人作品', 'Cosplay'])->where('tags_array', 'like', '%中文字幕%')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration')->limit($dCount)->get(); */

        $他們在看 = $variables->where('name', '他們在看')->sortByDesc('updated_at');
        /* $他們在看 = Video::with('user:id,name')->whereIn('genre', Video::$genre)->orderBy('updated_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration')->limit($dCount)->get(); */

        $泡麵番 = $variables->where('name', '泡麵番')->sortByDesc('uploaded_at');
        /* $泡麵番 = Video::where('genre', '泡麵番')->where('foreign_sd', 'like', '%"bangumi"%')->orderBy('uploaded_at', 'desc')->select('id', 'title', 'cover')->limit($hCount)->get(); */

        $Motion_Anime = $variables->where('name', 'Motion_Anime')->sortByDesc('uploaded_at');
        /* $Motion_Anime = Video::with('user:id,name')->where('genre', 'Motion Anime')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration')->limit($dCount)->get(); */

        $SD動畫 = $variables->where('name', 'SD動畫')->sortByDesc('uploaded_at');
        /* $SD動畫 = Video::with('user:id,name')->where('genre', '3D動畫')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration')->limit($dCount)->get(); */

        $同人作品 = $variables->where('name', '同人作品')->sortByDesc('uploaded_at');
        /* $同人作品 = Video::with('user:id,name')->where('genre', '同人作品')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration')->limit($dCount)->get(); */

        $Cosplay = $variables->where('name', 'Cosplay')->sortByDesc('uploaded_at');
        /* $Cosplay = Video::with('user:id,name')->where('genre', 'Cosplay')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration')->limit($dCount)->get(); */

        $新番預告 = $variables->where('name', '新番預告')->sortByDesc('created_at');
        /* $新番預告 = Video::where('genre', '新番預告')->orderBy('created_at', 'desc')->select('id', 'title', 'cover')->limit($hCount)->get(); */

        $新加入作者 = User::whereIn('id', $variables->where('name', '新加入作者')->first()->translations)->select('id', 'name', 'created_at', 'updated_at', 'avatar_temp')->withCount('videos')->orderBy('created_at', 'desc')->get();
        /* $新加入作者 = User::has('videos')->select('id', 'name', 'created_at', 'updated_at', 'avatar_temp')->withCount('videos')->orderBy('created_at', 'desc')->limit($hCount)->get(); */

        $本日排行 = $variables->where('name', '本日排行')->sortByDesc('current_views');
        /* $本日排行 = Video::with('user:id,name')->whereIn('genre', Video::$genre)->orderBy('current_views', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration')->limit($dCount)->get(); */

        $本月排行 = $variables->where('name', '本月排行')->sortByDesc('month_views');
        /* $本月排行 = Video::with('user:id,name')->whereIn('genre', Video::$genre)->orderBy('month_views', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration')->limit($dCount)->get(); */
       
        $影片標籤 = [
            [
                'title' => '女高中生',
                'link' => '/search?query=&genre=&tags%5B%5D=JK&sort=&year=&month=&duration=',
                'imgur' => 'https://img4.qy0.ru/data/2197/80/DT2P6mGl.jpg',
                'total' => '1,263',
            ],
            [
                'title' => '純愛最高',
                'link' => '/search?query=&genre=&tags%5B%5D=純愛&sort=&year=&month=&duration=',
                'imgur' => 'https://img4.qy0.ru/data/2197/80/sjlurZWl.jpg',
                'total' => '607',
            ],
            [
                'title' => '人妻熟女',
                'link' => '/search?query=&genre=&broad=on&tags%5B%5D=熟女&tags%5B%5D=人妻&sort=&year=&month=&duration=',
                'imgur' => 'https://img4.qy0.ru/data/2197/80/vlLlj9Jl.jpg',
                'total' => '428',
            ],
            [
                'title' => '近親相姦',
                'link' => '/search?query=&genre=&broad=on&tags%5B%5D=近親&sort=&year=&month=&duration=',
                'imgur' => 'https://img4.qy0.ru/data/2197/80/aH3xcyhl.jpg',
                'total' => '527',
            ],
            [
                'title' => '貧乳女孩',
                'link' => '/search?query=&genre=&broad=on&tags%5B%5D=貧乳&sort=&year=&month=&duration=',
                'imgur' => 'https://img4.qy0.ru/data/2197/80/4BzQHJal.jpg',
                'total' => '526',
            ],
            [
                'title' => '強姦凌辱',
                'link' => '/search?query=&genre=&broad=on&tags%5B%5D=強制&sort=&year=&month=&duration=',
                'imgur' => 'https://img4.qy0.ru/data/2197/80/p0JqE1cl.jpg',
                'total' => '875',
            ],
            [
                'title' => '異族風情',
                'link' => '/search?query=&genre=&broad=on&tags%5B%5D=異種族&sort=&year=&month=&duration=',
                'imgur' => 'https://img4.qy0.ru/data/2197/80/xr2YJIMl.jpg',
                'total' => '252',
            ],
            [
                'title' => '耽美偽娘',
                'link' => '/search?query=&genre=&broad=on&tags%5B%5D=偽娘&tags%5B%5D=耽美&sort=&year=&month=&duration=',
                'imgur' => 'https://img4.qy0.ru/data/2197/80/gQOhqs4l.jpg',
                'total' => '177',
            ],
            [
                'title' => '獵奇驚悚',
                'link' => '/search?query=&genre=&broad=on&tags%5B%5D=獵奇&sort=&year=&month=&duration=',
                'imgur' => 'https://img4.qy0.ru/data/2197/80/5RWX8f3l.jpg',
                'total' => '99',
            ],
            [
                'title' => '無碼解放',
                'link' => '/search?query=&genre=&broad=on&tags%5B%5D=無碼&sort=&year=&month=&duration=',
                'imgur' => 'https://img4.qy0.ru/data/2197/80/7U8j2Vel.jpg',
                'total' => '811',
            ],
        ];

        $is_mobile = Helper::checkIsMobile();

        return view('layouts.home', compact('最新裏番', 'random', '最新上市', '最新上傳', '中文字幕', '他們在看', '泡麵番', 'Motion_Anime', 'SD動畫', '同人作品', 'Cosplay', '新番預告', '本日排行', '本月排行', '影片標籤', '新加入作者', 'is_mobile'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'max:255',
        ]);

        $type = request('type');
        $query = request('query');
        $genre = request('genre');
        $tags = [];
        $sort = request('sort');
        $brands = [];
        $year = '';
        $month = '';
        $duration = '';
        $doujin = true;
        $is_mobile = Helper::checkIsMobile();

        if ($type == 'artist') {
            $results = User::query();

            if ($query) {
                $results = $results->where('name', 'ilike', '%'.$query.'%');
            }

            switch ($genre) {
                case '全部':
                    $results = $results->has('videos');
                    break;

                case '裏番':
                    $results = $results->whereHas('videos', function (Builder $query) {
                        $query->where('genre', '裏番');
                    });
                    break;

                case '泡麵番':
                    $results = $results->whereHas('videos', function (Builder $query) {
                        $query->where('genre', '泡麵番');
                    });
                    break;

                case 'Motion Anime':
                    $results = $results->whereHas('videos', function (Builder $query) {
                        $query->where('genre', 'Motion Anime');
                    });
                    break;

                case '3D動畫':
                    $results = $results->whereHas('videos', function (Builder $query) {
                        $query->where('genre', '3D動畫');
                    });
                    break;

                case '同人作品':
                    $results = $results->whereHas('videos', function (Builder $query) {
                        $query->where('genre', '同人作品');
                    });
                    break;

                case 'Cosplay':
                    $results = $results->whereHas('videos', function (Builder $query) {
                        $query->where('genre', 'Cosplay');
                    });
                    break;
                
                default:
                    $results = $results->has('videos');
                    break;
            }

            switch ($sort) {
                case '字母順序':
                    $results = $results->orderBy('name', 'asc');
                    break;

                case '影片數量':
                    break;

                case '加入日期':
                    $results = $results->orderBy('created_at', 'desc');
                    break;

                case '更新日期':
                    $results = $results->orderBy('updated_at', 'desc');
                    break;

                default:
                    break;
            }

            $results = $results->select('id', 'name', 'created_at', 'updated_at', 'avatar_temp')->withCount('videos')->orderBy('videos_count', 'desc')->paginate(42);

        } else {
            $results = Video::whereIn('genre', Video::$genre);

            if ($query) {
                if ($query == '訂閱內容' && Auth::check()) {
                    $subscribes = Subscribe::where('user_id', Auth::user()->id)->pluck('artist_id');
                    $results = $results->whereIn('user_id', $subscribes);
                } else {
                    $query = mb_strtolower(preg_replace('/\s+/', '', $query), 'UTF-8');
                    $chinese = new Chinese();
                    $original = '%'.$query.'%';
                    $translated = '%'.$chinese->to(Chinese::ZH_HANT, $query).'%';
                    $results = $results->where(function($query) use ($original, $translated) {
                        $query->where('searchtext', 'like', $original)
                              ->orWhere('searchtext', 'like', $translated);
                    });
                }
            }

            if ($genre) {
                switch ($genre) {
                    case '全部':
                        break;

                    case '裏番':
                        $doujin = false;
                        $results = $results->where(function($query) {
                            $query->orWhere('genre', '裏番');
                        });
                        break;

                    case '泡麵番':
                        $doujin = false;
                        $results = $results->where(function($query) {
                            $query->orWhere('genre', '泡麵番')->where('foreign_sd', 'like', '%"bangumi"%');
                        });
                        break;

                    case 'Motion Anime':
                        $results = $results->where(function($query) {
                            $query->orWhere('genre', 'Motion Anime');
                        });
                        break;

                    case '3D動畫':
                        $results = $results->where(function($query) {
                            $query->orWhere('genre', '3D動畫');
                        });
                        break;

                    case '同人作品':
                        $results = $results->where(function($query) {
                            $query->orWhere('genre', '同人作品');
                        });
                        break;

                    case 'Cosplay':
                        $results = $results->where(function($query) {
                            $query->orWhere('genre', 'Cosplay');
                        });
                        break;
                    
                    default:
                        break;
                }
            }

            if ($tags = $request->tags) {
                if ($request->broad) {
                    $results = $results->where(function($query) use ($tags) {
                        foreach ($tags as $tag) {
                            $query->orWhere('tags_array', 'like', '%"'.$tag.'"%');
                        }
                    });
                } else {
                    foreach ($tags as $tag) {
                        $results = $results->where(function($query) use ($tag) {
                            $query->orWhere('tags_array', 'like', '%"'.$tag.'"%');
                        });
                    }
                }
            }

            if ($year = request('year')) {
                if ($month = request('month')) {
                    $results = $results->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month);
                } else {
                    $results = $results->whereYear('created_at', '=', $year);
                }
            }

            switch ($sort) {
                case '最新上市':
                    $results = $results->orderBy('created_at', 'desc');
                    break;

                case '最新上傳':
                    $results = $results->orderBy('uploaded_at', 'desc');
                    break;

                case '本日排行':
                    $results = $results->orderBy('current_views', 'desc')->orderBy('id', 'desc');
                    break;

                case '本週排行':
                    $results = $results->orderBy('week_views', 'desc')->orderBy('id', 'desc');
                    break;

                case '本月排行':
                    $results = $results->orderBy('month_views', 'desc')->orderBy('id', 'desc');
                    break;

                case '觀看次數':
                    $results = $results->orderBy('views', 'desc');
                    break;

                case '他們在看':
                    $results = $results->orderBy('updated_at', 'desc');
                    break;

                default:
                    $results = $results->orderBy('created_at', 'desc');
                    break;
            }

            /* if (!$query || strpos($query, '新番') === false) {
                $results = $results->where('title', 'not like', '[新番預告]%');
            } */

            if (!$doujin) {
                $results = $results->distinct()->paginate(42);
            } else {
                $results = $results->with('user:id,name,avatar_temp')->distinct()->paginate(60);
            }
        }

        $results->setPath('');

        return view('layouts.search-new', compact('type', 'genre', 'tags', 'sort', 'brands', 'year', 'month', 'duration', 'results', 'doujin', 'is_mobile'));
    }

    public function list()
    {
        if (Auth::check()) {

            $user = Auth::user();

            $saves = Save::with(['video' => function($query) {
                $query->where('cover', '!=', null)->select('id', 'title', 'cover', 'imgur');
            }])->where('user_id', $user->id)->orderBy('created_at', 'desc')->limit(21)->get();

            $likes = Like::where('user_id', $user->id)->where('foreign_type', 'video')->orderBy('created_at', 'desc')->limit(21)->get()->load(['video' => function ($query) {
                $query->where('cover', '!=', null)->select('id', 'title', 'cover', 'imgur');
            }]);

            $playlists = Playlist::withCount('videos', 'videos_ref')->with([
                'videos' => function($query) {
                    $query->select('videos.id', 'cover', 'imgur')->orderBy('playitems.created_at', 'desc')->limit(1);;
                },
                'videos_ref' => function($query) {
                    $query->select('videos.id', 'cover', 'imgur')->orderBy('playitems.created_at', 'desc')->limit(1);;
                },
                'user' => function($query) {
                    $query->select('users.id', 'name');
                },
                'user_ref' => function($query) {
                    $query->select('users.id', 'name');
                }
            ])->where('user_id', $user->id)->orderBy('created_at', 'desc')->limit(200)->get();

            return view('layouts.list', compact('user', 'saves', 'likes', 'playlists'));


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
        $banned_ip = ['N/A', '185.220.100.255', '185.100.85.22'];
        if (in_array($ip_address, $banned_ip)) {
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
            if (strpos($reason, 'GET FREE iPhone') !== false || strpos($reason, 'Withdrаw') !== false || strpos($reason, 'telegra.ph') !== false) {
                abort(403);
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
