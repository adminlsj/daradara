<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Subscribe extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'artist_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function subscriber()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function artist()
    {
        return $this->belongsTo('App\User', 'artist_id');
    }
}