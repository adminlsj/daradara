<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderImg extends Model
{
	protected $fillable = [
        'order_id', 'filename', 'mime', 'original_filename',
    ];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
