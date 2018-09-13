<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Job extends Model
{
	protected $fillable = [
        'company_id', 'title', 'location', 'category', 'salary', 'level', 'type', 'education', 'responsibility', 'requirement', 'experience'
    ];

    public static $category = ['互聯網 (IT)' => '互聯網 (IT)', '電子商務' => '電子商務', '銀行 / 金融' => '銀行 / 金融', '市場 / 商務拓展' => '市場 / 商務拓展', '美術 / 設計' => '美術 / 設計', '物流 / 採購' => '物流 / 採購', '人事 / 行政' => '人事 / 行政', '海外市場' => '海外市場', '管理培訓生' => '管理培訓生', '機械製造' => '機械製造', '教育 / 諮詢' => '教育 / 諮詢', '電子電器' => '電子電器', '生物醫療' => '生物醫療', '建築 / 房產' => '建築 / 房產', '外語翻譯' => '外語翻譯', '廣告 / 媒體' => '廣告 / 媒體'];

    public static $country = ['深圳' => '深圳', '廣州' => '廣州', '上海' => '上海', '北京' => '北京'];

    public static $experience = ['No Experience' => 'No Experience', 'Less than 1 year' => 'Less than 1 year', '1 to 3 years' => '1 to 3 years', '3 to 5 years' => '3 to 5 years', '5 years or above' => '5 years or above'];

    public static $level = ['Entry Level' => 'Entry Level', 'Middle' => 'Middle', 'Senior' => 'Senior', 'Top' => 'Top'];

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
