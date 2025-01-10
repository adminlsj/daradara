<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AnimeCharacterRole extends Pivot
{
    protected $table = 'anime_character_roles';

    protected $fillable = [
        'id', 'anime_id', 'character_id', 'staff_id', 'role', 'created_at', 'updated_at'
    ];
}