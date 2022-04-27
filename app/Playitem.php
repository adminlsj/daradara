<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playitem extends Model
{
    protected $fillable = [
        'id', 'user_id', 'playlist_id', 'video_id',
    ];

    public function playlist()
    {
        return $this->belongsTo('App\Playlist', 'playlist_id');
    }

    public function video()
    {
        return $this->belongsTo('App\Video', 'video_id');
    }
}
