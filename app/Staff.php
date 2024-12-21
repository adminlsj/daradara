<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SteelyWing\Chinese\Chinese;

class Staff extends Model
{
    protected $table = 'staffs';

    protected $casts = [
        'nicknames' => 'array', 'sources' => 'array', 'birthday' => 'datetime'
    ];

    protected $fillable = [
        'id', 'name_zht', 'name_zhs', 'name_jp', 'name_en', 'nicknames', 'birthday', 'gender', 'hometown', 'blood_type', 'height', 'description', 'sources', 'photo_cover', 'created_at', 'updated_at'
    ];

    public function animes($role)
    {
        switch ($role) {
            case 'actor':
                return $this->belongsToMany('App\Anime', 'anime_character_roles', 'staff_id', 'anime_id');
                break;

            case 'staff':
                return $this->morphToMany('App\Anime', 'animeable', 'anime_roles')->withPivot('role');
                break;
        }
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function getTitle($chinese)
    {
        return $chinese->to(Chinese::ZH_HANT, ($this->name_zht ? $this->name_zht : ($this->name_zhs ? $this->name_zhs : ($this->name_jp ? $this->name_jp : $this->name_en))));
    }
}