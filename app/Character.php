<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $casts = [
        'nickname' => 'array'
    ];

    protected $fillable = [
        'id', 'created_at', 'updated_at', 'photo_cover', 'name_zht', 'name_zhs', 'name_jp', 'name_en', 'birthday', 'gender', 'description'
    ];

    public function animes()
    {
        return $this->belongsToMany('App\Anime')->using('App\AnimeCharacter');
    }
}