<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Watch;
use App\Subscribe;
use App\Comment;

class Video extends Model
{
	protected $fillable = [
        'id', 'user_id', 'playlist_id', 'title', 'caption', 'tags', 'sd', 'imgur', 'views', 'outsource', 'created_at', 'uploaded_at',
    ];

    public static $tags = [
        '正版動漫', '同人動畫', '動漫講評', '明星', '日本人氣YouTuber', '日本創意廣告', '日劇講評'
    ];

    public static $content = [
        'anime' => ['正版動漫', 'anime1', '同人動畫', '動漫講評', 'MAD·AMV'], 'aninews' => ['動漫資訊'], 'variety' => ['綜藝'], 'artist' => ['明星'], 'meme' => ['搞笑'], 'travel' => ['旅遊']
    ];

    public static $titles = [
        'anime' => '動畫卡通', 'aninews' => '動漫資訊', 'variety' => '綜藝頻道', 'artist' => '明星專區', 'meme' => '迷因翻譯', 'travel' => '日本旅遊'
    ];

    public static $tagsArray = [
        'anime' => ['正版動漫', 'anime1', '同人動畫', '動漫講評', 'MAD·AMV'], 'aninews' => ['正版動漫', 'anime1', '同人動畫', '動漫講評', 'MAD·AMV'], 'variety' => ['嵐Arashi', '貴婦松子Deluxe', 'Downtown', '倫敦靴子1號2號', '有吉弘行', 'RunningMan'], 'artist' => ['佐藤健', '石原聰美', '新垣結衣', '木村拓哉', '竹內涼真', '長澤雅美', '綾瀨遙', '劉在錫'], 'meme' => ['正版動漫', 'anime1', '同人動畫', '動漫講評', 'MAD·AMV'], 'travel' => ['正版動漫', 'anime1', '同人動畫', '動漫講評', 'MAD·AMV']
    ];

    public function user()
    {
        return User::find($this->user_id);
    }

    public function watch()
    {
        return Watch::find($this->playlist_id);
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
                    parse_str($parts['query'], $query);
                    $vkey = $query['vkey'];
                    $picKey = $value["picKey"];
                    return "https://apd-videohy.apdcdn.tc.qq.com/vwecam.tc.qq.com/{$picKey}.f0.mp4?vkey={$vkey}";
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

    static function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
