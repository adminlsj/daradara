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

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $count = 21;

        $newest = Video::whereOrderBy('created_at', $count, true)->where('title', 'not like', '[新番預告]%')->where('tags', 'not like', '泡麵番%')->get();
       
        $upload = Video::with('user:id,name,avatar_temp')->where('imgur', '!=', 'WENZTSJ')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'genre', 'cover', 'imgur', 'views', 'tags_array', 'created_at', 'duration')->limit(10)->get()->split(5);

        $trending = Video::whereOrderBy('month_views', $count, true)->orderBy('id', 'desc')->get();

        $tags = [
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

        $cover = Video::orderBy('updated_at', 'desc')->select('id', 'title', 'cover')->where('uncover', false)->limit(50)->get()->shuffle()->slice(0, $count);

        $uncover = Video::with('user:id,name,avatar_temp')->orderBy('updated_at', 'desc')->select('id', 'user_id', 'title', 'genre', 'cover', 'imgur', 'views', 'tags_array', 'created_at', 'duration')->limit(10)->get();


        return view('layouts.home-new', compact('newest', 'upload', 'trending', 'tags', 'cover', 'uncover'));
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
            $results = User::has('videos');

            if ($query) {
                $results = $results->where('name', 'ilike', '%'.$query.'%');
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

            $results = $results->select('id', 'name', 'avatar_temp')->withCount('videos')->orderBy('videos_count', 'desc')->paginate(42);

        } else {
            $results = Video::query();

            if ($query) {
                $chinese = new Chinese();
                $original = '%'.$query.'%';
                $translated = '%'.$chinese->to(Chinese::ZH_HANT, $query).'%';
                $results = $results->where(function($query) use ($original, $translated) {
                    $query->where('title', 'ilike', $original)
                          ->orWhere('translations', 'ilike', $original)
                          ->orWhere('tags_array', 'ilike', $original)
                          ->orWhere('genre', 'ilike', $original)
                          ->orWhere('artist', 'ilike', $original)
                          ->orWhere('title', 'ilike', $translated)
                          ->orWhere('translations', 'ilike', $translated)
                          ->orWhere('tags_array', 'ilike', $translated)
                          ->orWhere('genre', 'ilike', $translated)
                          ->orWhere('artist', 'ilike', $translated);
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
