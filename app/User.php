<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\CustomResetPassword;

class User extends Authenticatable
{
    use Notifiable;

    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'tags', 'password', 'provider', 'provider_id', 'avatar_temp'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tags()
    {
        $tags = $this->tags;
        if ($tags == '') {
            return [];
        } else {
            return explode(" ", $this->tags);
        }
    }

    public function watches()
    {
        return $this->hasMany('App\Watch');
    }

    public function videos()
    {
        return $this->hasMany('App\Video');
    }

    public function saves()
    {
        return $this->hasMany('App\Save');
    }

    public function blogs()
    {
        return $this->hasMany('App\Blog');
    }

    public function subscribes()
    {
        return Subscribe::where('user_id', $this->id)->orderBy('created_at', 'desc')->get();
    }

    public function subscribers()
    {
        $watches = $this->watches();
        $subscribers = 0;
        if ($watches->first()) {
            foreach ($watches as $watch) {
                $subscribers = $subscribers + Subscribe::where('tag', $watch->title)->count();
            }
        }
        return $subscribers;
    }

    public function avatar()
    {
        return $this->hasOne('App\Avatar');
    }

    public function avatarDefault()
    {
        return "https://i.imgur.com/JaBN4ZNb.jpg";
    }

    public function avatarCircleB()
    {
        return "https://i.imgur.com/kPtd8Lpb.jpg";
    }

    /**
     * Send a password reset email to the user
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }
}
