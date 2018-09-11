<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    protected $fillable = [
        'user_id', 'name', 'title', 'email', 'phone', 'location', 'wechat', 'qq', 'edu_title', 'edu_gpa', 'edu_university', 'edu_start', 'edu_end', 'work_title', 'work_company', 'work_start', 'work_end', 'work_description', 'other_description',
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
