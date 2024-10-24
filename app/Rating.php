<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    // protected $with = ['user']; 

    protected $fillable = [
        'id', 'user_id', 'rateable_id', 'rateable_type', 'score', 'created_at', 'updated_at'
    ];

    public function rateable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}