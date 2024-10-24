<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    protected $casts = [
        'sources' => 'array', 'genres' => 'array', 'tags' => 'array'
    ];

    protected $fillable = [
        'id', 'title_ch', 'title_jp', 'title_ro', 'title_en', 'photo_cover', 'photo_banner', 'description', 'rating_mal', 'rating_al', 'rating', 'started_at', 'ended_at', 'author', 'director', 'trailer', 'created_at', 'updated_at', 'episodes', 'sources', 'genres', 'tags', 'airing_status', 'animation_studio', 'category', 'episodes_length', 'source', 'started_at_show', 'rating_bangumi', 'rating_bangumi_count'
    ];

    public static function import($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public function characters()
    {
        return $this->belongsToMany('App\Character', 'actor_anime_character', 'anime_id', 'character_id')->withPivot('role');
    }

    public function companies()
    {
        return $this->morphedByMany('App\Company', 'animeable')->withPivot('role');
    }

    public function staffs()
    {
        return $this->morphedByMany('App\Staff', 'animeable')->withPivot('role');
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function ratings()
    {
        return $this->morphMany('App\Rating', 'rateable');
    }
}