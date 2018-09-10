<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResumeImg extends Model
{
    protected $fillable = [
        'resume_id', 'filename', 'mime', 'original_filename',
    ];

    public function resume()
    {
        return $this->belongsTo('App\Resume');
    }
}
