<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider', 'provider_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function watches()
    {
        return Watch::where('user_id', $this->id)->orderBy('created_at', 'desc')->get();
    }

    public function subscribes()
    {
        return Subscribe::where('user_id', $this->id)->orderBy('created_at', 'desc')->get();
    }

    public function avatar()
    {
        return $this->hasOne('App\Avatar');
    }

    public function avatarDefault()
    {
        return "https://i.imgur.com/KqDtqhMb.jpg";
    }

    public function avatarCircleB()
    {
        return "https://i.imgur.com/sMSpYFXb.jpg";
    }

    public function shops()
    {
        return $this->hasMany('App\Shop');
    }

    public function resume()
    {
        return $this->hasOne('App\Resume');
    }

    public function savedJobs()
    {
        return $this->hasMany('App\SavedJob');
    }

    public function jobs()
    {
        return $this->hasManyThrough('App\Job', 'App\SavedJob');
    }
}
