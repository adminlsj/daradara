<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
	protected $fillable = [
        'title', 'content', 'content', 'is_travel', 'is_japan', 'is_korea', 'is_taiwan', 'is_food', 'is_fashion',
    ];

    public static $category = ['japan' => '日本', 'korea' => '日本', 'japan_en' => 'Japan'];

    public function blogImgs()
    {
        return $this->hasMany('App\BlogImg');
    }

    /* public function getRouteKeyName()
	{
	    return 'title';
	} */
}
