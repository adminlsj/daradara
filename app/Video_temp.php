<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video_temp extends Model
{
    protected $casts = [
        'data' => 'array', 'translations' => 'array'
    ];

    protected $fillable = [
        'id', 'route', 'name', 'video_id', 'user_id', 'title', 'translations', 'caption', 'cover', 'imgur', 'thumbL', 'thumbH', 'views', 'duration', 'data'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function thumbL()
    {
        return $this->thumbL;
    }

    public function thumbH()
    {
        return $this->thumbH;
    }

    public function views()
    {
        return $this->views;
    }
}
