<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnimeRole extends Model
{
    protected $fillable = [
        'id', 'anime_id', 'animeable_id', 'animeable_type', 'role', 'created_at', 'updated_at'
    ];
}