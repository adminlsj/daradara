<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comic extends Model
{
    protected $casts = [
        'parodies' => 'array', 'characters' => 'array', 'tags' => 'array', 'artists' => 'array', 'groups' => 'array', 'languages' => 'array', 'categories' => 'array', 'images' => 'array', 'imgurs' => 'array'
    ];

    protected $guarded = [];
}
