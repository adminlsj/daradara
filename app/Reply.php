<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    // protected $with = ['user']; 

    protected $fillable = [
        'id', 'user_id', 'comment_id', 'body', 'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comment()
    {
        return $this->belongsTo('App\Comment');
    }
}