<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Job extends Model
{
	protected $fillable = [
        'company_id', 'title', 'location', 'category', 'salary', 'level', 'type', 'education', 'responsibility', 'requirement', 'experience'
    ];

    public static $category = ['Accounting' => 'Accounting', 'HR / Admin' => 'HR / Admin', 'Banking / Finance' => 'Banking / Finance', 'Beauty Care / Health' => 'Beauty Care / Health', 'Building / Construction' => 'Building / Construction', 'Design' => 'Design', 'E-commerce' => 'E-commerce', 'Education' => 'Education', 'Engineering' => 'Engineering', 'Hospitality' => 'Hospitality', 'Information Technology' => 'Information Technology', 'Insurance' => 'Insurance', 'Management' => 'Management', 'Manufacturing' => 'Manufacturing', 'Marketing' => 'Marketing', 'Public Relations' => 'Public Relations', 'Media / Advertising' => 'Media / Advertising', 'Medical Services' => 'Medical Services', 'Merchandising / Logistics' => 'Merchandising / Logistics', 'Property / Real Estate' => 'Property / Real Estate', 'Public / Civil' => 'Public / Civil', 'Sales / Business Devpt' => 'Sales / Business Devpt', 'Sciences, Lab, RD' => 'Sciences, Lab, RD'];

    public static $country = ['Shenzhen' => 'Shenzhen', 'Guangzhou' => 'Guangzhou', 'Shanghai' => 'Shanghai', 'Beijing' => 'Beijing'];

    public static $experience = ['No Experience' => 'No Experience', 'Less than 1 year' => 'Less than 1 year', '1 to 3 years' => '1 to 3 years', '3 to 5 years' => '3 to 5 years', '5 years or above' => '5 years or above'];

    public static $level = ['Entry Level' => 'Entry Level', 'Middle' => 'Middle', 'Senior' => 'Senior', 'Top' => 'Top'];

    public static $type = ['Full Time' => 'Full Time', 'Part Time' => 'Part Time', 'Internship' => 'Internship'];

    public static $education = ['Matriculated' => 'Matriculated', 'Degree' => 'Degree', 'Non-Degree Tertiary' => 'Non-Degree Tertiary', 'Postgraduate' => 'Postgraduate'];

    public static $delivery = ['mtr' => '地鐵站交收', 'home' => '送貨上門'];

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
