<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $casts = [
        'nicknames' => 'array', 'sources' => 'array'
    ];

    protected $fillable = [
        'id', 'name_zht', 'name_zhs', 'name_jp', 'name_en', 'nicknames', 'birthday', 'gender', 'hometown', 'blood_type', 'height', 'links', 'sources', 'language', 'photo_cover', 'created_at', 'updated_at'
    ];

    public function animes()
    {
        return $this->belongsToMany('App\Anime', 'actor_anime_character', 'actor_id', 'anime_id');
    }

    public function characters()
    {
        return $this->belongsToMany('App\Character', 'actor_anime_character', 'actor_id', 'character_id');
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }
}