<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Video;
use App\Subscribe;

class Watch extends Model
{
	protected $fillable = [
        'id', 'user_id', 'title', 'description'
    ];

    public function user()
    {
        return User::find($this->user_id);
    }

    /* public function videos()
    {
        return Video::where('playlist_id', $this->id)->orderBy('created_at', 'desc')->get();
    } */

    public function videos()
    {
        return $this->hasMany('App\Video', 'playlist_id');
    }

    public function subscribes()
    {
        return Subscribe::where('tag', $this->title)->orderBy('created_at', 'asc')->get();
    }

    public function titleToURL()
    {
    	$title = str_replace(" / ", "_", $this->title);
    	$title = str_replace(" ", "-", $title);
    	return $title;
    }

    public function imgurDefault()
    {
        switch ($this->genre) {
            case 'variety':
                return "https://i.imgur.com/sMSpYFXl.jpg";
                break;

            case 'drama':
                return "https://i.imgur.com/v2CKkxbl.jpg";
                break;

            case 'anime':
                return "https://i.imgur.com/z060y3yl.jpg";
                break;
            
            default:
                return "https://i.imgur.com/sMSpYFXl.jpg";
                break;
        }
    }

    public function imgurDefaultIntro()
    {
        switch ($this->genre) {
            case 'variety':
                return "https://i.imgur.com/sMSpYFXh.jpg";
                break;

            case 'drama':
                return "https://i.imgur.com/v2CKkxbh.jpg";
                break;

            case 'anime':
                return "https://i.imgur.com/z060y3yh.jpg";
                break;
            
            default:
                return "https://i.imgur.com/sMSpYFXh.jpg";
                break;
        }
    }

    public function imgurDefaultCircleB()
    {
        return "https://i.imgur.com/sMSpYFXb.jpg";
    }

    public function imgur16by9()
    {
        return "https://i.imgur.com/JMcgEkPl.jpg";
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

    public function scopeWithVideos($query)
    {
        return $query->with(['videos' => function ($query) {
            $query->orderBy('created_at', 'desc')->select('id', 'playlist_id', 'title', 'imgur');
        }]);
    }
}
