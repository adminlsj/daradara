<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Watch;

class Subscribe extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'playlist_id', 'tag',
    ];

    public function user()
    {
        return User::find($this->user_id);
    }

    public function watch()
    {
        return Watch::where('title', $this->tag)->first();
    }
}
