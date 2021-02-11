<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Watch;
use App\Subscribe;
use App\Comment;
use App\Like;
use App\Bot;
use Spatie\Browsershot\Browsershot;

class Video extends Model
{
    protected $casts = [
        'foreign_sd' => 'array', 'data' => 'array', 'translations' => 'array'
    ];

	protected $fillable = [
        'id', 'user_id', 'playlist_id', 'title', 'caption', 'tags', 'sd', 'imgur', 'current_views', 'views', 'outsource', 'foreign_sd', 'data', 'created_at', 'uploaded_at', 'cover', 'translations'
    ];

    public static $setting = [
        '姐', '妹', '母', '人妻', '青梅竹馬', '處女', '御姐', '熟女'
    ];

    public static $profession = [
        'JK', '運動少女', '大小姐', '老師', '女醫護士', '女僕', '巫女', '修女', '偶像', 'OL', '風俗娘', '公主', '女騎士', '魔法少女', '妖精', '魔物娘', '獸娘'
    ];

    public static $appearance = [
        '巨乳', '貧乳', '黑皮膚', '眼鏡娘', '泳裝', '圍裙', '黑絲襪', '和服', '獸耳', '碧池', '不良少女', '傲嬌', '病嬌', '偽娘', '扶他'
    ];

    public static $storyline = [
        '自慰', '口交', '乳交', '肛交', '腳交', '腋下', '玩具', '觸手', '內射', '顏射', '3P', '群交', '後宮', '公眾場合', '近親', '師生', 'NTR', '懷孕', '噴奶', '放尿', '精神控制', '藥物', '痴漢', '阿嘿顏', '精神崩潰', '鬼畜', 'BDSM', '調教', '強制', '逆強制', '痴女', '女王樣', '百合', '耽美', '性轉換', '異世界', '異種族', '純愛', '戀愛喜劇', '世界末日', '1080p'
    ];

    public static $hentai_tags = [
        '3D', 'JK', '御姐', '人妻', '熟女', '大小姐', '公主', '傲嬌', '碧池', '痴女', '處女', '眼鏡娘', '黑皮膚', '歐尼醬', '老師', '女OL', '醜男', '痴漢',
        '巨乳', '貧乳', '乳交', '手交', '口交', '腳交', '肛交', '毒龍鑽', '腋下', '自慰', '玩具', '顏射', '內射', '3P', '群交', '後宮', '親子丼', '阿嘿顏', '援交',
        'BDSM', '綑綁', '調教', '觸手', '強制', '鬼畜', '逆強制', '女王樣', '精神控制', '精神崩潰', '爆精', '放尿', '懷孕', '噴奶',
        '角色扮演', '貓耳', '護士', '泳裝', '女僕', '裸體圍裙', '黑絲襪', '修女',
        '異世界', '異種族', '妖精', '魔物娘', '獸娘', '怪獸',
        '劇情', '校園', '純愛', '窩邊草', 'NTR', '藥物', '奇幻', '性轉換', '公眾場合',
        '百合', '扶他', '偽娘', '耽美', 'YOOO'
    ];

    public static $selected_tags = [
        '姐', '妹', '母', '人妻', '青梅竹馬', '御姐', '熟女', 'JK', '運動少女', '大小姐', '老師', '女醫護士', '女僕', '巫女', '修女', '偶像', 'OL', '風俗娘', '公主', '女騎士', '魔法少女', '妖精', '魔物娘', '獸娘', '貧乳', '黑皮膚', '眼鏡娘', '泳裝', '圍裙', '黑絲襪', '和服', '獸耳', '處女', '不良少女', '傲嬌', '病嬌', '偽娘', '扶他', '肛交', '腳交', '腋下', '觸手', '群交', '後宮', '近親', '師生', 'NTR', '懷孕', '噴奶', '放尿', '精神控制', '藥物', '痴漢', '阿嘿顏', '精神崩潰', '鬼畜', 'BDSM', '強制', '逆強制', '痴女', '女王樣', '百合', '耽美', '性轉換', '異世界', '異種族', '純愛', '戀愛喜劇', '世界末日', '1080p'
    ];

