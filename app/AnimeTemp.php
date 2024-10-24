<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnimeTemp extends Model
{
    protected $casts = [
        'sources' => 'array', 'genres' => 'array', 'tags' => 'array'
    ];

    protected $fillable = [
        'id', 'title_ch', 'title_jp', 'title_ro', 'title_en', 'photo_cover', 'photo_banner', 'description', 'rating_mal', 'rating_al', 'rating', 'started_at', 'ended_at', 'author', 'director', 'trailer', 'created_at', 'updated_at', 'episodes', 'sources', 'genres', 'tags', 'airing_status', 'animation_studio', 'category', 'episodes_length', 'source', 'started_at_show', 'rating_bangumi', 'rating_bangumi_count'
    ];
}