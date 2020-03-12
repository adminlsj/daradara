<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Video;

class Comment extends Model
{
    protected $fillable = [
        'user_id', 'type', 'foreign_id', 'text',
    ];

    public function user()
    {
        return User::find($this->user_id);
    }

    public function video()
    {
        return Video::find($this->foreign_id);
    }
}
