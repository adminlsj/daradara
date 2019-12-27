<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Watch extends Model
{
	protected $fillable = [
        'id', 'genre', 'category', 'title', 'description', 'imgur',
    ];

    public function titleToURL()
    {
    	$title = str_replace(" / ", "_", $this->title);
    	$title = str_replace(" ", "-", $title);
    	return $title;
    }

    public function imgurM()
    {
    	return "https://i.imgur.com/".$this->imgur."m.jpg";
    }

    public function imgurH()
    {
    	return "https://i.imgur.com/".$this->imgur."h.jpg";
    }
}
