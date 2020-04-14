<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Playlist;

class Subscribe extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'type', 'tag',
    ];

    public function user()
    {
        return User::find($this->user_id);
    }

    public function playlist()
    {
        return Playlist::where('title', $this->tag)->first();
    }
}
