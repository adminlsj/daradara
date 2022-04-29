<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comic extends Model
{
    protected $casts = [
        'parodies' => 'array', 'characters' => 'array', 'tags' => 'array', 'artists' => 'array', 'groups' => 'array', 'languages' => 'array', 'categories' => 'array', 'extensions' => 'array'
    ];

    protected $guarded = [];

    public static function addZerosToPage($page)
    {
        if ($page < 10) {
            $page = '00'.$page;

        } elseif ($page < 100) {
            $page = '0'.$page;

        }
        return $page;
    }
}
