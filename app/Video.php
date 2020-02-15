<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Watch;

class Video extends Model
{
	protected $fillable = [
        'id', 'title', 'caption', 'genre', 'category', 'season', 'tags', 'hd', 'sd', 'imgur', 'views', 'duration', 'outsource', 'created_at',
    ];

    public function watch()
    {
        return Watch::where('category', $this->category)->first();
    }

    public function tags()
    {
        return explode(" ", $this->tags);
    }

    public function title()
    {
        $title = $this->title;
        if ($this->genre == 'drama' || $this->genre == 'anime') {
            $start = strpos($title, "【");
            $end = strpos($title, "】") - $start;
            return str_replace("【", "", substr($title, $start, $end));
        } else {
            return $title;
        }
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

    public function views()
    {
        if ($this->views >= 10000) {
            return ceil($this->views / 10000).'萬';
        } else {
            return $this->views;
        }
    }

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

    public function imgur16by9()
    {
        return "https://i.imgur.com/JMcgEkPm.jpg";
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
        if (strpos($sd, 'https://www.instagram.com/p/') !== false) {
            return Video::getSourceIG($sd);
        } elseif (strpos($sd, 'https://api.bilibili.com/') !== false) {
            return Video::getSourceBB($sd);
        } else {
            return $sd;
        }
    }

    public function sd()
    {
        return explode(" ",$this->sd);
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

    public static function getSourceBB($url)
    {
        try {
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_connection, CURLOPT_HTTPHEADER, [
                'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:56.0) Gecko/20100101 Firefox/56.0',
                'Host: 127.0.0.1:8000',
                'Cookie: SESSDATA=1feadc09%2C1582358038%2Ca8f2f511;',
                'X_FORWARDED_FOR: 128.1.62.197:80',
                'REMOTE_ADDR: 128.1.62.197:80'
            ]);
            $data = json_decode(curl_exec($curl_connection), true);
            curl_close($curl_connection);

            $durl = $data['data']['durl'][0];
            $url = $durl['url'];
            if ($durl['backup_url'] != null && strpos($durl['backup_url'][0], 'upos-hz-mirrorakam') !== false) {
                $url = $durl['backup_url'][0];
            }

            return str_replace("http://", "https://", $url);
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    /* public function getRouteKeyName()
	{
	    return 'title';
	} */
}
