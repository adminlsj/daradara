<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Watch;
use App\Subscribe;
use App\Comment;
use App\Like;
use App\Bot;
use App\Helper;
use Spatie\Browsershot\Browsershot;

class Video extends Model
{
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;
    
    protected $casts = [
        'foreign_sd' => 'array', 'data' => 'array', 'translations' => 'array', 'qualities' => 'array', 'downloads' => 'array', 'qualities_sc' => 'array', 'downloads_sc' => 'array', 'tags_array' => 'array'
    ];

    protected $fillable = [
        'id', 'user_id', 'playlist_id', 'comic_id', 'title', 'caption', 'tags', 'sd', 'qualities', 'downloads', 'imgur', 'current_views', 'week_views', 'month_views', 'views', 'outsource', 'foreign_sd', 'data', 'created_at', 'uploaded_at', 'duration', 'translations', 'cover', 'tags_array', 'uncover', 'has_torrent'
    ];

    public static $banned_ip = [
        '210.6.150.118', '2404:0:823d:8da5:a88:2735:897f:492a', '2401:e180:8870:f78c:5199:1043:9aa0:7809', '216.250.255.189', '183.198.152.123', '115.165.198.197', '118.167.100.14', '61.61.91.213', '49.216.80.106', '45.58.156.229', '182.239.85.10', '104.149.130.246', '2402:7500:a42:104f::430f:259', '180.217.250.167', '2001:d08:2283:fc51:d179:6023:816c:7cef', '2001:b400:e27e:5117:2ae3:80b2:74bd:c6c5', '61.239.145.174', '124.218.85.139', '42.2.23.36'
    ];

    public static $vod_servers = [
        [1, 2, 3, 4, 6, 7, 8]
    ];

    public static $metadata = [
        '無碼', 'AI解碼', '1080p', '60FPS'
    ];

    public static $setting = [
        '近親', '姐', '妹', '母', '女兒', '師生', '情侶', '青梅竹馬'
    ];

    public static $profession = [
        'JK', '處女', '御姐', '熟女', '人妻', '老師', '女醫護士', 'OL', '大小姐', '偶像', '女僕', '巫女', '修女', '風俗娘', '公主', '女戰士', '魔法少女', '異種族', '妖精', '魔物娘', '獸娘', '碧池', '痴女', '不良少女', '傲嬌', '病嬌', '無口', '偽娘', '扶他'
    ];

    public static $appearance = [
        '短髮', '馬尾', '雙馬尾', '巨乳', '貧乳', '黑皮膚', '眼鏡娘', '獸耳', '美人痣', '肌肉女', '白虎', '大屌', '水手服', '體操服', '泳裝', '比基尼', '和服', '兔女郎', '圍裙', '啦啦隊', '旗袍', '絲襪', '吊襪帶', '熱褲', '迷你裙', '性感內衣', '丁字褲', '高跟鞋', '淫紋'
    ];

    public static $storyline = [
        '純愛', '戀愛喜劇', '後宮', '開大車', '公眾場合', 'NTR', '精神控制', '藥物', '痴漢', '阿嘿顏', '精神崩潰', '獵奇', 'BDSM', '綑綁', '眼罩', '項圈', '調教', '異物插入', '肉便器', '胃凸', '強制', '逆強制', '女王樣', '母女丼', '姐妹丼', '凌辱', '出軌', '攝影', '性轉換', '百合', '耽美', '異世界', '怪獸', '世界末日'
    ];

    public static $position = [
        '手交', '指交', '乳交', '肛交', '腳交', '拳交', '3P', '群交', '口交', '口爆', '吞精', '舔蛋蛋', '舔穴', '69', '自慰', '腋毛', '腋交', '舔腋下', '內射', '顏射', '雙洞齊下', '懷孕', '噴奶', '放尿', '排便', '顏面騎乘', '車震', '性玩具', '毒龍鑽', '觸手', '頸手枷'
    ];

    public static $selected_tags = [
        '姐', '妹', '母', '人妻', '青梅竹馬', '御姐', '熟女', 'JK', '運動少女', '大小姐', '老師', '女醫護士', '女僕', '巫女', '修女', '偶像', 'OL', '風俗娘', '公主', '女騎士', '魔法少女', '妖精', '魔物娘', '獸娘', '貧乳', '黑皮膚', '眼鏡娘', '泳裝', '圍裙', '黑絲襪', '和服', '獸耳', '處女', '不良少女', '傲嬌', '病嬌', '偽娘', '扶他', '肛交', '腳交', '觸手', '群交', '肉便器', '後宮', '近親', '師生', 'NTR', '懷孕', '噴奶', '放尿', '排便', '精神控制', '藥物', '痴漢', '阿嘿顏', '精神崩潰', '鬼畜', 'BDSM', '強制', '逆強制', '痴女', '女王樣', '百合', '耽美', '性轉換', '異世界', '異種族', '純愛', '戀愛喜劇', '世界末日', '1080p', '無碼', '3D', '同人', 'Cosplay', '項圈', '腋毛', '腋交', '舔腋下', '無口', '淫紋', '異物插入', '姐妹丼'
    ];

