<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $casts = [
        'sources' => 'array'
    ];

    protected $fillable = [
        'id', 'name_zht', 'name_zhs', 'name_jp', 'name_en', 'started_at', 'ended_at', 'description', 'website', 'location', 'photo_cover', 'sources', 'created_at', 'updated_at'
    ];

    public function animes()
    {
        return $this->morphToMany('App\Anime', 'animeable');
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