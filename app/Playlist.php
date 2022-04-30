<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;
    
    protected $fillable = [
        'id', 'user_id', 'reference_id', 'reference_user_id', 'title', 'description', 'is_private',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function user_ref()
    {
        return $this->belongsTo('App\User', 'reference_user_id');
    }

    public function videos()
    {
        return $this->hasManyThrough(
            'App\Video',
            'App\Playitem',
            'playlist_id', // Foreign key on Playitem table...
            'id', // Foreign key on Videos table...
            'id', // Local key on Playlist table...
            'video_id' // Local key on Playitem table...
        );
    }

    public function videos_ref()
    {
        return $this->hasManyThrough(
            'App\Video',
            'App\Playitem',
            'playlist_id', // Foreign key on Playitem table...
            'id', // Foreign key on Videos table...
            'reference_id', // Local key on Playlist table...
            'video_id' // Local key on Playitem table...
        );
    }

    public function playlist_ref()
    {
        return $this->belongsTo('App\Playlist', 'reference_id');
    }
}
