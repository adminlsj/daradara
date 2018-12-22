<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
	protected $fillable = [
        'title', 'content', 'content', 'is_travel', 'is_japan', 'is_korea', 'is_taiwan', 'is_food', 'is_fashion',
    ];

    public static $genre = ['japan' => '旅遊', 'korea' => '旅遊', 'thai' => '旅遊', 'hk' => '旅遊', 'japan_en' => 'Travel', 'news' => '科技', 'startup' => '科技'];

    public static $genre_url = ['japan' => 'travel', 'korea' => 'travel', 'thai' => 'travel', 'hk' => 'travel', 'japan_en' => 'travel', 'news' => 'tech', 'startup' => 'tech'];

    public static $category = ['japan' => '日本文化', 'korea' => '韓國文化', 'japan_en' => 'Japan', 'news' => '時事', 'startup' => '初創'];

    public static $fb_page = ['japan' => 'japan', 'korea' => 'korea', 'news' => 'tech', 'startup' => 'tech'];

    public static $fb_recommend = ['japan' => '更多日本旅遊資訊及文化', 'korea' => '更多韓國旅遊資訊及文化', 'news' => '更多科技與特斯拉資訊', 'startup' => '更多科技與特斯拉資訊'];

    public function blogImgs()
    {
        return $this->hasMany('App\BlogImg');
    }

    /* public function getRouteKeyName()
	{
	    return 'title';
	} */
}
