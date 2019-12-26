<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Watch;

class Blog extends Model
{
	protected $fillable = [
        'id', 'title', 'caption', 'genre', 'category', 'tags', 'hd', 'sd', 'imgur', 'views', 'duration', 'outsource', 'created_at',
    ];

    public function watch()
    {
        return Watch::where('category', $this->category)->first();
    }

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

    public function durationData()
    {
        $hour = (int) floor(($this->duration / 60) / 60);
        $min = (int) floor($this->duration / 60);
        $sec = (int) round($this->duration % 60);

        if ($hour == 0) {
            $hour = '00';
        }

        if ($min >= 60) {
            $min = (int) round($min % 60);
        }
        if ($min == 0) {
            $min = '00';
        }

        if ($sec == 0) {
            $sec = '00';
        }

        return 'T'.$hour.'H'.$min.'M'.$sec.'S';
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
