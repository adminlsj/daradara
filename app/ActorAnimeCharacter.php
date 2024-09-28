<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ActorAnimeCharacter extends Pivot
{
    protected $fillable = [
        'id', 'anime_id', 'character_id', 'actor_id', 'role', 'created_at', 'updated_at'
    ];
}