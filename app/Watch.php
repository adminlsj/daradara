<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Watch extends Model
{
	protected $fillable = [
        'genre', 'category', 'title', 'imgur',
    ];
}
