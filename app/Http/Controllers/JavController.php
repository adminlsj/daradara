<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use Response;
use Redirect;
use Storage;
use Validator;
use App\Bot;
use App\Comment;
use App\User;
use App\Video;
use App\Watch;
use App\Reply;
use App\Save;
use App\Like;
use App\Playlist;
use App\Playitem;
use App\Mail\UserReport;
use App\Helper;
use App\Mail\UserAddedTags;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use SteelyWing\Chinese\Chinese;

class JavController extends Controller
{
    public function index(Request $request)
    {
        $dCount = 18;

        $最新JAV = Video::with('user:id,name')->where('genre', '日本AV')->orderBy('created_at', 'desc')->select('id', 'user_id', 'title', 'translations', 'caption', 'cover', 'imgur', 'views', 'duration', 'foreign_sd')->limit($dCount)->get();

        $random = $最新JAV->random();

        $最新上市 = Video::with('user:id,name')->whereIn('genre', ['日本AV', '素人業餘', '高清無碼', 'AI解碼', '國產AV', '國產素人'])->orderBy('created_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration')->limit($dCount)->get();

        $最新上傳 = Video::with('user:id,name')->whereIn('genre', ['日本AV', '素人業餘', '高清無碼', 'AI解碼', '國產AV', '國產素人'])->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration')->limit($dCount)->get();

        $中文字幕 = Video::with('user:id,name')->whereIn('genre', ['日本AV', '素人業餘', '高清無碼', 'AI解碼', '國產AV', '國產素人'])->where('tags_array', 'like', '%中文字幕%')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration')->limit($dCount)->get();

        $他們在看 = Video::with('user:id,name')->whereIn('genre', ['日本AV', '素人業餘', '高清無碼', 'AI解碼', '國產AV', '國產素人'])->orderBy('updated_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration')->limit($dCount)->get();

        $素人業餘 = Video::with('user:id,name')->where('genre', '素人業餘')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration')->limit($dCount)->get();

        $高清無碼 = Video::with('user:id,name')->where('genre', '高清無碼')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration')->limit($dCount)->get();

        $AI解碼 = Video::with('user:id,name')->where('genre', 'AI解碼')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration')->limit($dCount)->get();

        $國產AV = Video::with('user:id,name')->where('genre', '國產AV')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration')->limit($dCount)->get();

        $國產素人 = Video::with('user:id,name')->where('genre', '國產素人')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration')->limit($dCount)->get();

        $新加入作者 = User::has('videos')->where('email', 'like', '%jav%')->select('id', 'name', 'created_at', 'updated_at', 'avatar_temp')->withCount('videos')->orderBy('created_at', 'desc')->limit($dCount)->get();

        $本日排行 = Video::with('user:id,name')->whereIn('genre', ['日本AV', '素人業餘', '高清無碼', 'AI解碼', '國產AV', '國產素人'])->orderBy('current_views', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration')->limit($dCount)->get();

        $本月排行 = Video::with('user:id,name')->whereIn('genre', ['日本AV', '素人業餘', '高清無碼', 'AI解碼', '國產AV', '國產素人'])->orderBy('month_views', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration')->limit($dCount)->get();

        $觀看次數 = Video::with('user:id,name')->whereIn('genre', ['日本AV', '素人業餘', '高清無碼', 'AI解碼', '國產AV', '國產素人'])->orderBy('views', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration')->limit($dCount)->get();
       
        $影片標籤 = [
            [
                'title' => '絲襪美腿',
                'link' => route('jav.search').'?tags%5B%5D=黑絲&tags%5B%5D=過膝襪&tags%5B%5D=肉絲&tags%5B%5D=絲襪&tags%5B%5D=漁網&tags%5B%5D=吊帶襪&tags%5B%5D=美腿&broad=on',
                'imgur' => 'https://i.imgur.com/6Emw3bjl.jpg',
                'total' => '2903',
            ],
            [
                'title' => '多P群交',
                'link' => route('jav.search').'?tags%5B%5D=多P',
                'imgur' => 'https://i.imgur.com/qg9Iwf5l.jpg',
                'total' => '2722',
            ],
            [
                'title' => '人妻熟女',
                'link' => route('jav.search').'?tags%5B%5D=熟女&tags%5B%5D=人妻&broad=on',
                'imgur' => 'https://i.imgur.com/WjpM1FNl.jpg',
                'total' => '2428',
            ],
            [
                'title' => '主奴調教',
                'link' => route('jav.search').'?tags%5B%5D=調教&tags%5B%5D=綑綁&tags%5B%5D=刑具&broad=on',
                'imgur' => 'https://i.imgur.com/YfO8V3Nl.jpg',
                'total' => '2127',
            ],
            [
                'title' => '凌辱強暴',
                'link' => route('jav.search').'?tags%5B%5D=強姦&tags%5B%5D=凌辱&broad=on',
                'imgur' => 'https://i.imgur.com/8Jg4kmzl.jpg',
                'total' => '1875',
            ],
            [
                'title' => '貧乳女孩',
                'link' => route('jav.search').'?tags%5B%5D=貧乳&tags%5B%5D=蘿莉&broad=on',
                'imgur' => 'https://i.imgur.com/82P9Migl.jpg',
                'total' => '1526',
            ],
            [
                'title' => '制服誘惑',
                'link' => route('jav.search').'?tags%5B%5D=運動裝&tags%5B%5D=獸耳&tags%5B%5D=水着&tags%5B%5D=校服&tags%5B%5D=旗袍&tags%5B%5D=婚紗&tags%5B%5D=女僕&tags%5B%5D=和服&tags%5B%5D=兔女郎&tags%5B%5D=Cosplay&broad=on',
                'imgur' => 'https://i.imgur.com/6IEKhnpl.jpg',
                'total' => '1252',
            ],
            [
                'title' => '盜攝偷拍',
                'link' => route('jav.search').'?tags%5B%5D=偷拍',
                'imgur' => 'https://i.imgur.com/22HTJX7l.jpg',
                'total' => '1177',
            ],
            [
                'title' => '野外露出',
                'link' => route('jav.search').'?tags%5B%5D=露出',
                'imgur' => 'https://i.imgur.com/Ju9h8x1l.jpg',
                'total' => '899',
            ],
            [
                'title' => '女同歡愉',
                'link' => route('jav.search').'?tags%5B%5D=女同',
                'imgur' => 'https://i.imgur.com/c448FKKl.jpg',
                'total' => '511',
            ],
        ];

        $is_mobile = Helper::checkIsMobile();

        return view('jav.home', compact('最新JAV', 'random', '最新上市', '最新上傳', '中文字幕', '他們在看', '素人業餘', '高清無碼', 'AI解碼', '國產AV', '國產素人', '觀看次數', '本日排行', '本月排行', '影片標籤', '新加入作者', 'is_mobile'));
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
            $results = User::where('email', 'like', '%jav%');

            if ($query) {
                $results = $results->where('name', 'ilike', '%'.$query.'%');
            }

            switch ($genre) {
                case '全部':
                    $results = $results->has('videos');
                    break;

                case '日本AV':
                    $results = $results->whereHas('videos', function (Builder $query) {
                        $query->where('genre', '日本AV');
                    });
                    break;

                case '素人業餘':
                    $results = $results->whereHas('videos', function (Builder $query) {
                        $query->where('genre', '素人業餘');
                    });
                    break;

                case '高清無碼':
                    $results = $results->whereHas('videos', function (Builder $query) {
                        $query->where('genre', '高清無碼');
                    });
                    break;

                case 'AI解碼':
                    $results = $results->whereHas('videos', function (Builder $query) {
                        $query->where('genre', 'AI解碼');
                    });
                    break;

                case '國產AV':
                    $results = $results->whereHas('videos', function (Builder $query) {
                        $query->where('genre', '國產AV');
                    });
                    break;

                case '國產素人':
                    $results = $results->whereHas('videos', function (Builder $query) {
                        $query->where('genre', '國產素人');
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
            $results = Video::whereIn('genre', ['日本AV', '素人業餘', '高清無碼', 'AI解碼', '國產AV', '國產素人']);

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

                    case '日本AV':
                        $doujin = true;
                        $results = $results->where(function($query) {
                            $query->orWhere('genre', '日本AV');
                        });
                        break;

                    case '素人業餘':
                        $doujin = false;
                        $results = $results->where(function($query) {
                            $query->orWhere('genre', '素人業餘');
                        });
                        break;

                    case '高清無碼':
                        $results = $results->where(function($query) {
                            $query->orWhere('genre', '高清無碼');
                        });
                        break;

                    case 'AI解碼':
                        $results = $results->where(function($query) {
                            $query->orWhere('genre', 'AI解碼');
                        });
                        break;

                    case '國產AV':
                        $results = $results->where(function($query) {
                            $query->orWhere('genre', '國產AV');
                        });
                        break;

                    case '國產素人':
                        $results = $results->where(function($query) {
                            $query->orWhere('genre', '國產素人');
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

            $results = $results->with('user:id,name,avatar_temp')->distinct()->paginate(60);
        }

        $results->setPath('');

        return view('jav.search', compact('type', 'genre', 'tags', 'sort', 'brands', 'year', 'month', 'duration', 'results', 'doujin', 'is_mobile'));
    }

    public function watch(Request $request)
    {
        $vid = $request->v;

        if (is_numeric($vid) && $video = Video::with('watch:id,title')->select('id', 'user_id', 'playlist_id', 'comic_id', 'title', 'translations', 'caption', 'cover', 'genre', 'tags_array', 'sd', 'qualities', 'downloads', 'sd_sc', 'qualities_sc', 'downloads_sc', 'outsource', 'has_subtitles', 'current_views', 'week_views', 'month_views', 'views', 'imgur', 'foreign_sd', 'duration', 'has_torrent', 'artist', 'created_at', 'uploaded_at')->withCount('likes')->find($vid)) {

            if (in_array($video->genre, ['裏番', '泡麵番', 'Motion Anime', '3D動畫', '同人作品', 'Cosplay'])) {
                return Redirect::to(route('video.watch')."?v={$vid}");
            }

            $current = $video;
            $doujin = true;
            $user = auth()->user();
            $artist = User::select('id', 'name', 'avatar_temp')->withCount('videos')->find($video->user_id);
            $is_mobile = Helper::checkIsMobile();

            $video->current_views++;
            $video->week_views++;
            $video->month_views++;
            $video->views++;
            $video->save();

            $videos = Video::where('playlist_id', $video->playlist_id)->orderBy('created_at', 'desc')->select('id', 'user_id', 'cover', 'imgur', 'title', 'sd', 'views', 'duration', 'created_at')->get();

            $tags = $tags_random = array_keys($video->tags_array);
            shuffle($tags_random);
            $tags_slice = array_slice($tags_random, 0, 5);
            $genre = $video->genre;
            $related = Video::where('genre', $genre)->where(function($query) use ($tags_slice) {
                foreach ($tags_slice as $tag) {
                    $query->orWhere('tags_array', 'like', '%"'.$tag.'"%');
                }
            });

            $related = $related->with('user:id,name,avatar_temp')->where('id', '!=', $current->id)->inRandomOrder()->select('id', 'user_id', 'cover', 'imgur', 'title', 'sd', 'qualities', 'views', 'duration', 'created_at')->limit(60)->get();

            $country_code = isset($_SERVER["HTTP_CF_IPCOUNTRY"]) ? $_SERVER["HTTP_CF_IPCOUNTRY"] : 'N/A';

            $comments_count = Comment::where('foreign_id', $video->id)->where('type', 'video')->count();

            if (Auth::check()) {
                $saved = Save::where('user_id', $user->id)->where('video_id', $video->id)->exists();
                $listed = Playitem::where('user_id', $user->id)->where('video_id', $video->id)->get();
                $playlists = Playlist::where('user_id', $user->id)->where('reference_id', null)->select('id', 'user_id', 'title', 'created_at')->orderBy('created_at', 'desc')->get();
                $liked = Like::where('user_id', $user->id)->where('foreign_type', 'video')->where('foreign_id', $video->id)->exists();
            } else {
                $saved = false;
                $listed = '[]';
                $playlists = '[]';
                $liked = false;
            }

            $sd = $video->sd;
            $qualities = $video->qualities;
            $downloads = $video->downloads;

            if (strpos($sd, 'vbalancer') !== false) {
                $balancer = Helper::get_string_between($sd, 'vbalancer-', '.hembed');
                $server = Arr::random(Video::$vod_servers[$balancer - 1]);
                $sd = $this->getServerSd($balancer, $server, $sd);
                $qualities = $this->getServerQual($balancer, $server, $qualities);
            }
            $qual = $qualities != null ? Helper::getPreferredQuality(array_keys($qualities)) : 720;

        } else {
            abort(403);
        }

        return view('jav.watch', compact('video', 'artist', 'videos', 'current', 'tags', 'country_code', 'comments_count', 'related', 'doujin', 'is_mobile', 'saved', 'listed', 'playlists', 'liked', 'sd', 'qual', 'qualities', 'downloads'));
    }

}
