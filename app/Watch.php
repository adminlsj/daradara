<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Video;

class Watch extends Model
{
	protected $fillable = [
        'id', 'genre', 'category', 'title', 'description', 'imgur',
    ];

    public function videos()
    {
        return Video::where('category', $this->category)->orderBy('created_at', 'asc')->get();
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
                return "https://i.imgur.com/sMSpYFXm.jpg";
                break;

            case 'drama':
                return "https://i.imgur.com/v2CKkxbm.jpg";
                break;

            case 'anime':
                return "https://i.imgur.com/z060y3ym.jpg";
                break;
            
            default:
                return "https://i.imgur.com/sMSpYFXm.jpg";
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
