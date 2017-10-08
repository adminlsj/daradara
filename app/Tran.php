<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tran extends Model
{
	protected $fillable = [
        'user_id', 'order_id', 'is_arrived', 'is_received'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
