<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    protected $casts = [
        'sources' => 'array'
    ];

    protected $fillable = [
        'id', 'title_ch', 'title_jp', 'title_ro', 'title_en', 'photo_cover', 'photo_banner', 'description', 'rating_mal', 'rating_al', 'rating', 'started_at', 'ended_at', 'author', 'director', 'trailer', 'created_at', 'updated_at', 'episodes', 'sources'
    ];
}