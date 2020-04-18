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
        'id', 'user_id', 'playlist_id', 'title', 'caption', 'genre', 'category', 'season', 'tags', 'hd', 'sd', 'imgur', 'views', 'duration', 'outsource', 'created_at', 'uploaded_at',
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
        if (strpos($sd, 'player.bilibili.com') !== false) {
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

    public function hd()
    {
        return explode(" ",$this->sd);
    }

    public static function getMobileBB($url)
    {
        $avid = '';
        $bvid = '';
        $cid = '';
        if (strpos($url, "aid=") !== FALSE) { 
            $avid = Method::get_string_between($url, 'aid=', '&');
        }
        if (strpos($url, "bvid=") !== FALSE) { 
            $bvid = Method::get_string_between($url, 'bvid=', '&');
        }
        if (strpos($url, "cid=") !== FALSE) { 
            $cid = Method::get_string_between($url, 'cid=', '&');
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
    }
}