    public static $hentai_brands = [
        '妄想実現めでぃあ', 'メリー・ジェーン', 'ピンクパイナップル', 'ばにぃうぉ～か～', 'Queen Bee', 'PoRO', 'せるふぃっしゅ', '鈴木みら乃', 'ショーテン', 'GOLD BEAR', 'ZIZ', 'EDGE', 'Collaboration Works', 'BOOTLEG', 'BOMB!CUTE!BOMB!', 'nur', 'あんてきぬすっ', '魔人', 'ルネ', 'Princess Sugar', 'パシュミナ', 'White Bear', 'AniMan', 'chippai', 'トップマーシャル', 'erozuki', 'サークルトリビュート', 'spermation', 'Milky', 'King Bee', 'PashminaA', 'じゅうしぃまんご～', 'Hills', '妄想専科', 'ディスカバリー', 'ひまじん', '37℃', 'schoolzone', 'GREEN BUNNY', 'バニラ', 'L.', 'PIXY', 'こっとんど～る', 'ANIMAC', 'Celeb', 'MOON ROCK', 'Dream', 'ミンク', 'オズ・インク', 'サン出版', 'ポニーキャニオン', 'わるきゅ～れ＋＋', '株式会社虎の穴', 'エンゼルフィッシュ', 'UNION-CHO', 'TOHO', 'ミルクセーキ', '2匹目のどぜう', 'じゅうしぃまんご～', 'ツクルノモリ', 'サークルトリビュート', 'トップマーシャル', 'サークルトリビュート'
    ];

    public static $all_tag = [
        '近親', '姐', '妹', '母', '女兒', '師生', '情侶', '青梅竹馬', 'JK', '處女', '御姐', '熟女', '人妻', '老師', '女醫護士', 'OL', '大小姐', '偶像', '女僕', '巫女', '修女', '風俗娘', '公主', '女戰士', '魔法少女', '異種族', '妖精', '魔物娘', '獸娘', '碧池', '痴女', '不良少女', '傲嬌', '病嬌', '偽娘', '扶他', '短髮', '馬尾', '雙馬尾', '巨乳', '貧乳', '黑皮膚', '眼鏡娘', '獸耳', '美人痣', '肌肉女', '白虎', '大屌', '水手服', '體操服', '泳裝', '比基尼', '和服', '兔女郎', '圍裙', '啦啦隊', '旗袍', '絲襪', '吊襪帶', '熱褲', '迷你裙', '性感內衣', '丁字褲', '高跟鞋', '純愛', '戀愛喜劇', '後宮', '開大車', '公眾場合', 'NTR', '精神控制', '藥物', '痴漢', '阿嘿顏', '精神崩潰', '獵奇', 'BDSM', '綑綁', '眼罩', '調教', '肉便器', '胃凸', '強制', '逆強制', '女王樣', '母女丼', '凌辱', '出軌', '攝影', '性轉換', '百合', '耽美', '異世界', '怪獸', '世界末日', '手交', '指交', '乳交', '肛交', '腳交', '拳交', '3P', '群交', '口交', '口爆', '吞精', '舔蛋蛋', '舔穴', '69', '自慰', '毒龍鑽', '內射', '顏射', '雙洞齊下', '懷孕', '噴奶', '放尿', '顏面騎乘', '車震', '性玩具', '觸手', '頸手枷', '項圈', '排便', '腋毛', '腋交', '舔腋下', '無口', '淫紋', '異物插入', '姐妹丼'
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

    public function likes()
    {
        return $this->hasMany('App\Like', 'foreign_id');
    }

    public function saves()
    {
        return $this->hasMany('App\Save');
    }

    public function views()
    {
        if ($this->views >= 10000) {
            return round($this->views / 10000, 1).'萬';
        } else {
            return $this->views;
        }
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

    public function thumbL()
    {
        if (strpos($this->cover, 'cdn.jsdelivr.net') !== false) {
            $cover = Helper::get_string_between($this->cover, '/cover/', '.jpg');
            $thumb = str_replace('/cover/'.$cover, '/thumbnail/'.$this->imgur.'l', $this->cover);
            return $thumb;

        } else {
            return "https://i.imgur.com/".$this->imgur."l.jpg";
        }
    }

    public function thumbH()
    {
        if (strpos($this->cover, 'cdn.jsdelivr.net') !== false) {
            $cover = Helper::get_string_between($this->cover, '/cover/', '.jpg');
            $thumb = str_replace('/cover/'.$cover, '/thumbnail/'.$this->imgur.'h', $this->cover);
            return $thumb;

        } else {
            return "https://i.imgur.com/".$this->imgur."h.jpg";
        }
    }

    public function thumb()
    {
        if (strpos($this->cover, 'cdn.jsdelivr.net') !== false) {
            $cover = Helper::get_string_between($this->cover, '/cover/', '.jpg');
            $thumb = str_replace('/cover/'.$cover, '/thumbnail/'.$this->imgur, $this->cover);
            return $thumb;

        } else {
            return "https://i.imgur.com/".$this->imgur.".jpg";
        }
    }

    public function vtt($lang)
    {
        $cover = Helper::get_string_between($this->cover, '/cover/', '.jpg');
        $vtt = str_replace('/cover/'.$cover.'.jpg', '/vtt/'.$this->id.'_'.$lang.'.vtt', $this->cover);
        return $vtt;
    }

    static function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public function scopeWhereHasTags($query, $tags, $count)
    {
        return $query->where(function($query) use ($tags) {
            foreach ($tags as $tag) {
                $query->orWhere('tags_array', 'ilike', '%"'.$tag.'"%');
            }
        })->where('uncover', false)
          ->select('id', 'title', 'cover')      
          ->inRandomOrder()
          ->limit($count);
    }

    public function scopeWhereOrderBy($query, $order, $count, $uncover)
    {
        if ($uncover) {
            $query = $query->where('uncover', false);
        }
        return $query->orderBy($order, 'desc')
                     ->select('id', 'title', 'cover', 'imgur')
                     ->limit($count);
    }
}
