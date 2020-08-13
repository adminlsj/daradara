<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Watch;
use App\Subscribe;
use App\Comment;
use Spatie\Browsershot\Browsershot;

class Video extends Model
{
    protected $casts = [
        'foreign_sd' => 'array', 'data' => 'array'
    ];

	protected $fillable = [
        'id', 'user_id', 'playlist_id', 'title', 'caption', 'tags', 'sd', 'imgur', 'views', 'outsource', 'foreign_sd', 'data', 'created_at', 'uploaded_at',
    ];

    public static $hentai_tags = [
        '3D', 'JK', '御姐', '人妻', '熟女', '大小姐', '公主', '傲嬌', '碧池', '處女', '眼鏡娘', '黑皮膚', '歐尼醬', '老師', '醜男',
        '巨乳', '貧乳', '乳交', '手交', '口交', '腳交', '肛交', '自慰', '玩具', '顏射', '內射', '3P', '群交', '後宮', '親子丼', '阿嘿顏', '援交',
        'BDSM', '綑綁', '觸手', '強制', '逆強制', '女王', '調教', '精神控制', '精神崩潰', '爆精', '放尿', '懷孕', '噴奶',
        '角色扮演', '貓耳', '雙馬尾', '護士', '泳裝', '巫女', '女僕', '裸體圍裙', '和服',
        '異世界', '異種族', '妖精', '怪獸',
        '劇情', '校園', '純愛', '奇幻', '鬼畜', 'NTR', '窩邊草', '公眾場合',
        '百合', '雙性', '偽娘', '耽美', 'YOOO'
    ];

