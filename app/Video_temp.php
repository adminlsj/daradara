<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video_temp extends Model
{
    protected $primaryKey = 'primary_id';

    protected $casts = [
        'data' => 'array', 'translations' => 'array'
    ];

    protected $fillable = [
        'id', 'route', 'name', 'video_id', 'user_id', 'title', 'translations', 'caption', 'cover', 'imgur', 'thumbL', 'thumbH', 'views', 'duration', 'data',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function thumbL()
    {
        return $this->thumbL;
    }

    public function thumbH()
    {
        return $this->thumbH;
    }

    public function views()
    {
        return $this->views;
    }

    public static function updateHomeVideos()
    {
        $hCount = 16;
        $dCountFirst = 18;
        $dCount = 12;

        $最新裏番_old = Video_temp::where('name', '最新裏番')->get();
        $最新裏番_new = Video::where('genre', '裏番')->orWhere(function($query) {
                            $query->where('genre', '泡麵番')->where('foreign_sd', 'like', '%"bangumi"%');
                        })->orderBy('created_at', 'desc')->select('id', 'title', 'translations', 'caption', 'cover', 'imgur', 'created_at', 'updated_at')->limit($hCount)->get();

        $loop = 0;
        $new = [];
        foreach ($最新裏番_old as $old) {
            $new = $最新裏番_new[$loop];
            $old->id = $new->id;
            $old->route = '/';
            $old->name = '最新裏番';
            $old->title = $new->title;
            $old->translations = $new->translations;
            $old->caption = $new->caption;
            $old->cover = $new->cover;
            $old->imgur = $new->imgur;
            $old->thumbL = $new->thumbL();
            $old->thumbH = $new->thumbH();
            $old->created_at = $new->created_at;
            $old->updated_at = $new->updated_at;
            $old->save();
            $loop++;
        }
    }
}
