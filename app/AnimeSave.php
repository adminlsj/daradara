<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnimeSave extends Model
{
    protected $fillable = [
        'id', 'user_id', 'anime_id', 'episode_progress', 'start_date', 'finish_date', 'total_rewatches', 'notes', 'is_hidden_from_status_lists', 'created_at', 'updated_at'
    ];

    public static function import($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public function characters()
    {
        return $this->belongsToMany('App\Character', 'actor_anime_character', 'anime_id', 'character_id')->withPivot('role');;
    }
}