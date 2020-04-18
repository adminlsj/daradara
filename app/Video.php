<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
<<<<<<< HEAD
use App\Watch;
=======
use App\Playlist;
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
use App\Subscribe;
use App\Comment;

class Video extends Model
{
	protected $fillable = [
<<<<<<< HEAD
        'id', 'user_id', 'playlist_id', 'title', 'caption', 'genre', 'category', 'season', 'tags', 'hd', 'sd', 'imgur', 'views', 'duration', 'outsource', 'created_at', 'uploaded_at',
=======
        'id', 'user_id', 'playlist_id', 'title', 'description', 'tags', 'link', 'imgur', 'views', 'outsource', 'created_at', 'uploaded_at',
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
    ];

    public function user()
    {
        return User::find($this->user_id);
    }

<<<<<<< HEAD
    public function watch()
    {
        return Watch::find($this->playlist_id);
=======
    public function playlist()
    {
        return Playlist::find($this->playlist_id);
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
    }

    public function subscribes()
    {
<<<<<<< HEAD
        return Subscribe::where('tag', $this->watch()->title)->orderBy('created_at', 'asc')->get();
=======
        return Subscribe::where('tag', $this->playlist()->title)->orderBy('created_at', 'asc')->get();
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
    }

    public function comments()
    {
        return Comment::where('type', 'video')->where('foreign_id', $this->id)->orderBy('created_at', 'desc')->get();
    }

    public function tags()
    {
        return explode(" ", $this->tags);
    }

<<<<<<< HEAD
=======
    public function title()
    {
        $title = $this->title;
        return $title;
    }

    public function genre()
    {
        switch ($this->genre) {
            case 'variety':
                return '綜藝';
                break;

            case 'drama':
                return '日劇';
                break;

            case 'anime':
                return '動漫';
                break;
            
            default:
                return '綜藝';
                break;
        }
    }

>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
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

<<<<<<< HEAD
=======
    public function duration()
    {
        $min = (int) floor($this->duration / 60);
        $sec = (int) round($this->duration % 60);
        if ($sec == 0) {
            $sec = '00';
        } elseif ($sec < 10) {
            $sec = '0'.$sec;
        }
        return $min.':'.$sec;
    }

    public function durationData()
    {
        $hour = (int) floor(($this->duration / 60) / 60);
        $min = (int) floor($this->duration / 60);
        $sec = (int) round($this->duration % 60);

        if ($hour == 0) {
            $hour = '00';
        }

        if ($min >= 60) {
            $min = (int) round($min % 60);
        }
        if ($min == 0) {
            $min = '00';
        }

        if ($sec == 0) {
            $sec = '00';
        }

        return 'T'.$hour.'H'.$min.'M'.$sec.'S';
    }

>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
    public function imgur16by9()
    {
        return "https://i.imgur.com/JMcgEkPl.jpg";
    }

    public function imgurDefaultCircleB()
    {
        return "https://i.imgur.com/sMSpYFXb.jpg";
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
<<<<<<< HEAD
        $sd = $this->sd()[0];
        if (strpos($sd, 'player.bilibili.com') !== false) {
            return Video::getMobileBB($sd);
        } else {
            return $sd;
=======
        $link = $this->link()[0];
        if (strpos($link, 'player.bilibili.com') !== false) {
            return Video::getMobileBB($link);
        } else {
            return $link;
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
        }
    }

    public function outsource()
    {
<<<<<<< HEAD
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

    public function hd()
    {
        return explode(" ",$this->sd);
=======
        $link = $this->link()[0];
        if (strpos($link, '?') !== false) {
            return $link.'&danmaku=0&qn=0&type=mp4&otype=json&fnver=0&fnval=1&platform=html5&html5=1&high_quality=1&autoplay=1';
        } else {
            return $link.'?danmaku=0&qn=0&type=mp4&otype=json&fnver=0&fnval=1&platform=html5&html5=1&high_quality=1&autoplay=1';;
        }
    }

    public function link()
    {
        return explode(" ",$this->link);
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
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
    }

    public static function getMobileBB($url)
    {
        $avid = '';
        $bvid = '';
        $cid = '';
        if (strpos($url, "aid=") !== FALSE) { 
<<<<<<< HEAD
            $avid = Method::get_string_between($url, 'aid=', '&');
        }
        if (strpos($url, "bvid=") !== FALSE) { 
            $bvid = Method::get_string_between($url, 'bvid=', '&');
        }
        if (strpos($url, "cid=") !== FALSE) { 
            $cid = Method::get_string_between($url, 'cid=', '&');
=======
            $avid = Video::get_string_between($url, 'aid=', '&');
        }
        if (strpos($url, "bvid=") !== FALSE) { 
            $bvid = Video::get_string_between($url, 'bvid=', '&');
        }
        if (strpos($url, "cid=") !== FALSE) { 
            $cid = Video::get_string_between($url, 'cid=', '&');
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
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
                'Cookie: SESSDATA=1feadc09%2C1582358038%2Ca8f2f511;'
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

<<<<<<< HEAD
    public function scopeOne($query)
    {
        return $query->where('id', 1841);
    }

    public function scopeTwo($query)
    {
        return $query->where('id', 14);
    }

    public function scopeThree($query)
    {
        return $query->where('id', 3841);
=======
    public static function getSourceBB($url)
    {
        try {
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_connection, CURLOPT_HTTPHEADER, [
                'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:56.0) Gecko/20100101 Firefox/56.0',
                'Host: api.bilibili.com',
                'Cookie: SESSDATA=1feadc09%2C1582358038%2Ca8f2f511;'
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

    public static function getLinkBB(String $url, Bool $outsource)
    {
        if (strpos($url, "www.bilibili.com") !== FALSE && !$outsource) {
            $page = 1;
            if (($pos = strpos($url, "?p=")) !== FALSE) { 
                $page = substr($url, $pos + 3);
                $url = str_replace("?p=".$page, "", $url);
            }
            if (($pos = strpos($url, "BV")) !== FALSE) { 
                $bvid = substr($url, $pos); 
            }
            try {
                $curl_connection = curl_init("https://api.bilibili.com/x/web-interface/view?bvid=".$bvid);
                curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
                $data = json_decode(curl_exec($curl_connection), true);
                $aid = $data['data']['stat']['aid'];
                $cid = $data['data']['pages'][$page - 1]["cid"];
                curl_close($curl_connection);

                return "https://api.bilibili.com/x/player/playurl?avid=".$aid."&bvid=".$bvid."&cid=".$cid."&qn=0&type=mp4&otype=json&fnver=0&fnval=1&platform=html5&html5=1&high_quality=1";

            } catch(Exception $e) {
                return $e->getMessage();
            }
        } else {
            return $url;
        }
    }

    static function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
    }
}
