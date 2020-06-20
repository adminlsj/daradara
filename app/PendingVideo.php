<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PendingVideo extends Model
{
    protected $casts = [
        'foreign_sd' => 'array'
    ];

	protected $fillable = [
        'id', 'user_id', 'playlist_id', 'title', 'caption', 'tags', 'sd', 'imgur', 'views', 'outsource', 'foreign_sd', 'created_at', 'uploaded_at',
    ];
}
