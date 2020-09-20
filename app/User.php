<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'tags', 'password', 'provider', 'provider_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tags()
    {
        $tags = $this->tags;
        if ($tags == '') {
            return [];
        } else {
            return explode(" ", $this->tags);
        }
    }

    public function recommendTags()
    {
        $tags = [];
        $subscribes = $this->subscribes();
        foreach ($subscribes as $subscribe) {
            if ($subscribe->type == 'watch' && $watch = $subscribe->watch()) {
                $videoTags = $watch->videos()->first()->tags;
                if (strpos($videoTags, '動漫') !== false && !in_array('動漫新番', $tags)) {
                    array_unshift($tags, '動漫新番');
                    if (!in_array('同人動畫', $tags)) {
                        array_push($tags, '同人動畫');
                    }
                    if (!in_array('原創動畫', $tags)) {
                        array_push($tags, '原創動畫');
                    }
                    if (!in_array('動漫講評', $tags)) {
                        array_push($tags, '動漫講評');
                    }
                    if (!in_array('MAD·AMV', $tags)) {
                        array_push($tags, 'MAD·AMV');
                    }
                }
                if (strpos($videoTags, '日劇') !== false && !in_array('日劇', $tags)) {
                    array_unshift($tags, '日劇');
                    if (!in_array('明星', $tags)) {
                        array_push($tags, '明星');
                    }
                    if (!in_array('日本人氣YouTuber', $tags)) {
                        array_push($tags, '日本人氣YouTuber');
                    }
                    if (!in_array('日劇講評', $tags)) {
                        array_push($tags, '日劇講評');
                    }
                }
                if (strpos($videoTags, '綜藝') !== false && !in_array('綜藝', $tags)) {
                    array_unshift($tags, '綜藝');
                    if (!in_array('明星', $tags)) {
                        array_push($tags, '明星');
                    }
                    if (!in_array('日本人氣YouTuber', $tags)) {
                        array_push($tags, '日本人氣YouTuber');
                    }
                    if (!in_array('日本創意廣告', $tags)) {
                        array_push($tags, '日本創意廣告');
                    }
                }
            } elseif ($subscribe->type == 'video') {
                if (!in_array($subscribe->tag, $tags)) {
                    array_push($tags, $subscribe->tag);
                }
            }
        }

        if (!in_array('日劇', $tags)) {
            array_push($tags, '日劇');
        }
        if (!in_array('綜藝', $tags)) {
            array_push($tags, '綜藝');
        }
        if (!in_array('動漫新番', $tags)) {
            array_push($tags, '動漫');
        }

        return $tags;
    }

    public function watches()
    {
        return Watch::where('user_id', $this->id)->orderBy('updated_at', 'desc')->get();
    }

    /* public function videos()
    {
        return Video::where('user_id', $this->id)->orderBy('uploaded_at', 'desc')->get();
    } */

    public function videos()
    {
        return $this->hasMany('App\Video');
    }

    public function saves()
    {
        return $this->hasMany('App\Save');
    }

    public function blogs()
    {
        return $this->hasMany('App\Blog');
    }

    public function subscribes()
    {
        return Subscribe::where('user_id', $this->id)->orderBy('created_at', 'desc')->get();
    }

    public function subscribers()
    {
        $watches = $this->watches();
        $subscribers = 0;
        if ($watches->first()) {
            foreach ($watches as $watch) {
                $subscribers = $subscribers + Subscribe::where('tag', $watch->title)->count();
            }
        }
        return $subscribers;
    }

    public function avatar()
    {
        return $this->hasOne('App\Avatar');
    }

    public function avatarDefault()
    {
        return "https://i.imgur.com/KqDtqhMb.jpg";
    }

    public function avatarCircleB()
    {
        return "https://i.imgur.com/sMSpYFXb.jpg";
    }
}
