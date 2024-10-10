<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    // protected $with = ['user']; 

    protected $fillable = [
        'id', 'user_id', 'likeable_id', 'likeable_type', 'created_at', 'updated_at'
    ];

    public function likeable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}