<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
	protected $fillable = [
        'id', 'title', 'caption', 'genre', 'category', 'tags', 'hd', 'sd', 'imgur', 'views', 'duration',
    ];

    public function tags()
    {
        return explode(" ", $this->tags);
    }

    public function views()
    {
        if ($this->views >= 10000) {
            return ceil($this->views / 10000).'萬';
        } else {
            return $this->views;
        }
    }

    public function duration()
    {
        $min = (int) floor($this->duration / 60);
        $sec = (int) round($this->duration % 60);
        if ($sec == 0) {
            $sec = '00';
        } elseif ($sec < 10) {
            $sec = '0'.$sec;
        }
        return $min.':'.$sec;
    }

    public function blogImgs()
    {
        return $this->hasMany('App\BlogImg');
    }

    /* public function getRouteKeyName()
	{
	    return 'title';
	} */
}
