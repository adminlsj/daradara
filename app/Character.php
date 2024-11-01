<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $casts = [
        'nickname' => 'array', 'sources' => 'array'
    ];

    protected $fillable = [
        'id', 'created_at', 'updated_at', 'photo_cover', 'name_zht', 'name_zhs', 'name_jp', 'name_en', 'birthday', 'gender', 'description', 'role', 'sources'
    ];

    public function animes()
    {
        return $this->belongsToMany('App\Anime', 'anime_character_roles', 'character_id', 'anime_id');
    }

    public function actors()
    {
        return $this->belongsToMany('App\Staff', 'anime_character_roles', 'character_id', 'staff_id');
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