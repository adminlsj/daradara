<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Savelist extends Model
{
    protected $fillable = [
        'id', 'user_id', 'title', 'description', 'is_status', 'is_private', 'created_at', 'updated_at'
    ];

    public static $statuslists = [
        'watching' => '觀看中', 'planning' => '準備觀看', 'completed' => '已觀看', 'rewatching' => '重看中', 'paused' => '暫停', 'dropped' => '棄番'
    ];

    public function anime_saves()
    {
        return $this->morphedByMany('App\AnimeSave', 'savelistable');
    }
}