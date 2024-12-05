<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SteelyWing\Chinese\Chinese;

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

    public function getName($chinese)
    {
        return $chinese->to(Chinese::ZH_HANT, ($this->name_zht ? $this->name_zht : ($this->name_zhs ? $this->name_zhs : ($this->name_jp ? $this->name_jp : $this->name_en))));
    }
}