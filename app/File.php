<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class File extends Model
{
    protected $fillable = [
        'id', 'user_id', 'title', 'extension', 'size', 'url', 'views', 'downloads', 'client_ip', 'created_at', 'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
