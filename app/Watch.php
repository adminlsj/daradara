<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Watch extends Model
{
	protected $fillable = [
        'id', 'genre', 'category', 'title', 'description', 'imgur',
    ];

    public function titleToURL()
    {
    	return str_replace("/", "_", $this->title);
    }
}