    public static $hentai_brands = [
        '妄想実現めでぃあ', 'メリー・ジェーン', 'ピンクパイナップル', 'ばにぃうぉ～か～', 'Queen Bee', 'PoRO', 'せるふぃっしゅ', '鈴木みら乃', 'ショーテン', 'GOLD BEAR', 'ZIZ', 'EDGE', 'Collaboration Works', 'BOOTLEG', 'BOMB!CUTE!BOMB!', 'nur', 'あんてきぬすっ', '魔人', 'ルネ', 'Princess Sugar'
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

    public function views()
    {
        if ($this->views >= 10000) {
            return ceil($this->views / 10000).'萬';
        } else {
            return $this->views;
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
        return explode(" ",$this->sd);
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

    public static function getSourceQQ($url)
    {
        try {
            $curl_connection = curl_init();
            curl_setopt($curl_connection, CURLOPT_URL, $url);
            curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, true); // follow the redirects
            curl_setopt($curl_connection, CURLOPT_NOBODY, true); // get the resource without a body
            curl_exec($curl_connection);
            $redirect = curl_getinfo($curl_connection, CURLINFO_EFFECTIVE_URL);
            curl_close($curl_connection);

            $start = strpos($redirect, 'http');
            $end = strpos($redirect, 'vmtt.tc.qq.com/');
            return substr_replace($redirect, 'https://apd-vliveachy.apdcdn.tc.qq.com/vmtt.tc.qq.com/', $start, $end - $start + 15);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getSourceQZ($url)
    {
        return Video::get_qzone_video($url);
    }

    static function get_qzone_video($picKey){
        $admin = User::find(1);
        $hostUin = $admin->provider;
        $p_skey = $admin->provider_id;
        $tk = Video::g_tk($p_skey); 
        $url = "https://h5.qzone.qq.com/proxy/domain/taotao.qq.com/cgi-bin/video_get_data?g_tk={$tk}&picKey={$picKey}&number=1&hostUin={$hostUin}&getMethod=3";

        $curl_connection = curl_init($url);
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_connection, CURLOPT_HTTPHEADER, [
            'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:56.0) Gecko/20100101 Firefox/56.0',
            'Host: h5.qzone.qq.com',
            "Cookie: uin=o{$hostUin}; p_skey={$p_skey};",
        ]);
        $content = curl_exec($curl_connection);
        curl_close($curl_connection);

        $json = str_replace(");","",str_replace("_Callback(","",$content));  
        $data = json_decode($json,true);  
        if ($data["code"] == 0){  
            foreach ($data["data"]["photos"] as $key => $value) {  
                $fkey = $value["picKey"];  
                if($fkey == $picKey){
                    $parts = parse_url($value["url"]);
                    $query = [];
                    parse_str($parts['query'], $query);
                    $vkey = $query['vkey'];
                    $picKey = $value["picKey"];
                    return "https://vwecam.tc.qq.com/{$picKey}.f20.mp4?vkey={$vkey}";
                }
            }
        }
    }

    static function g_tk($data) {  
        $t = 5381;  
        $chars = str_split($data);  
        for ($n = 0,$r = strlen($data); $n < $r; ++$n) {  
            $t += Video::intval32($t << 5) + ord($chars[$n]);  
        }  
        return $t & 2147483647;  
    }  
    static function intval32($num) {  
        $num = $num & 0xffffffff;  
        $p = $num>>31;  
        if($p==1) {  
            $num = $num-1;  
            $num = ~$num;  
            $num = $num & 0xffffffff;  
            return $num * -1;  
        } else {  
            return $num;  
        }  
    }

    public static function getSourceAF($url)
    {
        try {
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_connection, CURLOPT_HTTPHEADER, [
                'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.14; rv:76.0) Gecko/20100101 Firefox/76.0',
                'Host: www.agefans.tv',
                'Cookie: k2=5115835365976; t2=1588733938560; fa_t=1588733938597; fa_c=1; t1=1588734008072; k1=45717783;',
                'Referer: https://www.agefans.tv/play/20120070?playid=3_1'
            ]);
            $data = json_decode(curl_exec($curl_connection), true);
            curl_close($curl_connection);
            return urldecode($data['vurl']);

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getSourceIG($url)
    {
        try {
            $curl_connection = curl_init($url.'?__a=1');
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);

            $data = json_decode(curl_exec($curl_connection), true);
            curl_close($curl_connection);
            return $data['graphql']['shortcode_media']['video_url'];
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getMobileBB($url)
    {
        $avid = '';
        $bvid = '';
        $cid = '';
        if (strpos($url, "aid=") !== FALSE) { 
            $avid = Video::get_string_between($url, 'aid=', '&');
        }
        if (strpos($url, "bvid=") !== FALSE) { 
            $bvid = Video::get_string_between($url, 'bvid=', '&');
        }
        if (strpos($url, "cid=") !== FALSE) { 
            $cid = Video::get_string_between($url, 'cid=', '&');
        }
        $url = "https://api.bilibili.com/x/player/playurl?avid=".$avid."&bvid=".$bvid."&cid=".$cid."&qn=0&type=mp4&otype=json&fnver=0&fnval=1&platform=html5&html5=1&high_quality=1";

        try {
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_connection, CURLOPT_HTTPHEADER, [
                'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:56.0) Gecko/20100101 Firefox/56.0',
                'Host: api.bilibili.com',
                'Cookie: SESSDATA=33c1bfb1%2C1606096573%2C4f954*51;'
            ]);
            $data = json_decode(curl_exec($curl_connection), true);
            curl_close($curl_connection);

            if (array_key_exists('data', $data) && array_key_exists('durl', $data['data'])) {
                $durl = $data['data']['durl'][0];
                $url = $durl['url'];

                $start = strpos($url, 'http');
                $end = strpos($url, 'upgcxcode/');
                $url = substr_replace($url, 'https://cn-hk-eq-bcache-01.bilivideo.com/upgcxcode/', $start, $end - $start + 10);
                return $url;
            } else {
                return 'error';
            }
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public static function updateQQRawLink($video){
        if (substr($video->sd, 0, 5) === "1098_") {
            $video->sd = Video::getSourceQQ("https://quan.qq.com/video/".$video->sd);
            $video->save();
        }
        if (substr($video->sd, 0, 5) === "1006_" || substr($video->sd, 0, 5) === "1097_") {
            $video->sd = Video::getSourceQZ($video->sd);
            $video->save();
        }
    }

    public static function setAgefansLink($video){
        $requests = Browsershot::url($video->sd)
        ->useCookies(['username' => 'admin'])
        ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
        ->waitUntilNetworkIdle()
        ->triggeredRequests();

        foreach ($requests as $request) {
            if (strpos($request['url'], 'https://www.agefans.tv/age/player/') !== false && strpos($request['url'], 'https://gss3.baidu.com/') !== false) {
                $video->sd = $request['url'];

            } elseif (strpos($request['url'], 'https://www.agefans.tv/age/player/') === false && strpos($request['url'], '1098_') !== false) {
                $video->sd = 'https://www.agefans.tv/age/player/ckx1/?url='.urlencode($request['url']);

            } elseif (strpos($request['url'], 'https://www.agefans.tv/age/player/') !== false && strpos($request['url'], '1006_') !== false) {
                $url = '1006_'.Bot::get_string_between($request['url'], '1006_', '.f');
                $video->sd = 'https://www.agefans.tv/age/player/ckx1/?url='.urlencode(Video::getSourceQZ($url));

            } elseif (strpos($request['url'], 'https://www.agefans.tv/age/player/') !== false && strpos($request['url'], '1097_') !== false) {
                $url = '1097_'.Bot::get_string_between($request['url'], '1097_', '.f');
                $video->sd = 'https://www.agefans.tv/age/player/ckx1/?url='.urlencode(Video::getSourceQZ($url));

            } elseif (strpos($request['url'], 'https://www.agefans.tv/age/player/') !== false && strpos($request['url'], 'myqcloud') !== false) {
                $video->sd = $request['url'];
            }
        }

        $video->save();
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
}
