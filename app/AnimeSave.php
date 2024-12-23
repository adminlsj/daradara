<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnimeSave extends Model
{
    protected $fillable = [
        'id', 'user_id', 'anime_id', 'status', 'episode_progress', 'start_date', 'finish_date', 'total_rewatches', 'notes', 'is_hidden_from_status_lists', 'created_at', 'updated_at'
    ];

    public function anime()
    {
        return $this->belongsTo('App\Anime');
    }

    public function savelists()
    {
        return $this->morphToMany('App\Savelist', 'savelistable')->withPivot('id');
    }

    public function savelistables()
    {
        return $this->morphMany('App\Savelistable', 'savelistable');
    }
}