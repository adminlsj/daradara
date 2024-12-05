<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SteelyWing\Chinese\Chinese;

class Anime extends Model
{
    protected $casts = [
        'sources' => 'array', 'genres' => 'array', 'tags' => 'array'
    ];

    protected $fillable = [
        'id', 'title_ch', 'title_jp', 'title_ro', 'title_en', 'photo_cover', 'photo_banner', 'description', 'rating_mal', 'rating_al', 'rating', 'started_at', 'ended_at', 'author', 'director', 'trailer', 'created_at', 'updated_at', 'episodes_count', 'sources', 'genres', 'tags', 'airing_status', 'animation_studio', 'category', 'episodes_length', 'source', 'started_at_show', 'rating_bangumi', 'rating_bangumi_count', 'is_adult'
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
        return $this->belongsToMany('App\Character', 'anime_character_roles', 'anime_id', 'character_id')->withPivot('role');
    }

    public function companies()
    {
        return $this->morphedByMany('App\Company', 'animeable', 'anime_roles')->withPivot('role');
    }

    public function studios()
    {
        return $this->morphedByMany('App\Company', 'animeable', 'anime_roles')->withPivot('role')->where('role', 'Studio');
    }

    public function producers()
    {
        return $this->morphedByMany('App\Company', 'animeable', 'anime_roles')->withPivot('role')->where('role', 'Producers');
    }

    public function staffs()
    {
        return $this->morphedByMany('App\Staff', 'animeable', 'anime_roles')->withPivot('role');
    }

    public function related_animes()
    {
        return $this->morphedByMany('App\Anime', 'animeable', 'anime_relations')->withPivot('relation');
    }

    public function episodes()
    {
        return $this->hasMany('App\Episode');
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

    public function getTitle($chinese)
    {
        return $chinese->to(Chinese::ZH_HANT, ($this->title_zht ? $this->title_zht : ($this->title_zhs ? $this->title_zhs : ($this->title_jp ? $this->title_jp : $this->title_en))));
    }

    public function getRelation($relation)
    {
        $relation = str_replace(' (TV)', '', $relation);
        $relation = str_replace(' (ONA)', '', $relation);
        $relation = str_replace(' (Movie)', '', $relation);
        $relation = str_replace(' (Unknown)', '', $relation);
        $relation = str_replace(' (Music)', '', $relation);
        $relation = str_replace(' (OVA)', '', $relation);
        $relation = str_replace(' (TV Special)', '', $relation);
        $relation = str_replace(' (CM)', '', $relation);
        $relation = str_replace(' (PV)', '', $relation);
        $relation = str_replace(' (Special)', '', $relation);
        return $relation;
    }
}