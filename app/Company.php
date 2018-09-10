<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name', 'description', 'email', 'password', 'provider', 'provider_id',
    ];

    public function companyImgs()
    {
        return $this->hasOne('App\CompanyImg');
    }

    public function jobs()
    {
        return $this->hasMany('App\Job');
    }
}
