<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $fillable = [
        'id', 'created_at', 'updated_at', 'photo_cover', 'name_zht', 'name_zhs', 'name_jp', 'name_en', 'birthday', 'gender', 'description'
    ];
}