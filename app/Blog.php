<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
	protected $fillable = [
        'title', 'content', 'content', 'is_travel', 'is_japan', 'is_korea', 'is_taiwan', 'is_food', 'is_fashion',
    ];

    public static $genre = ['japan' => 'travel', 'korea' => 'travel', 'thai' => 'travel', 'hk' => 'travel', 'japan_en' => 'travel'];

    public static $category = ['japan' => '日本', 'korea' => '韓國', 'japan_en' => 'Japan'];

    public function blogImgs()
    {
        return $this->hasMany('App\BlogImg');
    }

    /* public function getRouteKeyName()
	{
	    return 'title';
	} */
}
