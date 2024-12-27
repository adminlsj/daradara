<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SteelyWing\Chinese\Chinese;

class Character extends Model
{
    protected $casts = [
        'nickname' => 'array', 'sources' => 'array', 'birthday' => 'datetime'
    ];

    protected $fillable = [
        'id', 'created_at', 'updated_at', 'photo_cover', 'name_zht', 'name_zhs', 'name_jp', 'name_en', 'birthday', 'gender', 'description', 'role', 'sources', 'weight', 'blood_type'
    ];

    public function animes($role)
    {
        switch ($role) {
            case 'actor':
                return $this->belongsToMany('App\Anime', 'anime_character_roles', 'character_id', 'anime_id');
                break;

            case 'staff':
                return $this->morphToMany('App\Anime', 'animeable', 'anime_roles')->withPivot('role');
                break;
        }
    }

    public function actors()
    {
        return $this->belongsToMany('App\Staff', 'anime_character_roles', 'character_id', 'staff_id');
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function getName($chinese)
    {
        return str_replace('/', ' ', $chinese->to(Chinese::ZH_HANT, ($this->name_zht ? $this->name_zht : ($this->name_zhs ? $this->name_zhs : ($this->name_jp ? $this->name_jp : $this->name_en)))));
    }
}