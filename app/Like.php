<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'id', 'user_id', 'type', 'foreign_id', 'is_positive',
    ];

    public static function count(String $type, int $foreign_id, bool $is_positive)
    {
    	return Like::where('type', $type)->where('foreign_id', $foreign_id)->where('is_positive', $is_positive)->count();
    }
}
