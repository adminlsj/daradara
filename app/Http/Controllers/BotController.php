<?php

namespace App\Http\Controllers;

use App\User;
use App\Anime;
use App\AnimeTemp;
use App\AnimeRole;
use App\AnimeRelation;
use App\Episode;
use App\Character;
use App\Actor;
use App\ActorAnimeCharacter;
use App\Company;
use App\Staff;
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
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;
use GuzzleHttp\Client;

class BotController extends Controller
{
    public function scrapeBangumi(Request $request)
    {
        $animes = Anime::where('id', '>=', 25425)->orderBy('id', 'asc')->get();
        foreach ($animes as $anime) {
            $url = $anime->sources['bangumi'];
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);
            sleep(1);

            if (strpos($html, '<h2>呜咕，出错了</h2>') === false) {
                $title_zhs = null;
                if (strpos($html, '<li class=""><span class="tip">中文名: </span>') !== false) {
                    $title_zhs = trim(Helper::get_string_between($html, '<li class=""><span class="tip">中文名: </span>', '</li>'));
                }

                $title_jp = null;
                if (strpos($html, 'property="v:itemreviewed">') !== false) {
                    $title_jp = trim(Helper::get_string_between($html, 'property="v:itemreviewed">', '</a>'));
                }

                $photo_cover = null;
                if (strpos($html, 'class="thickbox cover"><img src="') !== false) {
                    $photo_cover = 'https:'.trim(Helper::get_string_between($html, 'class="thickbox cover"><img src="', '"'));
                }

                $description = null;
                if (strpos($html, 'property="v:summary">') !== false) {
                    $description = trim(Helper::get_string_between($html, 'property="v:summary">', '</div>'));
                }

                $started_at = null;
                $started_at_show = null;
                if (strpos($html, '<li class=""><span class="tip">放送开始: </span>') !== false) {
                    $started_at = trim(Helper::get_string_between($html, '<li class=""><span class="tip">放送开始: </span>', '</li>'));
                    $started_at = str_replace('(中国大陆)', '', $started_at);
                    $started_at = str_replace('（法国）', '', $started_at);
                    $started_at = str_replace('(英国)', '', $started_at);
                    $started_at = str_replace('(美国)', '', $started_at);
                    $started_at = str_replace('(荷兰)', '', $started_at);
                    $started_at = str_replace('（英国）', '', $started_at);
                    $started_at = str_replace('（苏联）', '', $started_at);
                    $started_at = str_replace(' (Netflix)', '', $started_at);
                    $started_at = str_replace(' (U.S)', '', $started_at);
                    $started_at = str_replace('(加拿大)', '', $started_at);
                    $started_at = str_replace('（电视初公开）', '', $started_at);
                    $started_at = str_replace('夏', '', $started_at);
                    $started_at = str_replace('春', '', $started_at);
                    $started_at = str_replace('冬', '', $started_at);
                    $started_at = str_replace('号', '日', $started_at);
                    $started_at = str_replace(' ', '', $started_at);
                    $started_at = str_replace('(PV)', '', $started_at);
                    $started_at = str_replace('(韩国)', '', $started_at);
                    $started_at = str_replace('未定档', '', $started_at);
                    $started_at = str_replace('Q3', '', $started_at);
                    $started_at = str_replace('Q4', '', $started_at);
                    $started_at = str_replace('未定', '', $started_at);
                    $started_at = str_replace('未知', '', $started_at);
                    $started_at = str_replace('(预告片)', '', $started_at);
                    $started_at = str_replace('H2', '', $started_at);
                    $started_at = str_replace('*', '', $started_at);
                    if ($started_at == '' || $started_at == 'TBA') {
                        $started_at = null;
                    } elseif (strpos($started_at, '-') !== false) {
                        $started_at = Carbon::createFromFormat('Y-m-d H:i:s', $started_at.' 00:00:00', 'UTC');
                    } elseif (strpos($started_at, '.') !== false) {
                        $started_at = Carbon::createFromFormat('Y.m.d H:i:s', $started_at.' 00:00:00', 'UTC');
                    } elseif (strpos($started_at, '/') !== false) {
                        $started_at = Carbon::createFromFormat('Y/m/d H:i:s', $started_at.' 00:00:00', 'UTC');
                    } else {
                        if (strpos($started_at, '日') !== false) {
                            $started_at = Carbon::createFromFormat('Y年m月d日 H:i:s', $started_at.' 00:00:00', 'UTC');
                        } elseif (strpos($started_at, '月') !== false) {
                            $started_at = Carbon::createFromFormat('Y年m月d日 H:i:s', $started_at.'1日 00:00:00', 'UTC');
                            $started_at_show = 'Month';
                        } elseif (strpos($started_at, '年') !== false) {
                            $started_at = Carbon::createFromFormat('Y年m月d日 H:i:s', $started_at.'1月1日 00:00:00', 'UTC');
                            $started_at_show = 'Year';
                        } else {
                            $started_at = Carbon::createFromFormat('Y年m月d日 H:i:s', $started_at.'年1月1日 00:00:00', 'UTC');
                            $started_at_show = 'Year';
                        }
                    }
                }

                $ended_at = null;
                if (strpos($html, '<li class=""><span class="tip">播放结束: </span>') !== false) {
                    $ended_at = trim(Helper::get_string_between($html, '<li class=""><span class="tip">播放结束: </span>', '</li>'));
                    $ended_at = str_replace('(英国)', '', $ended_at);
                    $ended_at = str_replace(' (U.S)', '', $ended_at);
                    $ended_at = str_replace('（英国）', '', $ended_at);
                    $ended_at = str_replace('（U-NEXT）2023年9月19日（TV）', '', $ended_at);
                    $ended_at = str_replace('（网络配信）2023年12月17日（TV）', '', $ended_at);
                    $ended_at = str_replace(' / 2021年6月27日（超前点播）', '', $ended_at);
                    $ended_at = str_replace('未定档', '', $ended_at);
                    $ended_at = str_replace('（日本）', '', $ended_at);
                    $ended_at = str_replace('休止中', '', $ended_at);
                    $ended_at = str_replace('你', '年', $ended_at);
                    $ended_at = str_replace('优酷、bilibili', '', $ended_at);
                    $ended_at = str_replace('*', '', $ended_at);
                    if ($ended_at == '' || $ended_at == 'TBA') {
                        $ended_at = null;
                    } elseif (strpos($ended_at, '-') !== false) {
                        $ended_at = Carbon::createFromFormat('Y-m-d H:i:s', $ended_at.' 00:00:00', 'UTC');
                    } else {
                        if (strpos($ended_at, '日') !== false) {
                            $ended_at = Carbon::createFromFormat('Y年m月d日 H:i:s', $ended_at.' 00:00:00', 'UTC');
                        } elseif (strpos($ended_at, '月') !== false) {
                            $ended_at = Carbon::createFromFormat('Y年m月d日 H:i:s', $ended_at.'1日 00:00:00', 'UTC');
                            $started_at_show = 'Month';
                        } elseif (strpos($ended_at, '年') !== false) {
                            $ended_at = Carbon::createFromFormat('Y年m月d日 H:i:s', $ended_at.'1月1日 00:00:00', 'UTC');
                            $started_at_show = 'Year';
                        } else {
                            $ended_at = Carbon::createFromFormat('Y年m月d日 H:i:s', $ended_at.'年1月1日 00:00:00', 'UTC');
                            $started_at_show = 'Year';
                        }
                    }
                }

                $source = null;
                if (strpos($html, '<span>原创</span>') !== false) {
                    $source = 'Original';
                } elseif (strpos($html, '<span>漫画改</span>') !== false) {
                    $source = 'Manga';
                } elseif (strpos($html, '<span>游戏改</span>') !== false) {
                    $source = 'Game';
                } elseif (strpos($html, '<span>小说改</span>') !== false) {
                    $source = 'Novel';
                }

                $rating_bangumi = trim(Helper::get_string_between($html, 'property="v:average">', '</span>'));
                $rating_bangumi_count = trim(Helper::get_string_between($html, 'property="v:votes">', '</span>'));

                $anime->title_zhs = $title_zhs;
                $anime->title_jp = $title_jp;
                $anime->photo_cover = $photo_cover;
                $anime->description = $description;
                $anime->started_at = $started_at;
                $anime->started_at_show = $started_at_show;
                $anime->ended_at = $ended_at;
                $anime->source = $source;
                $anime->rating_bangumi = $rating_bangumi*10;
                $anime->rating_bangumi_count = $rating_bangumi_count;
                $anime->save();

            } else {
                $anime->delete();
            }
        }
    }

    public function scrapeBangumiList(Request $request)
    {
        $category = 'Others';
        $pages = 173;
        for ($i = 1; $i <= $pages; $i++) {
            $url = "https://bangumi.tv/anime/browser/misc/?sort=title&page={$i}";
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);
            sleep(1);

            $list_raw = trim(Helper::get_string_between($html, '<ul id="browserItemList" class="browserFull">', '</ul>'));
            $list_raw_array = explode('<div class="inner">', $list_raw);
            array_shift($list_raw_array);
            foreach ($list_raw_array as $item) {
                $url = trim(Helper::get_string_between($item, '<a href="', '"'));
                // if (!Anime::where('sources', 'ilike', '%"'.$url.'"%')->exists()) {
                    $anime = Anime::create([
                        'category' => $category,
                        'sources' => ["bangumi" => "https://bangumi.tv{$url}"]
                    ]);
                // }
            }
        }
    }

    public function scrapeBangumiEpisodes(Request $request)
    {
        $animes = Anime::where('sources', 'ilike', '%"bangumi"%')->where('id', '>=', $request->from)->where('id', '<=', $request->to)->orderBy('id', 'asc')->get();
        foreach ($animes as $anime) {
            $url = "{$anime->sources["bangumi"]}/ep";
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);
            sleep(1);

            if (strpos($html, '<div class="mainWrapper"><div class="columns clearit">') !== false) {
                if (strpos($html, '<span class="epAirStatus"') !== false) {
                    $episodes_raw_array = explode('<span class="epAirStatus"', $html);
                    array_shift($episodes_raw_array);
                    foreach ($episodes_raw_array as $episodes_raw) {
                        $episode_link = trim(Helper::get_string_between($episodes_raw, '<a href="', '"'));
                        $title_jp = trim(Helper::get_string_between($episodes_raw, '<a href="'.$episode_link.'">', '</a>'));
                        $title_jp = str_replace('   ', ' ', $title_jp);
                        if ($episode = Episode::where('anime_id', $anime->id)->where('title_jp', $title_jp)->first()) {
                            echo "Bangumi Anime#{$anime->id} episode {$episode->title_jp} exists<br>";
                        
                        } else {
                            $title_zhs = null;
                            if (strpos($episodes_raw, '<span class="tip"> / ') !== false) {
                                $title_zhs = trim(Helper::get_string_between($episodes_raw, '<span class="tip"> / ', '</span>'));
                            }
                            $duration = null;
                            if (strpos($episodes_raw, '时长:') !== false) {
                                if (strpos($episodes_raw, ' /') !== false) {
                                    $duration = trim(Helper::get_string_between($episodes_raw, '<small class="grey">时长:', ' /'));
                                } else {
                                    return "Bangumi Anime#{$anime->id} episode has duration but not date<br>";
                                }
                            }
                            $released_at = null;
                            if (strpos($episodes_raw, '首播:') !== false) {
                                $released_at = trim(Helper::get_string_between($episodes_raw, '首播:', '</small>')).' 00:00:00';
                                $released_at_array = explode('-', $released_at);
                                if (count($released_at_array) != 3) {
                                    $released_at = null;
                                } else {
                                    $released_at_array[1] = trim($released_at_array[1]);
                                    if (strlen($released_at_array[1]) == 1) {
                                        $released_at_array[1] = '0'.$released_at_array[1];
                                    }
                                    $released_at = implode('-', $released_at_array);
                                    if ($anime->id == 37399 && strpos($released_at, '23-05-09') !== false) {
                                        $released_at = str_replace('23-05-09', '2023-05-09', $released_at);
                                    }
                                }
                            }

                            $episode = Episode::create([
                                'anime_id' => $anime->id,
                                'episodes_thumbnail' => $duration,
                                'title_jp' => $title_jp,
                                'title_zhs' => $title_zhs,
                                'released_at' => $released_at
                            ]);

                            echo "Bangumi Anime#{$anime->id} episode {$episode->title_jp} created<br>";
                        }
                    }
                } else {
                    echo "Bangumi Anime#{$anime->id} has no episodes<br>";
                }
            } else {
                return "Bangumi Anime#{$anime->id} not found<br>";
            }
        }
    }

    public function scrapeBangumiStaffList(Request $request)
    {
        $type = $request->type;
        $from = $request->from;
        $to = $request->to;
        for ($i = $from; $i <= $to; $i++) {
            $url = "https://bangumi.tv/person?orderby=collects&type={$type}&page={$i}";
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);
            sleep(1);

            if (strpos($html, '<div class="browserCrtList">') !== false && strpos($html, '<div id="multipage" class="clearit">') !== false) {
                $list_raw = trim(Helper::get_string_between($html, '<div class="browserCrtList">', '<div id="multipage" class="clearit">'));
                $list_raw_array = explode('<div class="rr">', $list_raw);
                array_shift($list_raw_array);
                foreach ($list_raw_array as $item) {
                    $url = "https://bangumi.tv".trim(Helper::get_string_between($item, '<a href="', '"'));
                    $name = trim(Helper::get_string_between($item, 'class="l">', '<'));
                    if ($staff = Staff::where('name_jp', $name)->where('sources', 'not like', '%"bangumi"%')->first()) {
                        $temp = $staff->sources;
                        $temp['bangumi'] = $url;
                        $staff->sources = $temp;
                        $staff->save();
                    } else {
                        echo "Bangumi staff name {$name} not found or exists<br>";
                    }
                }
            } else {
                return "Bangumi staff page {$i} access failed<br>";
            }
            echo "Bangumi staff page {$i} scraped<br>";
        }
    }

    public function scrapeBangumiStaff(Request $request)
    {
        $staffs = Staff::where('sources', 'like', '%'."bangumi".'%')->where('id', '>=', $request->from)->where('id', '<=', $request->to)->orderBy('id', 'asc')->get();
        foreach ($staffs as $staff) {
            $url = $staff->sources['bangumi'];
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);
            sleep(1);

            if (strpos($html, '<h1 class="nameSingle">') !== false) {
                if (strpos($html, '<span class="tip">简体中文名: </span>') !== false) {
                    $name_zhs = trim(Helper::get_string_between($html, '<span class="tip">简体中文名: </span>', '</li>'));
                    $staff->name_zhs = $name_zhs;
                }

                if (strpos($html, '<span class="tip">性别: </span>') !== false) {
                    $gender = trim(Helper::get_string_between($html, '<span class="tip">性别: </span>', '</li>'));
                    $staff->gender = $gender;
                }

                if (strpos($html, '<span class="tip">生日: </span>') !== false) {
                    $birthday = trim(Helper::get_string_between($html, '<span class="tip">生日: </span>', '</li>'));
                    $staff->name_zht = $birthday;
                }

                if (strpos($html, '<span class="tip">血型: </span>') !== false) {
                    $blood_type = trim(Helper::get_string_between($html, '<span class="tip">血型: </span>', '</li>'));
                    $staff->blood_type = $blood_type;
                }

                if (strpos($html, '<span class="tip">身高: </span>') !== false) {
                    $height = trim(Helper::get_string_between($html, '<span class="tip">身高: </span>', '</li>'));
                    $height = str_replace('cm', '', $height);
                    $height = str_replace('CM', '', $height);
                    $height = str_replace('厘米', '', $height);
                    $height = str_replace('㎝', '', $height);
                    $height = str_replace('公分', '', $height);
                    $staff->height = $height;
                }

                if (strpos($html, '<span class="tip">出生地: </span>') !== false) {
                    $hometown = trim(Helper::get_string_between($html, '<span class="tip">出生地: </span>', '</li>'));
                    $staff->hometown = $hometown;
                }

                if (strpos($html, '<div class="detail">') !== false) {
                    $description = trim(Helper::get_string_between($html, '<div class="detail">', '</div>'));
                    $staff->description = $description;
                }

                $staff->save();

                echo "Bangumi staff id #{$staff->id} scraped<br>";

            } else {
                return "Bangumi staff id #{$staff->id} access failed<br>";
            }
        }
    }

    public function scrapeMalAnimes(Request $request)
    {
        // from 59091
        $from = $request->from;
        $to = $request->to;
        for ($i = $from; $i <= $to; $i++) {
            if (!Anime::where('sources', 'ilike', '%'.'"https://myanimelist.net/anime/'.$i.'/"'.'%')->exists()) {
                $url = "https://myanimelist.net/anime/{$i}/";
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);
                sleep(1);

                if (strpos($html, '404 Not Found') === false) {
                    $title_en = trim(Helper::get_string_between($html, '<span class="dark_text">English:</span>', '<'));
                    $title_jp = trim(Helper::get_string_between($html, '<span class="dark_text">Japanese:</span>', '<'));
                    $title_ro = trim(Helper::get_string_between($html, '<strong>', '</strong>'));
                    $photo_cover = trim(Helper::get_string_between($html, '<meta property="og:image" content="', '"'));
                    $description = trim(Helper::get_string_between($html, '<meta property="og:description" content="', '"'));
                    $rating_mal = Helper::get_string_between($html, 'score-label score-', '/span>');
                    $rating_mal = Helper::get_string_between($rating_mal, '>', '<');
                    if ($rating_mal == 'N/A') {
                        $rating_mal = 0.00;
                    }
                    $category = trim(Helper::get_string_between($html, '<span class="dark_text">Type:</span>', '</div>'));
                    $episodes = trim(Helper::get_string_between($html, '<span class="dark_text">Episodes:</span>', '<'));
                    $airing_status = trim(Helper::get_string_between($html, '<span class="dark_text">Status:</span>', '<'));
                    if (strpos($category, "<a href=") !== false) {
                        $category = Helper::get_string_between($category, '>', '<');
                    }
                    if ($episodes == 'Unknown') {
                        $episodes = null;
                    }
                    $aired = trim(Helper::get_string_between($html, '<span class="dark_text">Aired:</span>', '</div>'));
                    $animation_studio = trim(Helper::get_string_between($html, '<span class="dark_text">Studios:</span>', '/a>'));
                    $animation_studio = Helper::get_string_between($animation_studio, '>', '<');
                    $trailer = 'None';
                    if (strpos($html, 'https://www.youtube.com/embed/') !== false) {
                        $trailer = trim(Helper::get_string_between($html, '<a class="iframe js-fancybox-video video-unit promotion" href="', '&autoplay=1"'));
                    }
                    $sources = ["myanimelist" => $url];
                    $array = [];
                    $anime = Anime::create([
                        'title_jp' => $title_jp,
                        'title_en' => $title_en,
                        'title_ro' => $title_ro,
                        'photo_cover' => $photo_cover,
                        'description' => $description,
                        'rating_mal' => $rating_mal,
                        'category' => $category,
                        'airing_status' => $airing_status,
                        'episodes' => $episodes,
                        'animation_studio' => $animation_studio,
                        'trailer' => $trailer,
                        'sources' => $sources,
                        'photo_banner' => $aired,
                        'genres' => $array,
                        'tags' => $array,
                    ]);
                } else {
                    echo "MAL anime#{$i} not found<br>";
                }
            }
        }
    }

    public function scrapeMalRelatedAnimes(Request $request)
    {
        $animes = Anime::where('id', '>=', $request->from)->where('id', '<=', $request->to)->orderBy('id', 'asc')->get();
        foreach ($animes as $anime) {
            $url = $anime->sources['myanimelist'];
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);
            sleep(1);

            if (strpos($html, '404 Not Found') === false) {
                if (strpos($html, '<div class="h1-title">') !== false) {

                    if (strpos($html, 'Related Entries') !== false) {
                        $main = explode('<div class="content">', $html);
                        array_shift($main);
                        foreach ($main as $item) {
                            $relation = trim(Helper::get_string_between($item, '<div class="relation">', '</div>'));
                            $relation = trim(preg_replace('/\s\s+/', ' ', $relation));
                            $related = trim(Helper::get_string_between($item, '<div class="title">', '</div>'));

                            if (strpos($related, 'https://myanimelist.net/anime/') !== false) {

                                $related = trim(Helper::get_string_between($related, 'https://myanimelist.net/anime/', '/'));

                                if ($related_anime = Anime::where('sources', 'ilike', "%\https://myanimelist.net/anime/{$related}/%")->first()) {
                                    if (!AnimeRelation::where('anime_id', $anime->id)->where('animeable_id', $related_anime->id)->where('animeable_type', 'App\Anime')->exists()) {

                                        AnimeRelation::create([
                                            'anime_id' => $anime->id,
                                            'animeable_id' => $related_anime->id,
                                            'animeable_type' => 'App\Anime',
                                            'relation' => $relation,
                                        ]);

                                    } else {
                                        echo "INFO: Relation {$relation} exists<br>";
                                    }

                                } else {
                                    return "INFO: Related anime not found https://myanimelist.net/anime/{$related}/<br>";
                                }

                            } else {
                                echo "INFO: Relation {$relation} not anime<br>";
                            }
                        }

                        $others = explode('<td valign="top" class="ar fw-n borderClass', $html);
                        array_shift($others);
                        foreach ($others as $item) {
                            $relation = trim(Helper::get_string_between($item, 'nowrap">', ':'));
                            $list = trim(Helper::get_string_between($item, '<ul class="entries">', '</ul>'));
                            $list = explode('<a href="', $list);
                            array_shift($list);
                            foreach ($list as $entry) {
                                if (strpos($entry, 'https://myanimelist.net/anime/') !== false) {

                                    $related = trim(Helper::get_string_between($entry, 'https://myanimelist.net/anime/', '/'));

                                    if ($related_anime = Anime::where('sources', 'ilike', "%\https://myanimelist.net/anime/{$related}/%")->first()) {
                                        if (!AnimeRelation::where('anime_id', $anime->id)->where('animeable_id', $related_anime->id)->where('animeable_type', 'App\Anime')->exists()) {

                                            AnimeRelation::create([
                                                'anime_id' => $anime->id,
                                                'animeable_id' => $related_anime->id,
                                                'animeable_type' => 'App\Anime',
                                                'relation' => $relation,
                                            ]);

                                        } else {
                                            echo "INFO: Relation {$relation} exists<br>";
                                        }

                                    } else {
                                        return "INFO: Related anime not found https://myanimelist.net/anime/{$related}/<br>";
                                    }

                                } else {
                                    echo "INFO: Relation {$relation} not anime<br>";
                                }
                            }
                        }

                    } else {
                        echo "INFO: Anime#{$anime->id} has no relations<br>";
                    }

                } else {
                    return "Anime#{$anime->id} access failed</span><br>";
                }

            } else {
                return "Anime#{$anime->id} not found</span><br>";
            }

            echo "INFO: Anime#{$anime->id} relations scraped<br>";
        }
    }

    public function scrapeMalEpisodes(Request $request)
    {
        $animes = Anime::where('sources', 'ilike', '%"myanimelist"%')->where('id', '>=', $request->from)->where('id', '<=', $request->to)->orderBy('id', 'asc')->get();
        foreach ($animes as $anime) {
            $url = $anime->sources['myanimelist'].'x/episode';
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);
            sleep(1);

            if (strpos($html, '404 Not Found') === false) {
                if (strpos($html, '<div class="h1-title">') !== false) {
                    if (strpos($html, 'No episode information has been added to this title.') === false) {
                        $episodes_list = explode('<td class="episode-number nowrap" ', $html);
                        array_shift($episodes_list);
                        foreach ($episodes_list as $episode_list) {
                            $episode_number = trim(Helper::get_string_between($episode_list, 'data-raw="', '"'));
                            $title_jp = trim(Helper::get_string_between($episode_list, '&nbsp;(', ')'));
                            $released_at = trim(Helper::get_string_between($episode_list, '<td class="episode-aired nowrap">', '</td>'));
                            if ($released_at != 'N/A') {
                                $released_at = Carbon::createFromFormat('M d, Y H:i:s', $released_at.' 00:00:00');
                            } else {
                                $released_at = null;
                            }
                            if ($episode = Episode::where('anime_id', $anime->id)->where('title_jp', 'ilike', "{$episode_number}.%")->first()) {
                                $title_array = explode('.', $episode->title_jp);
                                if ($title_array[1] == '') {
                                    $episode->title_jp = $episode_number.'.'.$title_jp;
                                }
                                if ($released_at != null) {
                                    $episode->released_at = $released_at;
                                }
                                $episode->save();
                                echo "MAL Anime#{$anime->id} episode {$episode->title_jp} updated<br>";

                            } else {
                                $episode = Episode::create([
                                    'anime_id' => $anime->id,
                                    'title_jp' => $episode_number.'.'.$title_jp,
                                    'released_at' => $released_at
                                ]);
                                echo "MAL Anime#{$anime->id} episode {$episode->title_jp} created<br>";
                            }
                        }

                    } else {
                        echo "INFO: Anime#{$anime->id} has no episodes<br>";
                    }
                } else {
                    return "Anime#{$anime->id} access failed</span><br>";
                }

            } else {
                echo "INFO: Anime#{$anime->id} has no episodes<br>";
            }
        }
    }

    public function importBangumiAnimeSource(Request $request)
    {
        $anime = Anime::where('sources', 'ilike', '%"bangumi"%')->where('rating_bangumi', null)->first();

        $url = $anime->sources['bangumi'];
        $curl_connection = curl_init($url);
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
        $html = curl_exec($curl_connection);
        curl_close($curl_connection);

        $title_zhs = null;
        if (strpos($html, '<li class=""><span class="tip">中文名: </span>') !== false) {
            $title_zhs = trim(Helper::get_string_between($html, '<li class=""><span class="tip">中文名: </span>', '</li>'));
        }

        $description = null;
        if (strpos($html, 'property="v:summary">') !== false) {
            $description = trim(Helper::get_string_between($html, 'property="v:summary">', '</div>'));
        }

        $rating_bangumi = trim(Helper::get_string_between($html, 'property="v:average">', '</span>'));
        $rating_bangumi_count = trim(Helper::get_string_between($html, 'property="v:votes">', '</span>'));

        $anime->title_zhs = $title_zhs;
        if ($description != null) {
            $anime->description = $description;
        }
        $anime->rating_bangumi = $rating_bangumi*10;
        $anime->rating_bangumi_count = $rating_bangumi_count;
        $anime->save();
    }

    public function scrapeMalCompanies(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        for ($i = $from; $i <= $to; $i++) {
            $url = "https://myanimelist.net/anime/producer/{$i}";
            if (!Company::where('sources', 'like', '%'.$url.'%')->exists()) {
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);
                sleep(1);

                if (strpos($html, '404 Not Found') === false) {
                    if (strpos($html, '<h1 class="title-name">') !== false) {
                        $photo_cover = Helper::get_string_between($html, '<meta property="og:image" content="', '"');
                        $name_en = Helper::get_string_between($html, '<h1 class="title-name">', '</h1>');
                        $name_jp = null;
                        $started_at = null;
                        $description = null;
                        $website = null;
                        if (strpos($html, '<span class="dark_text">Japanese:</span>') !== false) {
                            $name_jp = trim(Helper::get_string_between($html, '<span class="dark_text">Japanese:</span>', '</div>'));
                        }
                        if (strpos($html, '<span class="dark_text">Established:</span>') !== false) {
                            $started_at = trim(Helper::get_string_between($html, '<span class="dark_text">Established:</span>', '</div>'));
                        }
                        if (strpos($html, '<h2>Available At</h2>') !== false) {
                            $description = trim(Helper::get_string_between($html, '<div class="spaceit_pad">', '<h2>Available At</h2>'));
                            $description = trim(Helper::get_string_between($description, '<span>', '</span>'));
                            $website = trim(Helper::get_string_between($html, 'rel="noreferrer">', '</a>'));
                        }
                        Company::create([
                            'photo_cover' => $photo_cover,
                            'name_en' => $name_en,
                            'name_jp' => $name_jp,
                            'description' => $description,
                            'website' => $website,
                            'location' => $started_at,
                            'sources' => ['myanimelist' => $url],
                        ]);

                    } else {
                        echo "<span style='color:red'>WARNING: Company#{$i} access failed</span><br>";
                    }
                } else {
                    echo "INFO: Company#{$i} not found<br>";
                }
            } else {
                echo "INFO: Company#{$i} exists<br>";
            }
        }
    }

    public function scrapeMalCompaniesAnimeables(Request $request)
    {
        $companies = Company::where('id', '>=', $request->from)->where('id', '<=', $request->to)->orderBy('id', 'asc')->get();
        foreach ($companies as $company) {
            $url = $company->sources['myanimelist'];
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);
            sleep(1);

            if (strpos($html, $company->photo_cover) !== false) {
                $total = Helper::get_string_between($html, '<li class="js-btn-anime-type" data-key="all">All (', ')');
                $animes_raw_array = explode('<div class="js-anime-category-', $html);
                array_shift($animes_raw_array);
                if ($total != count($animes_raw_array)) {
                    return "Company ID#{$company->id} total mismatch";
                }
                foreach ($animes_raw_array as $animes_raw) {
                    $url = "https://myanimelist.net/anime/".Helper::get_string_between($animes_raw, 'https://myanimelist.net/anime/', '/')."/";
                    $role = Helper::get_string_between($animes_raw, '<div class="category">', '</div>');
                    if ($anime = Anime::where('sources', 'ilike', '%"'.$url.'"%')->first()) {
                        if (!Animeable::where('anime_id', $anime->id)->where('animeable_id', $company->id)->where('animeable_type', 'App\Company')->where('role', $role)->exists()) {
                            Animeable::create([
                                'anime_id' => $anime->id,
                                'animeable_id' => $company->id,
                                'animeable_type' => 'App\Company',
                                'role' => $role,
                            ]);
                        }
                    } else {
                        echo "Anime URL@{$url} not found<br>";
                        // return "Anime URL@{$url} not found";
                    }
                }
            } else {
                return "Company ID#{$company->id} access failed";
            }
        }
    }

    public function scrapeMalAnimeCompanies(Request $request)
    {
        $animes = Anime::where('id', '>=', $request->from)->where('id', '<=', $request->to)->orderBy('id', 'asc')->get();
        foreach ($animes as $anime) {
            $url = $anime->sources['myanimelist'];
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);
            sleep(1);

            if (strpos($html, '404 Not Found') === false) {
                if (strpos($html, '<h1 class="title-name h1_bold_none"><strong>') !== false) {

                    $mal_producer_ids = [];
                    while (strpos($html, '/anime/producer/') !== false) {
                        $id = Helper::get_string_between($html, '/anime/producer/', '/');
                        array_push($mal_producer_ids, $id);
                        $html = str_replace('/anime/producer/'.$id.'/', '', $html);
                    }

                    $companies_list = $anime->companies->pluck('sources')->pluck('myanimelist')->toArray();
                    foreach ($mal_producer_ids as $mal_producer_id) {
                        if (!in_array("https://myanimelist.net/anime/producer/".$mal_producer_id, $companies_list)) {
                            echo "Anime ID#{$anime->id} producer not scraped: <a href='https://myanimelist.net/anime/producer/{$mal_producer_id}' target='_blank'>https://myanimelist.net/anime/producer/{$mal_producer_id}</a><br>";
                        }
                    }

                } else {
                    echo "<span style='color:red'>WARNING: Anime#{$anime->id} access failed</span><br>";
                }

            } else {
                echo "INFO: Anime#{$anime->id} not found<br>";
            }
        }
    }

    public function scrapeMalStaffs(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        for ($i = $from; $i <= $to; $i++) {
            $url = "https://myanimelist.net/people/{$i}/";
            if (!Staff::where('sources', 'like', '%'.$url.'%')->exists()) {
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);
                sleep(1);

                if (strpos($html, '404 Not Found') === false) {
                    if (strpos($html, '<h1 class="title-name h1_bold_none"><strong>') !== false) {
                        $photo_cover = Helper::get_string_between($html, '<meta property="og:image" content="', '"');
                        $name_en = Helper::get_string_between($html, '<h1 class="title-name h1_bold_none"><strong>', '</strong></h1>');
                        $name_jp = null;
                        if (strpos($html, 'Given name:') !== false && strpos($html, 'Family name:') !== false) {
                            $given_name = Helper::get_string_between($html, 'span class="dark_text">Given name:</span> ', '</div>');
                            $family_name = Helper::get_string_between($html, 'span class="dark_text">Family name:</span> ', '<div class="spaceit_pad">');
                            $name_jp = "{$family_name}{$given_name}";
                        }
                        Staff::create([
                            'photo_cover' => $photo_cover,
                            'name_en' => $name_en,
                            'name_jp' => $name_jp,
                            'sources' => ['myanimelist' => $url],
                        ]);

                    } else {
                        echo "<span style='color:red'>WARNING: Staff#{$i} access failed</span><br>";
                    }
                } else {
                    echo "INFO: Staff#{$i} not found<br>";
                }
            } else {
                echo "INFO: Staff#{$i} exists<br>";
            }
        }
    }

    public function scrapeMalStaffRoles(Request $request)
    {
        $staffs = Staff::where('id', '>=', $request->from)->where('id', '<=', $request->to)->orderBy('id', 'asc')->get();
        foreach ($staffs as $staff) {
            $curl_connection = curl_init($staff->sources['myanimelist']);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);
            sleep(1);

            if (strpos($html, '404 Not Found') === false) {
                if (strpos($html, '<h1 class="title-name h1_bold_none"><strong>') !== false) {
                    if (strpos($html, 'No staff positions have been added to this person.') === false) {
                        $roles_html = Helper::get_string_between($html, '<table border="0" cellpadding="0" cellspacing="0" width="100%" class="js-table-people-staff"', '</table>');
                        $roles_html_array = explode('<tr class="js-people-staff js-anime-watch-status-people-staff-notinmylist">', $roles_html);
                        array_shift($roles_html_array);
                        foreach ($roles_html_array as $role_html) {
                            $anime_url = 'https://myanimelist.net/anime/'.Helper::get_string_between($role_html, '<a href="https://myanimelist.net/anime/', '/').'/';
                            $role = htmlspecialchars(trim(Helper::get_string_between($role_html, '<small>', '</small>')));
                            if ($anime = Anime::where('sources', 'ilike', '%"'.$anime_url.'"%')->first()) {
                                if (!AnimeRole::where('anime_id', $anime->id)->where('animeable_id', $staff->id)->where('animeable_type', 'App\Staff')->where('role', $role)->exists()) {
                                    AnimeRole::create([
                                        'anime_id' => $anime->id,
                                        'animeable_id' => $staff->id,
                                        'animeable_type' => 'App\Staff',
                                        'role' => $role,
                                    ]);
                                }
                            } else {
                                return "Anime not found: <a href='{$anime_url}' target='_blank'>{$anime_url}</a><br>";
                            }
                        }

                    } else {
                        echo "INFO: Staff#{$staff->id} has no anime staff positions<br>";
                    }
                } else {
                    echo "<span style='color:red'>WARNING: Staff#{$staff->id} access failed</span><br>";
                }
            } else {
                echo "INFO: Staff#{$staff->id} not found<br>";
            }
        }
    }

    public function checkBangumiCompanies(Request $request)
    {
        $url = "https://bangumi.tv/person?orderby=collects&type=3&page={$request->page}";
        $curl_connection = curl_init($url);
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
        $html = curl_exec($curl_connection);
        curl_close($curl_connection);
        sleep(1);

        $producers_list_raw = Helper::get_string_between($html, '<div class="browserCrtList">', '<div id="multipage" class="clearit">');
        $producers_list = explode('class="light_odd  clearit">', $producers_list_raw);
        array_shift($producers_list);
        $producers = [];
        foreach ($producers_list as $item) {
            $link = "https://bangumi.tv".Helper::get_string_between($item, '<a href="', '"');
            $name = trim(Helper::get_string_between($item, 'class="l">', '</a>'));
            $producers[$name] = $link;
        }
        foreach ($producers as $name => $link) {
            $company = Company::where('sources', 'not like', '%"bangumi"%')->where(function($query) use ($name) {
                $query->where('name_jp', 'ilike', '%'.$name.'%')->orWhere('name_en', 'ilike', '%'.$name.'%');
            })->first();
            if ($company) {
                echo "<span style='color:green'>WARNING: Company#{$company->id} {$company->name_jp} / {$company->name_en} = {$name}</span><br>";
            } else {
                echo "<span style='color:black'>INFO: No company matches</span><br>";
            }
        }
    }

    public function mergeBangumiCompanies(Request $request)
    {
        $url = "https://bangumi.tv/person?orderby=collects&type=3&page={$request->page}";
        $curl_connection = curl_init($url);
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
        $html = curl_exec($curl_connection);
        curl_close($curl_connection);
        sleep(1);

        $producers_list_raw = Helper::get_string_between($html, '<div class="browserCrtList">', '<div id="multipage" class="clearit">');
        $producers_list = explode('class="light_odd  clearit">', $producers_list_raw);
        array_shift($producers_list);
        $producers = [];
        foreach ($producers_list as $item) {
            $link = "https://bangumi.tv".Helper::get_string_between($item, '<a href="', '"');
            $name = trim(Helper::get_string_between($item, 'class="l">', '</a>'));
            $producers[$name] = $link;
        }
        foreach ($producers as $name => $link) {
            $company = Company::where('sources', 'not like', '%"bangumi"%')->where(function($query) use ($name) {
                $query->where('name_jp', 'ilike', '%'.$name.'%')->orWhere('name_en', 'ilike', '%'.$name.'%');
            })->first();
            if ($company) {
                $temp = $company->sources;
                $temp["bangumi"] = $link;
                $company->sources = $temp;
                $company->save();
            }
        }
    }

    public function importBangumiCompanies(Request $request)
    {
        $companies = Company::where('sources', 'ilike', '%"bangumi"%')->get();
        foreach ($companies as $company) {
            $curl_connection = curl_init($company->sources['bangumi']);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);
            sleep(1);

            if (strpos($html, '<span class="tip">简体中文名: </span>') !== false) {
                $name_zhs = Helper::get_string_between($html, '<span class="tip">简体中文名: </span>', '</li>');
                $company->name_zhs = $name_zhs;
            }
            if (strpos($html, '<span class="tip">成立时间: </span>') !== false && $company->location == null) {
                $location = Helper::get_string_between($html, '<span class="tip">成立时间: </span>', '</li>');
                $company->location = $location;
            }
            if (strpos($html, '<div class="detail">') !== false) {
                $description = Helper::get_string_between($html, '<div class="detail">', '</div>');
                $company->description = $description;
            }
            if (strpos($html, '<span class="tip">官网: </span>') !== false && $company->website == null) {
                $website = Helper::get_string_between($html, '<span class="tip">官网: </span>', '</li>');
                $company->website = $website;
            }

            $company->save();
        }
    }

    public function checkBangumiAnimesLinkable(Request $request)
    {
        $anime_temps = AnimeTemp::where('started_at', '!=', null)->orderBy('id', 'asc')->skip($request->skip)->limit($request->limit)->get();
        foreach ($anime_temps as $anime_temp) {
            if (strpos($anime_temp->title_jp, ' ') !== false) {
                $bangumi_title_jp = explode(' ', $anime_temp->title_jp)[0];
            } else {
                $bangumi_title_jp = $anime_temp->title_jp;
            }
            $bangumi_title_jp = str_replace('?', '', $bangumi_title_jp);
            $bangumi_title_jp = str_replace('？', '', $bangumi_title_jp);
            $bangumi_title_jp = str_replace('!', '', $bangumi_title_jp);
            $bangumi_title_jp = str_replace('！', '', $bangumi_title_jp);
            if ($anime = Anime::where('sources', 'not like', '%"bangumi"%')->where('started_at', '!=', null)->orderBy('id', 'asc')->where('title_jp', 'ilike', '%'.$bangumi_title_jp.'%')/*->where('category', $anime_temp->category)*/->first()) {
                $mal_started_at = $anime->started_at;
                $sub_week = Carbon::parse($mal_started_at)->subDays(3)->toDateString();
                $add_week = Carbon::parse($mal_started_at)->addDays(3)->toDateString();
                if ($anime_temp->started_at >= $sub_week && $anime_temp->started_at <= $add_week) {
                    echo "MAL ID#{$anime->id} = {$anime->title_jp} | Bangumi ID#{$anime_temp->id} = {$anime_temp->title_jp}<br>";
                }
            }
        }
    }

    public function importBangumiAnimesLinkable(Request $request)
    {
        $anime_temps = AnimeTemp::where('started_at', '!=', null)->orderBy('id', 'asc')->skip($request->skip)->limit($request->limit)->get();
        foreach ($anime_temps as $anime_temp) {
            if (strpos($anime_temp->title_jp, ' ') !== false) {
                $bangumi_title_jp = explode(' ', $anime_temp->title_jp)[0];
            } else {
                $bangumi_title_jp = $anime_temp->title_jp;
            }
            $bangumi_title_jp = str_replace('?', '', $bangumi_title_jp);
            $bangumi_title_jp = str_replace('？', '', $bangumi_title_jp);
            $bangumi_title_jp = str_replace('!', '', $bangumi_title_jp);
            $bangumi_title_jp = str_replace('！', '', $bangumi_title_jp);
            if ($anime = Anime::where('sources', 'not like', '%"bangumi"%')->where('started_at', '!=', null)->orderBy('id', 'asc')->where('title_jp', 'ilike', '%'.$bangumi_title_jp.'%')/*->where('category', $anime_temp->category)*/->first()) {
                $mal_started_at = $anime->started_at;
                $sub_week = Carbon::parse($mal_started_at)->subDays(3)->toDateString();
                $add_week = Carbon::parse($mal_started_at)->addDays(3)->toDateString();
                if ($anime_temp->started_at >= $sub_week && $anime_temp->started_at <= $add_week) {
                    if ($anime->title_zhs == null) {
                        $anime->title_zhs = $anime_temp->title_zhs;
                        $anime->description = trim($anime_temp->description);
                    }
                    if ($anime->started_at == null) {
                        $anime->started_at = $anime_temp->started_at;
                        $anime->started_at_show = $anime_temp->started_at_show;
                    }
                    if ($anime->ended_at == null) {
                        $anime->ended_at = $anime_temp->ended_at;
                    }
                    $anime->source = $anime_temp->source;
                    $anime->rating_bangumi = $anime_temp->rating_bangumi;
                    $anime->rating_bangumi_count = $anime_temp->rating_bangumi_count;
                    $temp = $anime->sources;
                    $temp['bangumi'] = $anime_temp->sources['bangumi'];
                    $anime->sources = $temp;
                    $anime->save();
                    $anime_temp->delete();
                }
            }
        }
    }

    public function tempMethod(Request $request)
    {   
        $staffs = Staff::where('name_zht', 'like', "%-%-%")->orderBy('id', 'asc')->get();
        foreach ($staffs as $staff) {
            $birthday = Carbon::createFromFormat('Y-m-d H:i:s',  str_replace('????', '1000', $staff->name_zht).' 00:00:00'); 
            $staff->birthday = $birthday;
            $staff->name_zht = null;
            $staff->save();
        }
        /* $staffs = Staff::where('name_zht', 'like', "%年%月%日")->orderBy('id', 'asc')->get();
        foreach ($staffs as $staff) {
            $birthday = Carbon::createFromFormat('Y年m月d日 H:i:s',  $staff->name_zht.' 00:00:00'); 
            $staff->birthday = $birthday;
            $staff->name_zht = null;
            $staff->save();
        } */

        // Update anime null count to 0
        /* $animes = Anime::where('rating_mal_count', null)->get();
        foreach ($animes as $anime) {
            $anime->rating_mal_count = 0;
            $anime->save();
        } */

        // Anilist API
        /* $query = '
        query ($id: Int, $page: Int, $perPage: Int, $search: String) {
          Page (page: $page, perPage: $perPage) {
            pageInfo {
              currentPage
              hasNextPage
              perPage
            }
            media (id: $id, search: $search) {
              id
              title {
                romaji
              }
            }
          }
        }
        ';

        $variables = [
            "page" => 1,
            "perPage" => 50
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://graphql.anilist.co");
        curl_setopt($ch, CURLOPT_POST, true);
        $data = json_encode([
                    'query' => $query,
                    'variables' => $variables,
            ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true); */


        /* $animes = Anime::where('id', '>=', $request->from)->where('id', '<=', $request->to)->where('sources', 'ilike', '%"myanimelist"%')->where('rating_mal_count', null)->orderBy('started_at', 'desc')->get();
        foreach ($animes as $anime) {
            $curl_connection = curl_init($anime->sources['myanimelist']);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);
            sleep(1);

            if (strpos($html, '404 Not Found') === false) {
                if (strpos($html, '<h1 class="title-name h1_bold_none"><strong>') !== false) {
                    // Scrape genre from MAL
                    if (strpos($html, '<span class="dark_text">Genre') !== false) {
                        $genre_list_raw = trim(Helper::get_string_between($html, '<span class="dark_text">Genre', '<div class="spaceit_pad">'));
                        $genre_list = explode('itemprop="genre"', $genre_list_raw);
                        array_shift($genre_list);
                        $genres = [];
                        foreach ($genre_list as $item) {
                            $genre = trim(Helper::get_string_between($item, 'style="display: none">', '</span>'));
                            array_push($genres, $genre);
                        }
                        $anime->genres = $genres;
                        $anime->save();
                        Log::info("Anime#{$anime->id} genre scraped");
                    } else {
                        Log::info("Anime#{$anime->id} has no genre");
                    }

                    // Scrape ratings count from MAL
                    if (strpos($html, 'data-title="score" data-user="') !== false) {
                        $rating_mal_count = trim(Helper::get_string_between($html, 'data-title="score" data-user="', ' user'));
                        $rating_mal_count = str_replace(',', '', $rating_mal_count);
                        if ($rating_mal_count != '-') {
                            $anime->rating_mal_count = $rating_mal_count;
                            $anime->save();
                            Log::info("Anime#{$anime->id} ratings count scraped");
                        } else {
                            Log::info("Anime#{$anime->id} has no ratings count");
                        }
                        
                    } else {
                        Log::info("Anime#{$anime->id} has no ratings count");
                    }

                } else {
                    Log::warning("Anime#{$anime->id} access failed");
                }
            } else {
                Log::info("Anime#{$anime->id} not found");
            }
        } */

        // Check repeated episodes
        /* $animes = Anime::with('episodes')->where('id', '>=', $request->from)->where('id', '<=', $request->to)->orderBy('id', 'asc')->get();
        foreach ($animes as $anime) {
            if ($episodes = $anime->episodes) {
                $episodes_list = [];
                foreach ($episodes as $episode) {
                    $title = explode('.', $episode->title_jp);
                    if ($title[1] != '') {
                        if (in_array($title[1], $episodes_list)) {
                            return "Anime ID#{$anime->id} title {$title[1]}";
                        } else {
                            array_push($episodes_list, $title[1]);
                        }
                    }
                }
            }            
        } */

        // Scrape voice actors
        /* $from = $request->from;
        $to = $request->to;
        $actors = Actor::where('id', '>=', $from)->where('id', '<=', $to)->get();
        foreach ($actors as $actor) {
            $curl_connection = curl_init($actor->sources['myanimelist']);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);
            sleep(1);

            if (strpos($html, $actor->photo_cover) !== false || $actor->photo_cover == "https://cdn.myanimelist.net/images/questionmark_23.gif") {
                if (strpos($html, 'Given name:') !== false && strpos($html, 'Family name:') !== false) {
                    $actor_given_name = Helper::get_string_between($html, 'span class="dark_text">Given name:</span> ', '</div>');
                    $actor_family_name = Helper::get_string_between($html, 'span class="dark_text">Family name:</span> ', '<div class="spaceit_pad">');
                    $actor->name_jp = "{$actor_family_name}{$actor_given_name}";
                    $actor->save();
                    echo "INFO: Actor#{$actor->id} scraped<br>";

                } else {
                    echo "<span style='color:red'>WARNING: Actor#{$actor->id} has no name</span><br>";
                }
            } else {
                echo "<span style='color:red'>WARNING: Actor#{$actor->id} access failed</span><br>";
            }
        } */

        // Scrape character-actor pivot
        /* $from = $request->from;
        $to = $request->to;
        $characters = Character::where('id', '>=', $from)->where('id', '<=', $to)->get();
        foreach ($characters as $character) {
            $curl_connection = curl_init($character->sources['myanimelist']);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);
            sleep(1);

            if ($animes = $character->animes) {
                foreach ($animes as $anime) {
                    $link = $anime->sources['myanimelist'];
                    $role_raw = trim(Helper::get_string_between($html, $link, '/small>'));
                    $role = trim(Helper::get_string_between($role_raw, '<small>', '<'));
                    $pivot_single = ActorAnimeCharacter::where('anime_id', $anime->id)->where('character_id', $character->id)->first();
                    $pivot_single->role = $role;
                    $pivot_single->save();
                }
            }

            if (strpos($html, $character->photo_cover) !== false) {
                if (strpos($html, 'No voice actors have been added to this character.') === false) {
                    $actor_raw = Helper::get_string_between($html, '<div class="normal_header">Voice Actors</div>', '<br>');
                    $actor_raw_array = explode('<table border="0" cellpadding="0" cellspacing="0" width="100%">', $actor_raw);
                    array_shift($actor_raw_array);
                    $actor_details = '';
                    if (strpos($actor_raw, '<small>Japanese</small>') !== false) {
                        foreach ($actor_raw_array as $actor_raw_item) {
                            if (strpos($actor_raw_item, '<small>Japanese</small>') !== false) {
                                $actor_details = $actor_raw_item;
                            }
                        }
                    } else {
                        $actor_details = $actor_raw_array[0];
                    }

                    $actor_link = Helper::get_string_between($actor_details, '<a href="', '"');
                    $actor_sources = ['myanimelist' => $actor_link];
                    $actor_photo = Helper::get_string_between($actor_details, '<img class="lazyload" data-src="', '"');
                    $actor_name_from = '<td class="borderClass" valign="top"><a href="'.$actor_link.'">';
                    $actor_name = trim(Helper::get_string_between($actor_details, $actor_name_from, '</a>'));
                    $actor_language = trim(Helper::get_string_between($actor_details, '<small>', '</small>'));
                    if (!Actor::where('sources', 'ilike', '%"'.$actor_link.'"%')->exists()) {
                        $actor = Actor::create([
                            'name_en' => $actor_name,
                            'photo_cover' => $actor_photo,
                            'language' => $actor_language,
                            'sources' => $actor_sources,
                        ]);
                        echo "INFO: Character#{$character->id} voice actor scraped<br>";
                    } else {
                        $actor = Actor::where('sources', 'ilike', '%"'.$actor_link.'"%')->first();
                        echo "INFO: Character#{$character->id} voice actor exists<br>";
                    }
                    $pivots = ActorAnimeCharacter::where('character_id', $character->id)->get();
                    foreach ($pivots as $pivot) {
                        $pivot->actor_id = $actor->id;
                        $pivot->save();
                    }

                } else {
                    echo "INFO: Character#{$character->id} has no voice actor<br>";
                }
            } else {
                echo "<span style='color:red'>WARNING: Character#{$character->id} access failed</span><br>";
            }
        } */

        // Calculate season based on started at
        /* $animes = Anime::where('started_at', '!=', null)->where('season', null)->get();
        foreach ($animes as $anime) {
            $month = Carbon::parse($anime->started_at)->format('m');
            $year = Carbon::parse($anime->started_at)->format('Y');
            if ($month == '01' || $month == '02' || $month == '03') {
                $anime->season = "Winter {$year}";
            }
            if ($month == '04' || $month == '05' || $month == '06') {
                $anime->season = "Spring {$year}";
            }
            if ($month == '07' || $month == '08' || $month == '09') {
                $anime->season = "Summer {$year}";
            }
            if ($month == '10' || $month == '11' || $month == '12') {
                $anime->season = "Fall {$year}";
            }
            $anime->save();
        } */

        // Extract start date and end date
        /* $animes = Anime::where('photo_banner', 'like', '% \to %')->where('photo_banner', 'not like', '%?%')->orderBy('id', 'desc')->get();
        foreach ($animes as $anime) {
            try {
                $started_at = explode(' to ', $anime->photo_banner)[0];
                $anime->started_at = Carbon::createFromFormat('!M d, Y', $started_at, '0');   
                $anime->save();  
            } catch (\Carbon\Exceptions\InvalidFormatException $e) {
                echo "ID#{$anime->id} invalid start date<br>";
            }
            try {
                $ended_at = explode(' to ', $anime->photo_banner)[1];
                $anime->ended_at = Carbon::createFromFormat('!M d, Y', $ended_at, '0'); 
                $anime->save();  
            } catch (\Carbon\Exceptions\InvalidFormatException $e) {
                echo "ID#{$anime->id} invalid end date<br>";
            }
        }

        $animes = Anime::where('photo_banner', 'like', '%, %')->orderBy('id', 'desc')->get();
        foreach ($animes as $anime) {
            $anime->started_at = Carbon::createFromFormat('!M d, Y', $anime->photo_banner, '0'); 
            $anime->photo_banner = null;  
            $anime->save();
        } */

        // Scrape anime character pivot
        /* $from = $request->from;
        $to = $request->to;
        $characters = Character::where('id', '>=', $from)->where('id', '<=', $to)->get();
        foreach ($characters as $character) {
            $curl_connection = curl_init($character->sources['myanimelist']);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            $html = curl_exec($curl_connection);
            curl_close($curl_connection);
            sleep(1);

            $animeography = Helper::get_string_between($html, '<div class="normal_header character-anime">Animeography</div>', '</table>');
            $anime_links = explode('<div class="picSurround">', $animeography);
            array_shift($anime_links);
            foreach ($anime_links as $link) {
                $mal_id = Helper::get_string_between($link, '<a href="https://myanimelist.net/anime/', '/');
                if ($anime = Anime::where('sources', 'ilike', '%'.'"https://myanimelist.net/anime/'.$mal_id.'/"'.'%')->first()) {
                    if (!AnimeCharacter::where('anime_id', $anime->id)->where('character_id', $character->id)->exists()) {
                        $animeCharacter = AnimeCharacter::create([
                            'anime_id' => $anime->id,
                            'character_id' => $character->id,
                        ]);
                        echo "Anime#{$anime->id} and Character#{$character->id} link success<br>";
                    } else {
                        echo "Anime#{$anime->id} and Character#{$character->id} link exists<br>";
                    }
                } else {
                    return "MAL ID#{$mal_id} not scraped";
                }
            }
            echo "Character#{$character->id} complete<br>";
        } */

        // Scrape MAL characters
        /* $from = $request->from;
        $to = $request->to;
        $characters = Character::where('id', '>=', $from)->where('id', '<=', $to)->get();
        foreach ($characters as $character) {
            if (!AnimeCharacter::where('character_id', $character->id)->exists()) {
                $curl_connection = curl_init($character->sources['myanimelist']);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);
                sleep(1);

                if (strpos($html, $character->photo_cover) !== false) {
                    $animeography = Helper::get_string_between($html, '<div class="normal_header character-anime">Animeography</div>', '</table>');
                    $anime_links = explode('<div class="picSurround">', $animeography);
                    array_shift($anime_links);
                    foreach ($anime_links as $link) {
                        $mal_id = Helper::get_string_between($link, '<a href="https://myanimelist.net/anime/', '/');
                        if ($anime = Anime::where('sources', 'ilike', '%'.'"https://myanimelist.net/anime/'.$mal_id.'/"'.'%')->first()) {
                            if (!AnimeCharacter::where('anime_id', $anime->id)->where('character_id', $character->id)->exists()) {
                                $animeCharacter = AnimeCharacter::create([
                                    'anime_id' => $anime->id,
                                    'character_id' => $character->id,
                                ]);
                                echo "Anime#{$anime->id} and Character#{$character->id} link success<br>";
                            } else {
                                echo "Anime#{$anime->id} and Character#{$character->id} link exists<br>";
                            }
                        } else {
                            return "MAL ID#{$mal_id} not scraped";
                        }
                    }
                    echo "Character#{$character->id} complete<br>";
                } else {
                    echo "Character#{$character->id} access failed<br>";
                }
            }
        } */

        // Scrape characters
        /* for ($i = $request->start; $i <= $request->end; $i++) { 

            $url = "https://myanimelist.net/character/{$i}";

            if (!Character::where('sources', 'ilike', "%{$url}%")->exists()) {
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                if (strpos($html, 'Invalid ID provided') !== false) {
                    echo $i.' page not found<br>';

                } else {
                    $name_en = trim(Helper::get_string_between($html, '<h2 class="normal_header" style="height: 15px;">', '<'));
                    $name_jp = trim(Helper::get_string_between($html, '<small>(', ')</small>'));
                    $description = trim(Helper::get_string_between($html, '</h2>', '<div'));
                    $description = iconv(mb_detect_encoding($description, mb_detect_order(), true), "UTF-8//IGNORE", $description);
                    $photo_cover = trim(Helper::get_string_between($html, '<meta property="og:image" content="', '"'));
                    $sources = [];
                    $sources["myanimelist"] = $url;
                    if ($photo_cover == '' && $name_en == '' && $name_jp == '' && $description == '') {
                        echo $i.' page access failed<br>';
                    } else {
                        $character = Character::create([
                            'photo_cover' => $photo_cover,
                            'name_en' => $name_en,
                            'name_jp' => $name_jp,
                            'description' => $description,
                            'sources' => $sources,
                        ]);
                    }
                }

            } else {
                echo $i.' character exists<br>';
            }
        } */

        /* if ($request->column == 'startenddate') {
            $animes = Anime::where('airing_status', 'like', '% \to %')->where('airing_status', 'not like', '%?%')->orderBy('id', 'desc')->get();
            foreach ($animes as $anime) {
                try {
                    $started_at = explode(' to ', $anime->airing_status)[0];
                    $anime->started_at = Carbon::createFromFormat('!M d, Y', $started_at, '0');   
                    $anime->save();  
                } catch (\Carbon\Exceptions\InvalidFormatException $e) {
                    echo "ID#{$anime->id} invalid start date<br>";
                }
                try {
                    $ended_at = explode(' to ', $anime->airing_status)[1];
                    $anime->ended_at = Carbon::createFromFormat('!M d, Y', $ended_at, '0'); 
                    $anime->save();  
                } catch (\Carbon\Exceptions\InvalidFormatException $e) {
                    echo "ID#{$anime->id} invalid end date<br>";
                }
            }

        } elseif ($request->column == 'genre') {
            $animes = Anime::where('genres', '[]')->orderBy('id', 'desc')->get();
            foreach ($animes as $anime) {
                $url = 'https://myanimelist.net/anime/16498/';
                $curl_connection = curl_init($url);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $html = curl_exec($curl_connection);
                curl_close($curl_connection);

                if (strpos($html, '<span class="dark_text">Genres:</span>') !== false) {
                    $genres = trim(Helper::get_string_between($html, '<span class="dark_text">Genres:</span>', '</div>'));
                    $genres = explode(',', $genres);
                    foreach ($genres as &$genre) {
                        $genre = trim(Helper::get_string_between($genre, '<span itemprop="genre" style="display: none">', '</span>'));
                    }
                }
                $anime->save();

                if ($animes->last() != $anime) {
                    sleep(10);
                }
            }
        } */
    }

    public function updateSearchtext(Request $request)
    {
        // Update company search text
        $companies = Company::all();
        foreach ($companies as $company) {
            $searchtext = $company->name_zht.'|'.$company->name_zhs.'|'.$company->name_jp.'|'.$company->name_en;
            $company->searchtext = mb_strtolower(preg_replace('/\s+/', '', $searchtext), 'UTF-8');
            $company->save();
        }
        
        // Update character search text
        $characters = Character::all();
        foreach ($characters as $character) {
            $searchtext = $character->name_zht.'|'.$character->name_zhs.'|'.$character->name_jp.'|'.$character->name_en;
            $character->searchtext = mb_strtolower(preg_replace('/\s+/', '', $searchtext), 'UTF-8');
            $character->save();
        }

        // Update staff search text
        $staffs = Staff::all();
        foreach ($staffs as $staff) {
            $searchtext = $staff->name_zht.'|'.$staff->name_zhs.'|'.$staff->name_jp.'|'.$staff->name_en;
            $staff->searchtext = mb_strtolower(preg_replace('/\s+/', '', $searchtext), 'UTF-8');
            $staff->save();
        }

        // Update anime search text
        $animes = Anime::all();
        foreach ($animes as $anime) {
            $searchtext = $anime->title_zht.'|'.$anime->title_zhs.'|'.$anime->title_jp.'|'.$anime->title_en.'|'.$anime->title_ro.'|'.$anime->season.'|'.$anime->category.'|'.$anime->source.'|'.$anime->animation_studio.'|'.$anime->author.'|'.$anime->director;

            $anime->searchtext = mb_strtolower(preg_replace('/\s+/', '', $searchtext), 'UTF-8');
            $anime->save();
        }
    }
}