<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // protected $with = ['user']; 

    protected $fillable = [
        'id', 'user_id', 'commentable_id', 'commentable_type', 'body', 'created_at', 'updated_at'
    ];

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function replies()
    {
        return $this->hasMany('App\Reply');
    }
}