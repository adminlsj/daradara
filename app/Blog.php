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
            'sao3B' => ['value' => 'sao3B', 'title' => '刀劍神域 Alicization 愛麗絲篇異界戰爭 第三季後半', 'imgur' => 'https://i.imgur.com/1wPd8E8h.png'],
        ],
        'drama' => [
            'tbskc' => ['value' => 'tbskc', 'title' => '逃避雖可恥但有用', 'imgur' => 'https://i.gimy.tv/izp/uploads/vod/2018-10-11/5bbf1ebb3fac4.jpg'],
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
