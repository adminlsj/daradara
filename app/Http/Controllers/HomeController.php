<?php

namespace App\Http\Controllers;

use App\User;
use App\Video;
use App\Save;
use App\Like;
use App\Playlist;
use App\Playitem;
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

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $count = 24;

        $最新裏番 = Video::where('genre', '裏番')->orWhere(function($query) {
                            $query->where('genre', '泡麵番')->where('foreign_sd', 'like', '%"bangumi"%');
                        })->orderBy('created_at', 'desc')->select('id', 'title', 'translations', 'caption', 'cover', 'imgur')->limit($count)->get();

        $random = $最新裏番->random();

        $最新上市 = Video::with('user:id,name')->where('genre', '!=', '新番預告')->orderBy('created_at', 'desc')->select('id', 'user_id', 'title', 'imgur', 'views', 'duration')->limit($count)->get();

        $最新上傳 = Video::with('user:id,name')->where('genre', '!=', '新番預告')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'imgur', 'views', 'duration')->limit($count)->get();

        $中文字幕 = Video::with('user:id,name')->where('translations', 'like', '%中文字幕%')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'imgur', 'views', 'duration')->limit($count)->get();

        $他們在看 = Video::with('user:id,name')->orderBy('updated_at', 'desc')->select('id', 'user_id', 'title', 'imgur', 'views', 'duration')->limit($count)->get();

        $泡麵番 = Video::where('genre', '泡麵番')->where('foreign_sd', 'like', '%"bangumi"%')->orderBy('uploaded_at', 'desc')->select('id', 'title', 'cover')->limit($count)->get();

        $Motion_Anime = Video::with('user:id,name')->where('genre', 'Motion Anime')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'imgur', 'views', 'duration')->limit($count)->get();

        $SD動畫 = Video::with('user:id,name')->where('genre', '3D動畫')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'imgur', 'views', 'duration')->limit($count)->get();

        $同人作品 = Video::with('user:id,name')->where('genre', '同人作品')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'imgur', 'views', 'duration')->limit($count)->get();

        $Cosplay = Video::with('user:id,name')->where('genre', 'Cosplay')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'imgur', 'views', 'duration')->limit($count)->get();

        $新番預告 = Video::with('user:id,name')->where('genre', '新番預告')->orderBy('created_at', 'desc')->select('id', 'title', 'cover')->limit($count)->get();

        $本日排行 = Video::with('user:id,name')->orderBy('current_views', 'desc')->select('id', 'user_id', 'title', 'imgur', 'views', 'duration')->limit($count)->get();

        $本月排行 = Video::with('user:id,name')->orderBy('month_views', 'desc')->select('id', 'user_id', 'title', 'imgur', 'views', 'duration')->limit($count)->get();
       
        $影片標籤 = [
            [
                'title' => '女高中生',
                'link' => '/search?query=&genre=&tags%5B%5D=JK&sort=&year=&month=&duration=',
                'imgur' => 'https://cdn.jsdelivr.net/gh/damedesho/damedesho-h@latest/asset/thumbnail/DT2P6mGl.jpg',
                'total' => '1,263',
            ],
            [
                'title' => '純愛最高',
                'link' => '/search?query=&genre=&tags%5B%5D=純愛&sort=&year=&month=&duration=',
                'imgur' => 'https://cdn.jsdelivr.net/gh/biexiangzou/biexiangzou-h@latest/asset/thumbnail/sjlurZWl.jpg',
                'total' => '607',
            ],
            [
                'title' => '人妻熟女',
                'link' => '/search?query=&genre=&broad=on&tags%5B%5D=熟女&tags%5B%5D=人妻&sort=&year=&month=&duration=',
                'imgur' => 'https://cdn.jsdelivr.net/gh/guaishushukanlifan/Project-H@latest/asset/thumbnail/vlLlj9Jl.jpg',
                'total' => '428',
            ],
            [
                'title' => '近親相姦',
                'link' => '/search?query=&genre=&broad=on&tags%5B%5D=近親&sort=&year=&month=&duration=',
                'imgur' => 'https://cdn.jsdelivr.net/gh/guaishushukanlifan/Project-H@latest/asset/thumbnail/aH3xcyhl.jpg',
                'total' => '527',
            ],
            [
                'title' => '貧乳女孩',
                'link' => '/search?query=&genre=&broad=on&tags%5B%5D=貧乳&sort=&year=&month=&duration=',
                'imgur' => 'https://cdn.jsdelivr.net/gh/guaishushukanlifan/Project-H@latest/asset/thumbnail/4BzQHJal.jpg',
                'total' => '526',
            ],
            [
                'title' => '強姦凌辱',
                'link' => '/search?query=&genre=&broad=on&tags%5B%5D=強制&sort=&year=&month=&duration=',
                'imgur' => 'https://cdn.jsdelivr.net/gh/damedesho/damedesho-h@latest/asset/thumbnail/p0JqE1cl.jpg',
                'total' => '875',
            ],
            [
                'title' => '異族風情',
                'link' => '/search?query=&genre=&broad=on&tags%5B%5D=異種族&sort=&year=&month=&duration=',
                'imgur' => 'https://cdn.jsdelivr.net/gh/damedesho/damedesho-h@latest/asset/thumbnail/xr2YJIMl.jpg',
                'total' => '252',
            ],
            [
                'title' => '耽美偽娘',
                'link' => '/search?query=&genre=&broad=on&tags%5B%5D=偽娘&tags%5B%5D=耽美&sort=&year=&month=&duration=',
                'imgur' => 'https://cdn.jsdelivr.net/gh/biexiangzou/biexiangzou-h@latest/asset/thumbnail/gQOhqs4l.jpg',
                'total' => '177',
            ],
            [
                'title' => '獵奇驚悚',
                'link' => '/search?query=&genre=&broad=on&tags%5B%5D=獵奇&sort=&year=&month=&duration=',
                'imgur' => 'https://cdn.jsdelivr.net/gh/furansutsukai/furansutsukai-h@latest/asset/thumbnail/5RWX8f3l.jpg',
                'total' => '99',
            ],
            [
                'title' => '無碼解放',
                'link' => '/search?query=&genre=&broad=on&tags%5B%5D=無碼&sort=&year=&month=&duration=',
                'imgur' => 'https://cdn.jsdelivr.net/gh/kangkaeroo/kangkaeroo-h@latest/asset/thumbnail/7U8j2Vel.jpg',
                'total' => '811',
            ],
        ];

        $新加入作者 = User::has('videos')->select('id', 'name', 'created_at', 'updated_at', 'avatar_temp')->withCount('videos')->orderBy('videos_count', 'desc')->limit($count)->get();

        return view('layouts.home', compact('最新裏番', 'random', '最新上市', '最新上傳', '中文字幕', '他們在看', '泡麵番', 'Motion_Anime', 'SD動畫', '同人作品', 'Cosplay', '新番預告', '本日排行', '本月排行', '影片標籤', '新加入作者'));
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
            $results = Video::query();

            if ($query) {
                $query = mb_strtolower(preg_replace('/\s+/', '', $query), 'UTF-8');
                $chinese = new Chinese();
                $original = '%'.$query.'%';
                $translated = '%'.$chinese->to(Chinese::ZH_HANT, $query).'%';
                $results = $results->where(function($query) use ($original, $translated) {
                    $query->where('searchtext', 'like', $original)
                          ->orWhere('searchtext', 'like', $translated);
                });
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

            if (!$query || strpos($query, '新番') === false) {
                $results = $results->where('title', 'not like', '[新番預告]%');
            }

            if (!$doujin) {
                $results = $results->distinct()->paginate(42);
            } else {
                $results = $results->with('user:id,name,avatar_temp')->distinct()->paginate(60);
            }

            $results->setPath('');
        }

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
