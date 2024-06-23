<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episodes extends Model
{
    protected $fillable = [
        'id', 'anime_id', 'created_at', 'updated_at', 'episodes_thumbnail', 'title_zht', 'title_zhs', 'title_jp', 'released_at'
    ];
}