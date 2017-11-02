<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogImg extends Model
{
	protected $fillable = [
        'blog_id', 'filename', 'mime', 'original_filename',
    ];

    public function blog()
    {
        return $this->belongsTo('App\Blog');
    }
}
