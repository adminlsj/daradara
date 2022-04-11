<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Video;
use App\Preview;

class Comment extends Model
{
    protected $fillable = [
        'user_id', 'type', 'foreign_id', 'text',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function video()
    {
        return $this->belongsTo('App\Video', 'foreign_id');
    }

    public function preview()
    {
        return $this->belongsTo('App\Preview', 'foreign_id');
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'foreign');
    }

    public function replies()
    {
        return $this->hasMany('App\Reply');
    }
}
