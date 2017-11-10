<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
	protected $fillable = [
        'user_id', 'name', 'price', 'description', 'category', 'country', 'link', 'end_date', 'is_payed', 'is_cancelled', 'quantity'
    ];

    public static $category = ['food' => '環球小食', 'makeup' => '美容彩妝', 'bag' => '手袋銀包', 'accessories' => '潮流配飾', 'watch' => '手錶眼鏡', 'others' => '其他'];

    public static $country = ['japan' => '日本', 'korea' => '韓國', 'taiwan' => '台灣', 'usa' => '美國', 'england' => '英國', 'france' => '法國', 'italy' => '意大利', 'australia' => '澳洲', 'singapore' => '新加坡'];

    public static $delivery = ['mtr' => '地鐵站交收', 'home' => '送貨上門'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function trans()
    {
        return $this->hasOne('App\Tran');
    }

    public function orderImgs()
    {
        return $this->hasMany('App\OrderImg');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public static $orderImgs = ['php1ceiRw', 'php4T8szz', 'phpAqeMGT', 'phpAtQpe8', 'phpfhAWAe', 'phpfWJyYT', 'phpu759HX', 'phpUSh0Ei', 'phpBR2Lkv', 'phpCtyFCN', 'phpF7F47w', 'phpIMCnVe', 'phpN0KMtD', 'phpqPlLPG', 'phpsaHnR5', 'phpXcyVWa'];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y年m月d日');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }
}
