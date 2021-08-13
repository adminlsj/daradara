<?php

namespace App;

use App\Video;
use App\Helper;
use Carbon\Carbon;

class Cosplayjav
{
    public static $removed = [
        "1080p", "60fps", "jav_full_hd", "tagme actress", "tagme_actress", "jav", "sex", "720p", "anime", "video", "wings", "cosplay", "idolmaster", "cosplay_sex", "split_roast", "koshimizu_sachiko", "Sano_Ai", "idolmaster_cinderella_girls", "dressing", "Kosutchi", "lightning", "pantsu", "final_fantasy", "doujin"
    ];

    public static $translations = [
        "Lightning (ライトニング)" => '雷光',
        "pink_hair" => '粉髮',
        "Final Fantasy (ファイナルファンタジー)" => 'Final Fantasy',
        "Nidaime_tsubanomi_ojisan" => '二代目つば飲みおじさん',
        "Zennihon_Kameko_Kyoudou_Kumiai" => '全日本カメコ協同組合',
        "koshimizu sachiko (輿水幸子)" => '輿水幸子',
        "Idolmaster (アイドルマスター) Idolmaster cinderella girls (アイドルマスターシンデレラガールズ)" => '偶像大師 灰姑娘女孩',
        "school_uniform" => 'JK',
        "thighhighs" => '大腿襪',
        "膝下襪" => '大腿襪',
        "purple_hair" => '紫髮',
        "short_hair" => '短髮',
        "stockings" => '絲襪',
        "kneesocks" => '膝上襪',
        "group_sex" => '群交',
        "Sano Ai (佐野あい)" => '佐野愛',
        "sex_tozs" => '性玩具',
        "vibrator" => '跳蛋',
        "collar" => '項圈',
        "JAV_HD" => 'JAVHD',
        "skirt" => '迷你裙',
        "game" => '遊戲',
        "blowjob" => '口交',
        "blue_hair" => '藍髮',
        "creampie" => '內射',
        "cum_in_pussy" => '小穴內射',
        "dress" => '禮服',
        "Ganyu" => '甘雨',
        "Ganyu (Chinese: 甘雨 Gānyǔ, “Sweet Rain”)" => '甘雨',
        "genshin impact" => '原神',
        "genshin_impact" => '原神',
        "hair_pussy" => '黑森林',
        "high_heels" => '高跟鞋',
        "horns" => '魔角',
        "leggings" => '緊身褲',
        "long_hair" => '長髮',
        "sex_syndrome" => 'Sex Syndrome',
        "wafuku" => '和服',
    ];

    public static function uploadCosplayjav(String $url)
    {
        $curl_connection = curl_init($url);
        curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
        $html = curl_exec($curl_connection);
        curl_close($curl_connection);

        $title = trim(Helper::get_string_between($html, '<h1 class="post-title">', '</h1>'));

        $actress = trim(Helper::get_string_between($html, '<td>ACTRESS &#8211; </td>
<td>', '</td>
</tr>'));

        $anime = '';
        $anime_data = trim(Helper::get_string_between($html, '<td>ANIME/GAME SERIES &#8211; </td>
<td>', '</td>
</tr>'));
        $dom = new \DOMDocument();
        $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$anime_data);
        $links = $dom->getElementsByTagName('a');
        foreach ($links as $link) {
            $anime = $anime.$link->nodeValue.' ';
        }
        $anime = trim($anime);

        $character = trim(Helper::get_string_between($html, '<td>CHARACTER COSPLAY &#8211; </td>
<td>', '</td>
</tr>'));
        $character = explode('<br />', $character);
        $character = implode(' ', $character);

        $tags = '';
        $tags_array = [];
        $tags_data = trim(Helper::get_string_between($html, '<!--class="tag-disabled"-->', '<a href="javascript:;" onclick="showAllTags()" class="show-more-tags">(SHOW MORE TAGS)</a>'));
        $dom = new \DOMDocument();
        $dom->loadHTML('<meta http-equiv="content-type" content="text/html; charset=utf-8">'.$tags_data);
        $links = $dom->getElementsByTagName('a');
        foreach ($links as $link) {
            $tags = $tags.$link->nodeValue.' ';
        }
        $tags = trim($tags);
        $tags = explode(' , ', $tags);
        for ($i = 0; $i < count($tags); $i++) { 
           $tags[$i] = str_replace(' ', '_', $tags[$i]);
        }
        foreach ($tags as $tag) {
            $tags_array[$tag] = 10;
        }
        $tags = implode(' ', $tags);

        $cover = trim(Helper::get_string_between(Helper::get_string_between($html, '<div class="post-cover">', '</div>'), '<a href="', '"'));

        $date = trim(Helper::get_string_between($html, 'rel="bookmark">', '</a>'));
        /* $cover = explode('/', $cover);
        $base = array_pop($cover);
        $cover = implode('/', $cover) . '/' . urlencode($base);
        $image = Image::make($cover);
        $image = $image->fit(2880, 1620, null, 'top');
        $image = $image->stream();
        $pvars = array('image' => base64_encode($image));
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . '932b67e13e4f069'));
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
        $out = curl_exec($curl);
        curl_close ($curl);
        $pms = json_decode($out, true);
        $imgur = $pms['data']['link'];
        return $imgur; */
        $tags_array[$anime] = 10;
        $tags_array[$character] = 10;
        $tags_array[$actress] = 10;
        $tags_array['Cosplay'] = 10;
        $video = Video::create([
            'user_id' => 68458,
            'playlist_id' => 3135,
            'title' => $title,
            'translations' => ['JP' => $title],
            'caption' => $title,
            'imgur' => $cover,
            'tags' => $anime.' '.$character.' '.$actress.' Cosplay '.$tags,
            'tags_array' => $tags_array,
            'current_views' => 0,
            'views' => 0,
            'outsource' => true,
            'cover' => 'https://i.imgur.com/E6mSQA2.png',
            'foreign_sd' => ['cosplayjav' => $url],
            'created_at' => Carbon::createFromFormat('d F Y', $date),
            'uploaded_at' => Carbon::createFromFormat('d F Y', $date),
        ]);

        $translations = Cosplayjav::$translations;
        $removed = Cosplayjav::$removed;
        $tags_array = $video->tags_array;
        foreach (array_keys($tags_array) as $tag) {
            if (array_key_exists($tag, $translations)) {
                $tags_array[$translations[$tag]] = 10;
                unset($tags_array[$tag]);
            }
            if (in_array($tag, $removed)) {
                unset($tags_array[$tag]);
            }
        }
        $video->tags_array = $tags_array;
        $video->tags = implode(' ', array_keys($tags_array));

        $video->save();
    }

    public static function translateCosplayjav()
    {
        $videos = Video::where('foreign_sd', 'ilike', '%"cosplayjav"%')->where('tags_array', '!=', null)->where('created_at', '>=', Carbon::now()->subDays(30))->get();
        $translations = Cosplayjav::$translations;
        $removed = Cosplayjav::$removed;
        foreach ($videos as $video) {
            $tags_array = $video->tags_array;
            foreach (array_keys($tags_array) as $tag) {
                if (array_key_exists($tag, $translations)) {
                    $tags_array[$translations[$tag]] = 10;
                    unset($tags_array[$tag]);
                }
                if (in_array($tag, $removed)) {
                    unset($tags_array[$tag]);
                }
            }
            $video->tags_array = $tags_array;
            $video->tags = implode(' ', array_keys($tags_array));

            $video->save();
        }
    }
}
