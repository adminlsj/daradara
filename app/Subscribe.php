<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
<<<<<<< HEAD
use App\Watch;
=======
use App\Playlist;
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c

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

<<<<<<< HEAD
    public function watch()
    {
        return Watch::where('title', $this->tag)->first();
=======
    public function playlist()
    {
        return Playlist::where('title', $this->tag)->first();
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
    }
}
