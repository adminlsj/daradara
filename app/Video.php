<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Watch;
use App\Subscribe;
use App\Comment;
use App\Like;
use Spatie\Browsershot\Browsershot;

class Video extends Model
{
    protected $casts = [
        'foreign_sd' => 'array', 'data' => 'array', 'translations' => 'array'
    ];

	protected $fillable = [
        'id', 'user_id', 'playlist_id', 'title', 'caption', 'tags', 'sd', 'imgur', 'views', 'outsource', 'foreign_sd', 'data', 'created_at', 'uploaded_at', 'cover', 'translations'
    ];

    public static $setting = [
        '姐', '妹', '母', '人妻', '青梅竹馬', '處女', '御姐', '熟女'
    ];

    public static $profession = [
        'JK', '運動少女', '大小姐', '老師', '女醫護士', '女僕', '巫女', '修女', '偶像', 'OL', '風俗娘', '公主', '女騎士', '魔法少女', '妖精', '魔物娘', '獸娘'
    ];

    public static $appearance = [
        '巨乳', '貧乳', '黑皮膚', '眼鏡娘', '泳裝', '圍裙', '黑絲襪', '和服', '獸耳', '碧池', '不良少女', '傲嬌', '病嬌', '偽娘', '扶他'
    ];

    public static $storyline = [
        '自慰', '口交', '乳交', '肛交', '腳交', '腋下', '玩具', '觸手', '內射', '顏射', '3P', '群交', '後宮', '公眾場合', '近親', '師生', 'NTR', '懷孕', '噴奶', '放尿', '精神控制', '藥物', '痴漢', '阿嘿顏', '精神崩潰', '鬼畜', 'BDSM', '調教', '強制', '逆強制', '痴女', '女王樣', '百合', '耽美', '性轉換', '異世界', '異種族', '純愛', '戀愛喜劇', '世界末日'
    ];

    public static $hentai_tags = [
        '3D', 'JK', '御姐', '人妻', '熟女', '大小姐', '公主', '傲嬌', '碧池', '痴女', '處女', '眼鏡娘', '黑皮膚', '歐尼醬', '老師', '女OL', '醜男', '痴漢',
        '巨乳', '貧乳', '乳交', '手交', '口交', '腳交', '肛交', '毒龍鑽', '腋下', '自慰', '玩具', '顏射', '內射', '3P', '群交', '後宮', '親子丼', '阿嘿顏', '援交',
        'BDSM', '綑綁', '調教', '觸手', '強制', '鬼畜', '逆強制', '女王樣', '精神控制', '精神崩潰', '爆精', '放尿', '懷孕', '噴奶',
        '角色扮演', '貓耳', '護士', '泳裝', '女僕', '裸體圍裙', '黑絲襪', '修女',
        '異世界', '異種族', '妖精', '魔物娘', '獸娘', '怪獸',
        '劇情', '校園', '純愛', '窩邊草', 'NTR', '藥物', '奇幻', '性轉換', '公眾場合',
        '百合', '扶他', '偽娘', '耽美', 'YOOO'
    ];

    public static $selected_tags = [
        '姐', '妹', '母', '人妻', '青梅竹馬', '御姐', '熟女', 'JK', '運動少女', '大小姐', '老師', '女醫護士', '女僕', '巫女', '修女', '偶像', 'OL', '風俗娘', '公主', '女騎士', '魔法少女', '妖精', '魔物娘', '獸娘', '貧乳', '黑皮膚', '眼鏡娘', '泳裝', '圍裙', '黑絲襪', '和服', '獸耳', '處女', '不良少女', '傲嬌', '病嬌', '偽娘', '扶他', '肛交', '腳交', '腋下', '觸手', '群交', '近親', '師生', 'NTR', '懷孕', '噴奶', '放尿', '精神控制', '藥物', '痴漢', '阿嘿顏', '精神崩潰', '鬼畜', 'BDSM', '強制', '逆強制', '痴女', '女王樣', '百合', '耽美', '性轉換', '異世界', '異種族', '純愛', '戀愛喜劇', '世界末日'
    ];

    public static $hentai_brands = [
        '妄想実現めでぃあ', 'メリー・ジェーン', 'ピンクパイナップル', 'ばにぃうぉ～か～', 'Queen Bee', 'PoRO', 'せるふぃっしゅ', '鈴木みら乃', 'ショーテン', 'GOLD BEAR', 'ZIZ', 'EDGE', 'Collaboration Works', 'BOOTLEG', 'BOMB!CUTE!BOMB!', 'nur', 'あんてきぬすっ', '魔人', 'ルネ', 'Princess Sugar', 'パシュミナ', 'WHITE BEAR'
    ];

    public static $tags = [
        '正版動漫', '同人動畫', '動漫講評', '明星', '日本人氣YouTuber', '日本創意廣告', '日劇講評'
    ];

    public static $genres = [
        '動畫卡通' => 'anime', '綜藝頻道' => 'variety', '明星專區' => 'artist', '迷因翻譯' => 'meme'
    ];

