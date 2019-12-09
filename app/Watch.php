<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Watch extends Model
{
	protected $fillable = [
        'id', 'genre', 'category', 'title', 'description', 'imgur',
    ];
}
