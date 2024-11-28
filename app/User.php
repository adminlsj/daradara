<?php

namespace App;

use App\AnimeSave;
use App\Savelist;
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
        'name', 'email', 'tags', 'password', 'provider', 'provider_id', 'avatar_temp', 'is_artist'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function anime_lists()
    {
        return $this->hasMany('App\Savelist')->where('type', 'anime')->where('is_status', false);
    }

    public function anime_statuslist($status)
    {
        return Savelist::where('user_id', $this->id)->where('is_status', true)->where('type', 'anime')->where('title', $status)->first();
    }

    public function anime_statuslists()
    {
        return $this->hasMany('App\Savelist')->where('type', 'anime')->where('is_status', true);
    }

    public function anime_save($anime_id)
    {
        return AnimeSave::where('user_id', $this->id)->where('anime_id', $anime_id)->first();
    }

    public function scopeWhereHasTags($query, $tags, $count)
    {
        return $query->where(function($query) use ($tags) {
            foreach ($tags as $tag) {
                $query->orWhere('tags_array', 'ilike', '%"'.$tag.'"%');
            }
        })->where('uncover', false)
          ->select('id', 'title', 'cover')      
          ->inRandomOrder()
          ->limit($count);
    }

    public function avatarDefault()
    {
        return "https://vdownload.hembed.com/image/icon/user_default_image.jpg?secure=ue9M119kdZxHcZqDPrunLQ==,4855471320";
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
