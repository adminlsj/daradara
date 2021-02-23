<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Video;

class Reply extends Model
{
    protected $fillable = [
        'user_id', 'comment_id', 'text',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function comment()
    {
        return $this->belongsTo('App\Comment', 'comment_id');
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'foreign');
    }
}
