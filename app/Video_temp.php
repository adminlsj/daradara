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

        $最新裏番 = Video::where('genre', '裏番')->orWhere(function($query) {
                            $query->where('genre', '泡麵番')->where('foreign_sd', 'like', '%"bangumi"%');
                        })->orderBy('created_at', 'desc')->select('id', 'title', 'translations', 'caption', 'cover', 'imgur', 'created_at')->limit($hCount)->get();
        $最新上市 = Video::with('user:id,name')->whereIn('genre', Video::$genre)->orderBy('created_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration', 'created_at', 'updated_at')->limit($dCountFirst)->get();
        $最新上傳 = Video::with('user:id,name')->whereIn('genre', Video::$genre)->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration', 'created_at', 'updated_at', 'uploaded_at')->limit($dCountFirst)->get();
        $中文字幕 = Video::with('user:id,name')->whereIn('genre', ['Motion Anime', '3D動畫', '同人作品', 'Cosplay'])->where('tags_array', 'like', '%中文字幕%')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration', 'created_at', 'updated_at', 'uploaded_at')->limit($dCount)->get();
        $他們在看 = Video::with('user:id,name')->whereIn('genre', Video::$genre)->orderBy('updated_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration', 'created_at', 'updated_at')->limit($dCount)->get();

        $泡麵番 = Video::where('genre', '泡麵番')->where('foreign_sd', 'like', '%"bangumi"%')->orderBy('uploaded_at', 'desc')->select('id', 'title', 'cover', 'uploaded_at')->limit($hCount)->get();
        $Motion_Anime = Video::with('user:id,name')->where('genre', 'Motion Anime')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration', 'created_at', 'updated_at', 'uploaded_at')->limit($dCount)->get();
        $SD動畫 = Video::with('user:id,name')->where('genre', '3D動畫')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration', 'created_at', 'updated_at', 'uploaded_at')->limit($dCount)->get();
        $同人作品 = Video::with('user:id,name')->where('genre', '同人作品')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration', 'created_at', 'updated_at', 'uploaded_at')->limit($dCount)->get();
        $Cosplay = Video::with('user:id,name')->where('genre', 'Cosplay')->orderBy('uploaded_at', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration', 'created_at', 'updated_at', 'uploaded_at')->limit($dCount)->get();

        $新番預告 = Video::where('genre', '新番預告')->orderBy('created_at', 'desc')->select('id', 'title', 'cover', 'created_at')->limit($hCount)->get();
        $本日排行 = Video::with('user:id,name')->whereIn('genre', Video::$genre)->orderBy('current_views', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration', 'created_at', 'updated_at', 'current_views')->limit($dCount)->get();
        $本月排行 = Video::with('user:id,name')->whereIn('genre', Video::$genre)->orderBy('month_views', 'desc')->select('id', 'user_id', 'title', 'cover', 'imgur', 'views', 'duration', 'created_at', 'updated_at', 'month_views')->limit($dCount)->get();
        
        $videos_new = ['最新裏番' => $最新裏番, '最新上市' => $最新上市, '最新上傳' => $最新上傳, '中文字幕' => $中文字幕, '他們在看' => $他們在看, '泡麵番' => $泡麵番, 'Motion_Anime' => $Motion_Anime, 'SD動畫' => $SD動畫, '同人作品' => $同人作品, 'Cosplay' => $Cosplay, '新番預告' => $新番預告, '本日排行' => $本日排行, '本月排行' => $本月排行];        
        foreach ($videos_new as $name => $video_new) {
            $video_old = Video_temp::where('name', $name)->get();
            $loop = 0;
            foreach ($video_old as $old) {
                $new = $video_new[$loop];
                $old->id = $new->id;
                $old->route = '/';
                $old->name = $name;
                $old->user_id = $new->user_id;
                $old->title = $new->title;
                $old->translations = $new->translations;
                $old->caption = $new->caption;
                $old->cover = $new->cover;
                if ($name != '泡麵番' && $name != '新番預告') {
                    $old->imgur = $new->imgur;
                    $old->thumbL = $new->thumbL();
                    $old->thumbH = $new->thumbH();
                }
                $old->current_views = $new->current_views;
                $old->month_views = $new->month_views;
                if ($name != '最新裏番' && $name != '泡麵番' && $name != '新番預告') {
                    $old->views = $new->views();
                }
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