    public static $content = [
        'anime' => ['動漫', '動畫', '動漫講評', 'MAD·AMV'], 'aninews' => ['動漫情報'], 'variety' => ['綜藝'], 'artist' => ['明星', '日劇'], 'meme' => ['迷因'], 'daily' => ['生活']
    ];

    public static $titles = [
        'anime' => '動漫', 'aninews' => '情報', 'variety' => '綜藝', 'artist' => '明星', 'meme' => '迷因', 'daily' => '生活'
    ];

    public static $tagsArray = [
        'anime' => ['正版動漫', 'anime1', '同人動畫', '原創動畫', '動漫講評', 'MAD·AMV'], 'aninews' => ['新番情報', '劇場版', '聲優', '動漫講評', '動漫新聞', 'Cosplay'], 'variety' => ['嵐Arashi', '貴婦松子Deluxe', 'Downtown', '倫敦靴子1號2號', '有吉弘行', 'RunningMan'], 'artist' => ['明星', 'Gimy劇迷', '佐藤健', '石原聰美', '新垣結衣', '木村拓哉', '綾瀨遙', '劉在錫'], 'meme' => ['日本人氣YouTuber', '日本創意廣告', '搞笑影片', '綜藝剪輯'], 'daily' => ['新聞資訊', '流行速報', '日本旅遊', '日本美食', '日本房產']
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function watch()
    {
        return $this->belongsTo('App\Watch', 'playlist_id');
    }

    public function subscribes()
    {
        return Subscribe::where('tag', $this->watch()->title)->orderBy('created_at', 'asc')->get();
    }

    public function comments()
    {
        return Comment::where('type', 'video')->where('foreign_id', $this->id)->orderBy('created_at', 'desc')->get();
    }

    public function tags()
    {
        return explode(" ", $this->tags);
    }

    public function likes()
    {
        return Like::where('type', 'video')->where('foreign_id', $this->id)->orderBy('created_at', 'desc')->get();
    }

    public static function getSpankbang(String $url, String $tags)
    {
        $requests = Browsershot::url($url)
            ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
            ->triggeredRequests();
        foreach ($requests as $request) {
            if (strpos($request['url'], 'spankbang.com/stream/') !== false && strpos($request['url'], '.mp4') !== false) {
                $curl_connection = curl_init();
                curl_setopt($curl_connection, CURLOPT_URL, $request['url']);
                curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, true); // follow the redirects
                curl_setopt($curl_connection, CURLOPT_NOBODY, true); // get the resource without a body
                curl_exec($curl_connection);
                $redirect = curl_getinfo($curl_connection, CURLINFO_EFFECTIVE_URL);
                curl_close($curl_connection);

                if (strpos($tags, ' 1080p ') !== false) {
                    return str_replace('720p', '1080p', $redirect);
                } else {
                    return $redirect;
                }
            }
        }
    }

    public static function getYoujizz(String $url)
    {
        $html = Browsershot::url($url)
            ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
            ->bodyHtml();
        $start = explode('<source src="', $html);
        return html_entity_decode("https:".explode('" title="' , $start[1])[0]);
    }

    public static function getSlutload(String $url)
    {
        $requests = Browsershot::url($url)
            ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
            ->triggeredRequests();
        foreach ($requests as $request) {
            if (strpos($request['url'], 'https://v-rn.slutload-media.com/') !== false) {
                return $request['url'];
            }
        }
    }

    public static function tagSubscribeFirst(Subscribe $subscribe)
    {
        return Video::where('tags', 'LIKE', '%'.$subscribe->tag.'%')->orderBy('uploaded_at', 'desc')->first();
    }

    public static function notifySubscribers(Video $video)
    {
        if ($video->playlist_id != '') {
            $watch = $video->watch;
            $watch->updated_at = $video->uploaded_at;
            $watch->save();

            $subscribes = $watch->subscribes();
            foreach ($subscribes as $subscribe) {
                $user = $subscribe->user();
                if (strpos($user->alert, 'subscribe') === false) {
                    $user->alert = $user->alert."subscribe";
                    $user->save();
                }
            }
        }
    }

    public function imgur16by9()
    {
        return "https://i.imgur.com/JMcgEkPl.jpg";
    }

    public function imgurDefaultCircleB()
    {
        return "https://i.imgur.com/sMSpYFXb.jpg";
    }

    public function imgur()
    {
        return "https://i.imgur.com/".$this->imgur.".jpg";
    }

    public function imgurS()
    {
        return "https://i.imgur.com/".$this->imgur."s.jpg";
    }

    public function imgurB()
    {
        return "https://i.imgur.com/".$this->imgur."b.jpg";
    }

    public function imgurT()
    {
        return "https://i.imgur.com/".$this->imgur."t.jpg";
    }

    public function imgurM()
    {
        return "https://i.imgur.com/".$this->imgur."m.jpg";
    }

