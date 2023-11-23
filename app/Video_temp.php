<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Video;

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

        $最新上市 = Video::with('user:id,name')->whereIn('genre', Video::$genre)->orderBy('created_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration', 'created_at', 'updated_at')->limit($dCountFirst)->get();
        $最新上傳 = Video::with('user:id,name')->whereIn('genre', Video::$genre)->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration', 'created_at', 'updated_at', 'uploaded_at')->limit($dCountFirst)->get();
        $中文字幕 = Video::with('user:id,name')->whereIn('genre', ['Motion Anime', '3D動畫', '同人作品', 'Cosplay'])->where('tags_array', 'like', '%中文字幕%')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration', 'created_at', 'updated_at', 'uploaded_at')->limit($dCount)->get();
        $他們在看 = Video::with('user:id,name')->whereIn('genre', Video::$genre)->orderBy('updated_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration', 'created_at', 'updated_at')->limit($dCount)->get();
        $Motion_Anime = Video::with('user:id,name')->where('genre', 'Motion Anime')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration', 'created_at', 'updated_at', 'uploaded_at')->limit($dCount)->get();
        $SD動畫 = Video::with('user:id,name')->where('genre', '3D動畫')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration', 'created_at', 'updated_at', 'uploaded_at')->limit($dCount)->get();
        $同人作品 = Video::with('user:id,name')->where('genre', '同人作品')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration', 'created_at', 'updated_at', 'uploaded_at')->limit($dCount)->get();
        $Cosplay = Video::with('user:id,name')->where('genre', 'Cosplay')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration', 'created_at', 'updated_at', 'uploaded_at')->limit($dCount)->get();
        $本日排行 = Video::with('user:id,name')->whereIn('genre', Video::$genre)->orderBy('current_views', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration', 'created_at', 'updated_at')->limit($dCount)->get();
        $本月排行 = Video::with('user:id,name')->whereIn('genre', Video::$genre)->orderBy('month_views', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration', 'created_at', 'updated_at')->limit($dCount)->get();
        $doujins = ['最新上市' => $最新上市, '最新上傳' => $最新上傳, '中文字幕' => $中文字幕, '他們在看' => $他們在看, 'Motion_Anime' => $Motion_Anime, 'SD動畫' => $SD動畫, '同人作品' => $同人作品, 'Cosplay' => $Cosplay, '本日排行' => $本日排行, '本月排行' => $本月排行];
        foreach ($doujins as $name => $doujin_new) {
            $doujin_old = Video_temp::where('name', $name)->get();
            $loop = 0;
            foreach ($doujin_old as $old) {
                $new = $doujin_new[$loop];
                $old->id = $new->id;
                $old->route = '/';
                $old->name = $name;
                $old->user_id = $new->user_id;
                $old->title = $new->title;
                $old->cover = $new->cover;
                $old->imgur = $new->imgur;
                $old->thumbL = $new->thumbL();
                $old->thumbH = $new->thumbH();
                $old->views = $new->views();
                $old->duration = $new->duration;
                $old->created_at = $new->created_at;
                $old->updated_at = $new->updated_at;
                $old->uploaded_at = $new->uploaded_at;
                $old->save();
                $loop++;
            }
        }
    }
}
