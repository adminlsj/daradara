<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    // protected $with = ['user']; 

    protected $fillable = [
        'id', 'user_id', 'likeable_id', 'likeable_type', 'is_positive', 'created_at', 'updated_at'
    ];

    public function likeable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function anime()
    {
        return $this->belongsTo('App\Anime', 'likeable_id');
    }

    public function character()
    {
        return $this->belongsTo('App\Character', 'likeable_id');
    }

    public function staff()
    {
        return $this->belongsTo('App\Staff', 'likeable_id');
    }

    public function company()
    {
        return $this->belongsTo('App\Company', 'likeable_id');
    }
}