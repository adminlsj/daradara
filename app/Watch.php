<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Video;

class Watch extends Model
{
	protected $fillable = [
        'id', 'genre', 'category', 'season', 'title', 'description', 'imgur',
    ];

    public function videos()
    {
        return Video::where('category', $this->category)->where('season', $this->season)->orderBy('created_at', 'asc')->get();
    }

    public function titleToURL()
    {
    	$title = str_replace(" / ", "_", $this->title);
    	$title = str_replace(" ", "-", $title);
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
}
