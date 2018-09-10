<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    protected $fillable = [
        'user_id', 'name', 'title', 'email',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function resumeImg()
    {
        return $this->hasOne('App\ResumeImg');
    }
}
