<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
	protected $fillable = [
        'title', 'content', 'content', 'is_travel', 'is_japan', 'is_korea', 'is_taiwan', 'is_food', 'is_fashion',
    ];

    public static $genres = [
        'laughseejapan' => [
            'navTitle' => '娛見日本',
            'listTitle' => '日本熱門綜藝',
            'categories' => ['溫馨' => 'touch', '搞笑' => 'laugh'],
            'name' => 'laughseejapan'
        ],

        'travel' => [
            'navTitle' => '旅日塾',
            'listTitle' => '日本旅行與文化',
            'categories' => ['新聞' => 'news', '旅行' => 'japan'],
            'name' => 'freeriderjapan'
        ],

        'news' => [
            'navTitle' => '微新聞',
            'listTitle' => '最新新聞資訊',
            'categories' => ['國際' => 'world', '香港' => 'hk', '台灣' => 'tw'],
            'name' => 'freeriderjapan'
        ],

        'finance' => [
            'navTitle' => '融易',
            'listTitle' => '金融與投資',
            'categories' => ['政治' => 'politics', '經濟' => 'economics', '投資' => 'investment'],
            'name' => 'freeriderjapan'
        ],

        'tech' => [
            'navTitle' => '科學園',
            'listTitle' => '科技與創新',
            'categories' => ['初創' => 'startups', '研報' => 'analytics', '快訊' => 'news'],
            'name' => 'freeriderjapan'
        ],

        'forum' => [
            'navTitle' => '亦語',
            'listTitle' => '最專業的問答論壇',
            'categories' => ['生活' => 'life', '教學' => 'tutorial', '知識' => 'knowledge'],
            'name' => 'freeriderjapan'
        ],

        'press' => [
            'navTitle' => '簡讀',
            'listTitle' => '知識與幽默並重',
            'categories' => ['生活' => 'life', '教學' => 'tutorial', '知識' => 'knowledge'],
            'name' => 'freeriderjapan'
        ],

        'ranking' => [
            'navTitle' => '排行百科',
            'listTitle' => '最齊全的排行榜',
            'categories' => ['比賽' => 'competition', '學術' => 'acedamics', '娛樂' => 'entertainment'],
            'name' => 'freeriderjapan'
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
