<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnimeRelation extends Model
{
    protected $fillable = [
        'id', 'anime_id', 'animeable_id', 'animeable_type', 'relation', 'created_at', 'updated_at'
    ];
}