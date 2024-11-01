<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staffs';

    protected $casts = [
        'nicknames' => 'array', 'sources' => 'array'
    ];

    protected $fillable = [
        'id', 'name_zht', 'name_zhs', 'name_jp', 'name_en', 'nicknames', 'birthday', 'gender', 'hometown', 'blood_type', 'height', 'description', 'sources', 'photo_cover', 'created_at', 'updated_at'
    ];

    public function animes()
    {
        return $this->morphToMany('App\Anime', 'anime_roles');
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