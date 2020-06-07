<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
	protected $fillable = [
        'id', 'user_id', 'title', 'caption', 'tags', 'imgur', 'views', 'created_at',
    ];

    public static $content = [
        'aninews' => ['動漫情報'], 'daily' => ['生活']
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function tags()
    {
        return explode(" ", $this->tags);
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

    public function scopeTagsWithLimit($query, $tags, $count = 8)
    {
        return $query->with('user:id,name')->where(function($query) use ($tags) {
            foreach ($tags as $tag) {
                $query->orWhere('tags', 'like', '%'.$tag.'%');
            }
        })->orderBy('created_at', 'desc')->limit($count)->select('id', 'user_id', 'imgur', 'title');
    }

    public function scopeTagsWithPaginate($query, $tags)
    {
        return $query->with('user:id,name')->where(function($query) use ($tags) {
            foreach ($tags as $tag) {
                $query->orWhere('tags', 'like', '%'.$tag.'%');
            }
        })->select('id', 'user_id', 'imgur', 'title');
    }
}
