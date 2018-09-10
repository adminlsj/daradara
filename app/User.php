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

    public function avatar()
    {
        return $this->hasOne('App\Avatar');
    }

    public function apps()
    {
        return $this->hasMany('App\App');
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
