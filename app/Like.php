<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'id', 'user_id', 'foreign_type', 'foreign_id', 'is_positive',
    ];

    public function foreign()
    {
        return $this->morphTo();
    }

    public static function count(String $type, int $foreign_id, bool $is_positive)
    {
    	return Like::where('foreign_type', $type)->where('foreign_id', $foreign_id)->where('is_positive', $is_positive)->count();
    }
}
