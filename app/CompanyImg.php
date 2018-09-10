<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyImg extends Model
{
	protected $fillable = [
        'company_id', 'filename', 'mime', 'original_filename',
    ];

    public function company()
    {
        return $this->belongsTo('App\Company');
    }
}
