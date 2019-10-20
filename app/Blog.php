<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
	protected $fillable = [
        'title', 'content', 'content', 'is_travel', 'is_japan', 'is_korea', 'is_taiwan', 'is_food', 'is_fashion',
    ];

    public static $navIcons = ['explore', 'pets', 'public']; 

    public static $structure = [
        'variety' => [
            'monday' => ['value' => 'monday', 'title' => '月曜夜未央 2019年完整版', 'imgur' => 'https://i.imgur.com/iXyOfUsh.png'],
            'monitoring' => ['value' => 'monitoring', 'title' => '人類觀察 2019年完整版', 'imgur' => 'https://i.imgur.com/wLpWH5hh.png'],
            'talk' => ['value' => 'talk', 'title' => '閒聊007 2019年完整版', 'imgur' => 'https://i.imgur.com/BqVcMd9h.png'],
            'home' => ['value' => 'home', 'title' => '跟你回家可以嗎？2019年完整版', 'imgur' => 'https://i.imgur.com/NF0Gqewh.png'],
            'todai' => ['value' => 'todai', 'title' => '東大方程式完整版', 'imgur' => 'https://i.imgur.com/2rZSHfbh.png']
        ],
        'anime' => [
            'sao3B' => ['value' => 'sao3B', 'title' => '刀劍神域 Alicization Underworld 大戰篇 第三季後半', 'imgur' => 'https://i.imgur.com/YQY7IsRh.png'],
        ],
        'drama' => [
            'demo' => ['value' => 'demo', 'title' => '該區塊仍在更新中！！...請明天再來！！謝謝您🙏', 'imgur' => 'https://i.imgur.com/YQY7IsRh.png'],
        ],
    ];

    public function tags()
    {
        return explode(" ", $this->tags);
    }

    public function views()
    {
        if ($this->views >= 10000) {
            return ceil($this->views / 10000).'萬';
        } else {
            return $this->views;
        }
    }

    public function duration()
    {
        $min = (int) floor($this->duration / 60);
        $sec = (int) round($this->duration % 60);
        if ($sec == 0) {
            $sec = '00';
        } elseif ($sec < 10) {
            $sec = '0'.$sec;
        }
        return $min.':'.$sec;
    }

    public function blogImgs()
    {
        return $this->hasMany('App\BlogImg');
    }

    /* public function getRouteKeyName()
	{
	    return 'title';
	} */
}
