<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Savelistable extends Model
{
    protected $fillable = [
        'id', 'savelist_id', 'savelistable_id', 'savelistable_type', 'created_at', 'updated_at'
    ];
}