    public function imgurL()
    {
        return "https://i.imgur.com/".$this->imgur."l.jpg";
    }

    public function imgurH()
    {
        return "https://i.imgur.com/".$this->imgur."h.jpg";
    }

    public function source()
    {
        $sd = $this->sd()[0];
        if (strpos($sd, 'instagram.com') !== false) {
            return Video::getSourceIG($sd);
        } elseif (strpos($sd, 'player.bilibili.com') !== false) {
            return Video::getMobileBB($sd);
        } else {
            return $sd;
        }
    }

    public function outsource()
    {
        $sd = $this->sd()[0];
        if (strpos($sd, '?') !== false) {
            return $sd.'&danmaku=0&qn=0&type=mp4&otype=json&fnver=0&fnval=1&platform=html5&html5=1&high_quality=1&autoplay=1';
        } else {
            return $sd.'?danmaku=0&qn=0&type=mp4&otype=json&fnver=0&fnval=1&platform=html5&html5=1&high_quality=1&autoplay=1';;
        }
    }

    public function sd()
    {
        if (strpos($this->sd, "spankbang.com") !== FALSE) {
            $curl_connection = curl_init();
            curl_setopt($curl_connection, CURLOPT_URL, $this->sd);
            curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, true); // follow the redirects
            curl_setopt($curl_connection, CURLOPT_NOBODY, true); // get the resource without a body
            curl_exec($curl_connection);
            $redirect = curl_getinfo($curl_connection, CURLINFO_EFFECTIVE_URL);
            curl_close($curl_connection);
            return str_replace('720p', '1080p', $redirect);
            
        } else {
            return $this->sd;
        }
    }

    public static function setPlayerConfig($video, $country_code, $is_mobile, &$outsource, &$sd)
    {
        if ($video->foreign_sd && array_key_exists($country_code, $video->foreign_sd)) {
            $outsource = true;
            $sd = $video->foreign_sd[$country_code];
            if ($is_mobile && strpos($sd, "player.bilibili.com") !== FALSE) {
                $sd = urldecode(str_replace('https://www.agefans.tv/age/player/ckx1/?url=', '', $video->sd));
            }

        } elseif (strpos($sd, "agefans.tv") !== FALSE) {
            $outsource = false;
            $sd = urldecode(str_replace('https://www.agefans.tv/age/player/ckx1/?url=', '', $video->sd));
        
        } elseif (strpos($sd, "spankbang.com") !== FALSE) {
            $outsource = false;
            $curl_connection = curl_init();
            curl_setopt($curl_connection, CURLOPT_URL, $sd);
            curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, true); // follow the redirects
            curl_setopt($curl_connection, CURLOPT_NOBODY, true); // get the resource without a body
            curl_exec($curl_connection);
            $redirect = curl_getinfo($curl_connection, CURLINFO_EFFECTIVE_URL);
            curl_close($curl_connection);
            $sd = str_replace('720p', '1080p', $redirect);
        }

        $bilibili = strpos($sd, "player.bilibili.com") !== FALSE;
        if (!$outsource && $bilibili || $is_mobile && $bilibili) {
            $outsource = false;
            $sd = Video::getMobileBB($sd);
        }

        if ($outsource) {
            if (strpos($sd, '?') !== false) {
                $sd = $sd.'&danmaku=0&qn=0&type=mp4&otype=json&fnver=0&fnval=1&platform=html5&html5=1&high_quality=1&autoplay=1';
            } else {
                $sd = $sd.'?danmaku=0&qn=0&type=mp4&otype=json&fnver=0&fnval=1&platform=html5&html5=1&high_quality=1&autoplay=1';;
            }
        }
    }

    static function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public function scopeTagsWithLimit($query, $tags, $count = 8)
    {
        return $query->with('user:id,name')->where(function($query) use ($tags) {
            foreach ($tags as $tag) {
                $query->orWhere('tags', 'like', '%'.$tag.'%');
            }
        })->orderBy('uploaded_at', 'desc')->limit($count)->select('id', 'user_id', 'imgur', 'title', 'sd');
    }

    public function scopeTagsWithPaginate($query, $tags)
    {
        return $query->with('user:id,name')->where(function($query) use ($tags) {
            foreach ($tags as $tag) {
                $query->orWhere('tags', 'like', '%'.$tag.'%');
            }
        })->select('id', 'user_id', 'imgur', 'title', 'sd');
    }

    public static function getExcludedIds()
    {
        $first = [];
        $playlists = [797, 308, 122, 685, 810, 680, 732, 813];
        foreach ($playlists as $playlist_id) {
            array_push($first, Video::where('playlist_id', $playlist_id)->orderBy('created_at', 'desc')->first()->id);
        }

        return $videos = Video::where(function($query) use ($playlists) {
            foreach ($playlists as $playlist) {
                $query->orWhere('playlist_id', $playlist);
            }
        })->whereNotIn('id', $first)->pluck('id');
    }
}
