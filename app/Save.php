<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Video;

class Save extends Model
{
    protected $fillable = [
        'id', 'user_id', 'video_id',
    ];

    public function video()
    {
        return $this->belongsTo('App\Video', 'video_id');
    }
}
