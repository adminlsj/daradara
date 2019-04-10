<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
	protected $fillable = [
        'title', 'content', 'content', 'is_travel', 'is_japan', 'is_korea', 'is_taiwan', 'is_food', 'is_fashion',
    ];

    public static $pages = [
        'japan' => [
            'nav' => '日本旅遊與文化',
            'genre' => 'travel',
            'name' => 'freeriderjapan',
            'recommend' => '更多日本旅遊資訊及文化，讚好FreeRider專頁'
        ],

        'lollipop' => [
            'nav' => '最新有趣潮流與資訊',
            'genre' => 'daily',
            'name' => 'lollipopdaily',
            'recommend' => '更多最新有趣潮流與資訊，讚好Lollipop Daily專頁'
        ],

        'news' => [
            'nav' => '科技資訊與初創',
            'genre' => 'tech',
            'name' => 'freeridertech',
            'recommend' => '更多科技與特斯拉資訊，讚好FreeRider專頁'
        ],

        'japanews' => [
            'nav' => 'Japan Travel & Culture',
            'genre' => 'travel',
            'name' => 'freeriderjapanews',
            'recommend' => 'Like our page for more Interesting Japan!'
        ]
    ];

    public function blogImgs()
    {
        return $this->hasMany('App\BlogImg');
    }

    /* public function getRouteKeyName()
	{
	    return 'title';
	} */
}