    public static $hentai_brands = [
        '妄想実現めでぃあ', 'メリー・ジェーン', 'ピンクパイナップル', 'ばにぃうぉ～か～', 'Queen Bee', 'PoRO', 'せるふぃっしゅ', '鈴木みら乃', 'ショーテン', 'GOLD BEAR', 'ZIZ', 'EDGE', 'Collaboration Works', 'BOOTLEG', 'BOMB!CUTE!BOMB!', 'nur', 'あんてきぬすっ', '魔人', 'ルネ', 'Princess Sugar', 'パシュミナ', 'WHITE BEAR', 'AniMan', 'chippai', 'トップマーシャル', 'erozuki', 'サークルトリビュート', 'spermation', 'Milky', 'King Bee', 'PashminaA', 'じゅうしぃまんご～', 'Hills'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function watch()
    {
        return $this->belongsTo('App\Watch', 'playlist_id');
    }

    public function subscribes()
    {
        return Subscribe::where('tag', $this->watch()->title)->orderBy('created_at', 'asc')->get();
    }

    public function comments()
    {
        return Comment::where('type', 'video')->where('foreign_id', $this->id)->orderBy('created_at', 'desc')->get();
    }

    public function tags()
    {
        return explode(" ", $this->tags);
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'foreign');
    }

    public function saves()
    {
        return $this->hasMany('App\Save');
    }

    public static function getSpankbang(String $url, String $tags)
    {
        $requests = Browsershot::url($url)
            ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
            ->triggeredRequests();
        foreach ($requests as $request) {
            if (strpos($request['url'], 'https://vdownload') !== false && strpos($request['url'], '.mp4') !== false) {
                if (strpos($tags, ' 1080p ') !== false) {
                    return str_replace('-720p', '-1080p', $request['url']);
                } else {
                    return $request['url'];
                }
            }
        }
    }

    public static function getYoujizz(String $url)
    {
        $html = Browsershot::url($url)
            ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.50 Safari/537.36')
            ->bodyHtml();
        $start = explode('<source src="', $html);
        return html_entity_decode("https:".explode('" title="' , $start[1])[0]);
    }

    public static function tagSubscribeFirst(Subscribe $subscribe)
    {
        return Video::where('tags', 'LIKE', '%'.$subscribe->tag.'%')->orderBy('uploaded_at', 'desc')->first();
    }

    public static function notifySubscribers(Video $video)
    {
        if ($video->playlist_id != '') {
            $watch = $video->watch;
            $watch->updated_at = $video->uploaded_at;
            $watch->save();

            $subscribes = $watch->subscribes();
            foreach ($subscribes as $subscribe) {
                $user = $subscribe->user();
                if (strpos($user->alert, 'subscribe') === false) {
                    $user->alert = $user->alert."subscribe";
                    $user->save();
                }
            }
        }
    }

    public function imgur16by9()
    {
        return "https://i.imgur.com/JMcgEkPl.jpg";
    }

    public function imgurDefaultCircleB()
    {
        return "https://i.imgur.com/sMSpYFXb.jpg";
    }

    public function imgur()
    {
        return "https://i.imgur.com/".$this->imgur.".jpg";
    }

    public function imgurS()
    {
        return "https://i.imgur.com/".$this->imgur."s.jpg";
    }

    public function imgurB()
    {
        return "https://i.imgur.com/".$this->imgur."b.jpg";
    }

    public function imgurT()
    {
        return "https://i.imgur.com/".$this->imgur."t.jpg";
    }

    public function imgurM()
    {
        return "https://i.imgur.com/".$this->imgur."m.jpg";
    }

    public function imgurL()
    {
        return "https://i.imgur.com/".$this->imgur."l.jpg";
    }

    public function imgurH()
    {
        return "https://i.imgur.com/".$this->imgur."h.jpg";
    }

    static function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public static function getExcludedIds()
    {
        $bot = Bot::where('temp', 'exclude')->first();
        return $bot->data['videos'];
    }

    public function scopeWhereHasTags($query, $tags, $excluded, $count)
    {
        return $query->where(function($query) use ($tags) {
            foreach ($tags as $tag) {
                $query->orWhere('tags', 'like', '%'.$tag.'%');
            }
        })->where('cover', '!=', null)
          ->whereIntegerNotInRaw('id', $excluded)
          ->select('id', 'title', 'cover')      
          ->inRandomOrder()
          ->limit($count);
    }

    public function scopeWhereOrderBy($query, $order, $excluded, $count)
    {
        return $query->orderBy($order, 'desc')
                     ->where('cover', '!=', null)
                     ->whereIntegerNotInRaw('id', $excluded)
                     ->select('id', 'title', 'cover')      
                     ->limit($count);
    }
}
