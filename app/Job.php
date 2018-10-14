<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Job extends Model
{
	protected $fillable = [
        'company_id', 'title', 'location', 'category', 'salary', 'level', 'type', 'education', 'responsibility', 'requirement', 'experience'
    ];

    public static $category = ['互聯網 (IT)' => '互聯網 (IT)', '電子商務' => '電子商務', '編程 / 技術開發' => '編程 / 技術開發', '市場行銷 / 廣告' => '市場行銷 / 廣告', '產品 / 運營企劃' => '產品 / 運營企劃', '美術 / 設計' => '美術 / 設計', '人事 / 行政' => '人事 / 行政', '物流 / 採購' => '物流 / 採購', '海外市場 / 貿易' => '海外市場 / 貿易', '銀行 / 金融 / 會計' => '銀行 / 金融 / 會計', '管理培訓生' => '管理培訓生', '教育 / 外語 / 翻譯' => '教育 / 外語 / 翻譯', '機械 / 電子電器' => '機械 / 電子電器', '生物 / 醫療' => '生物 / 醫療', '建築 / 房產' => '建築 / 房產'];

    public static $country = ['深圳' => '深圳', '北京' => '北京', '上海' => '上海', '廣州' => '廣州'];

    public static $experience = ['不限經驗' => '不限經驗', '少於 1 年' => '少於 1 年', '1 至 3 年' => '1 至 3 年', '3 至 5 年' => '3 至 5 年', '5 年或以上' => '5 年或以上'];

    public static $type = ['全職' => '全職', '兼職' => '兼職', '實習' => '實習'];

    public static $education = ['中學畢業' => '中學畢業', '副學士學位' => '副學士學位', '學士學位' => '學士學位', '碩士學位' => '碩士學位'];

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function apps()
    {
        return $this->hasMany('App\App');
    }

    public function savedJobs()
    {
        return $this->hasMany('App\SavedJob');
    }

    public static $orderImgs = ['php1ceiRw', 'php4T8szz', 'phpAqeMGT', 'phpAtQpe8', 'phpfhAWAe', 'phpfWJyYT', 'phpu759HX', 'phpUSh0Ei', 'phpBR2Lkv', 'phpCtyFCN', 'phpF7F47w', 'phpIMCnVe', 'phpN0KMtD', 'phpqPlLPG', 'phpsaHnR5', 'phpXcyVWa'];

    /* public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y年m月d日');
    } */

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }
}
