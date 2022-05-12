<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Preview;

class Preview extends Model
{
    protected $casts = [
        'images' => 'array', 'votes' => 'array'
    ];

    protected $fillable = [
        'id', 'uuid', 'cover', 'votes'
    ];

    public static $brands = [
        'あんてきぬすっ', 'ショーテン', 'ピンクパイナップル', '魔人', 'PoRO', 'Queen Bee', 'メリー・ジェーン', '鈴木みら乃', 'ばにぃうぉ～か～', '彗星社', '妄想専科', 'nur', '妄想実現めでぃあ'
    ];

    public static $weekMap = [
        0 => '星期日',
        1 => '星期一',
        2 => '星期二',
        3 => '星期三',
        4 => '星期四',
        5 => '星期五',
        6 => '星期六',
    ];

    public function video()
    {
        return $this->belongsTo('App\Video', 'video_id');
    }
}
