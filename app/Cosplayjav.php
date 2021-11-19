<?php

namespace App;

use App\Video;
use App\Helper;
use Carbon\Carbon;

class Cosplayjav
{
    public static $removed = [
        "1080p", "60fps", "jav_full_hd", "tagme actress", "tagme_actress", "jav", "sex", "720p", "anime", "video", "wings", "cosplay", "idolmaster", "cosplay_sex", "split_roast", "koshimizu_sachiko", "Sano_Ai", "idolmaster_cinderella_girls", "dressing", "Kosutchi", "lightning", "pantsu", "final_fantasy", "doujin", "imageset", "Dangan_ronpa", "Enoshima_Junko", "bondage", "bukkake", "SAIT-024", "anal_toys", "nishita_karina", "Nanpa_Mokushiroku", "Violet Evergarden", "Violet_Evergarden", "NCY-104", "astolfo", "fate/apocrypha", "touhou", "kirisame_marisa", "kirito", "SDAB-183", "SOD_Create", "Hayami_Nana", "tagme_series", "tagme_character", "sword_art_online", "MIAA-448", "fukada_eimi", "NieR_Automata", "Yorha_No.2_Type_B", "MMUS-053", "grinding", "handjob_cum", "tohsaka_rin", "Momose_Asuka", "fate_stay/night", "love_live!_sunshine!", "tagme character", "fate_series", "shinon", "full_hd", "HOIZ-022", "Wakamiya Hono (若宮穂乃), Sakuraba Hikari (桜庭ひかり), Inaba Ruka (稲場るか)", "cum_on_belly", "Mashu_Kyrielight", "NCYF-008", "tagme series (私にタグ シリーズ)", "Kuroki_Ikumi", "shuten_douji", "DBVB-024", "crossdresser", "xidaidai", "phone_ver", "vaginal_sticker", "phone_resolution", "tagme series (私にタグ シリーズ)", "feet", "solo", "eromanga_sensei", "keqing", "Xingqiu", "CPDE-048", "ANX-136", "yuuri_maina", "Saimin_Rei_Onna", "Sakurauchi_Riko", "aikatsu", "hoshimiya_ichigo", "Zero_Two", "hololive", "Shirogane_Noel", "Usada_Pekora", "medium_hair", "izayoi_sakuya", "CP_Denen", "Lumine", "COSX-010", "azur lane", "Atago_(azur_lane)", "kokoro", "NCYF-012", "Minatsuki_Hikaru", "princess_connect"
    ];

    public static $translations = [
        "Princess Connect! (プリンセスコネクト！)" => '超異域公主連結☆Re:Dive',
        "Minatsuki_Hikaru" => '皆月ひかる',
        "Minatsuki Hikaru (皆月ひかる)" => '皆月光',
        "Kokoro (ココロ)" => '可可蘿',
        "pointed_ears" => '尖耳朵',
        "mini" => '迷你',
        "6M1G" => '6男1女',
        "elf" => '妖精',
        "Uncle_rubbing_Pacohame" => 'こすパコハメ撮りおじさん',
        "Atago (azur lane) (愛宕)" => '愛宕',
        "race_queen" => '賽車女郎',
        "big_boobs" => '巨乳',
        "azur_lane" => '碧藍航線',
        "Izayoi Sakuya (十六夜咲夜)" => '十六夜咲夜',
        "Lumine / CN: Ying (荧) JP: Hotaru (蛍) KR: Hyeong (형)" => '熒',
        "Horikita Wan (堀北わん)" => '堀北灣',
        "Usada Pekora (兎田ぺこら)" => '兔田佩克拉',
        "bunny_uniform" => '兔女郎',
        "twin_braids" => '雙馬辮',
        "Shirogane Noel (白銀ノエル)" => '白銀諾艾爾',
        "hololive (ホロライブ)" => 'Hololive',
        "vtuber" => '虛擬YouTuber',
        "Zero Two" => '02',
        "DARLING in the FRANXX (ダーリン・イン・ザ・フランキス)" => 'DARLING in the FRANXX',
        "hoshimiya ichigo (星宮いちご)" => '星宮莓',
        "Aikatsu (アイカツ！)" => '偶像學園',
        "Yuuri Maina (優梨まいな)" => '優梨舞奈', 
        "Sakurauchi Riko (桜内 梨子)" => '櫻內梨子',
        "Saimin_Kenkyuusho_Bekkan" => '催眠研究所別館',
        "Love Live! Sunshine!!" => 'Love Live! Sunshine!!',
        "swimsuit" => '泳裝',
        "red_hair" => '紅髮',
        "Sakurai Chiharu (桜井千春)" => '櫻井千春',
        "keqing (刻晴)" => '刻晴',
        "priest_uniform" => '修女',
        "prestige" => 'PRESTIGE',
        "assjob" => '素股',
        "Keqing (Chinese: 刻晴 Kèqíng, &#8220;Sunny Moment&#8221; or &#8220;Delicate Carving&#8221;)" => '刻晴',
        "Xingqiu (Chinese: 行秋 Xíngqiū, &#8220;Progression of Autumn&#8221;)" => '行秋',
        "Izumi Sagiri (和泉 紗霧)" => '和泉紗霧',
        "Eromanga Sensei (エロマンガ先生)" => '情色漫畫老師',
        "pantyhose" => '連褲襪',
        "dildo_footjob" => '腳交',
        "maid_uniform" => '女僕',
        "cat_tail" => '貓尾巴',
        "pajamas" => '睡衣',
        "selfie" => '自拍',
        "appron" => '圍裙',
        "tail" => '尾巴',
        "xidaidai [習呆呆]" => '習呆呆',
        "nipple_stickers" => '乳貼',
        "Orange_Misa" => 'Orange Misa',
        "bodysuit" => '連體緊身衣',
        "Felix Argail / Ferris (フェリックス・アーガイル / フェリス)" => '菲利克斯·阿吉爾',
        "Tamamo no Mae (玉藻の前)" => '玉藻前',
        "Re: Zero kara Hajimeru Isekai Seikatsu (Re：ゼロから始める異世界生活 )" => 'Re：從零開始的異世界生活',
        "Satsuki (さつき)" => 'Satsuki',
        "crossdress" => '異性裝扮',
        "brown_hair" => '棕髮',
        "fox_ears" => '狐狸耳',
        "cat_ears" => '貓耳',
        "gay" => '耽美',
        "Shuten Douji (酒呑童子)" => '酒吞童子',
        "Punimoe" => 'ぷにもえ！',
        "Kuroki Ikumi (黒木いくみ)" => '黑木郁美',
        "double_handjob" => '雙重手交',
        "pussy_licking" => '舔穴',
        "kimono" => '和服',
        "fishnet_stockings" => '網襪',
        "Mashu Kyrielight (マシュ・キリエライト) / Shielder" => '瑪修·基利艾拉特',
        "fate/grand_order" => 'Fate/Grand Order',
        "Shirouto_Hoihoi" => '素人ホイホイ',
        "Sakuraba_Hikari" => '櫻庭光',
        "Wakamiya_Hono" => '若宮穂乃',
        "cum_in_mouth" => '口爆',
        "cum_on_body" => '體外射精',
        "animal_tail" => '尾巴',
        "animal_ears" => '獸耳',
        "bunny_tail" => '兔尾巴',
        "bunny_ears" => '兔耳',
        "Inaba_Ruka" => '稻場流花',
        "breastjob" => '乳交',
        "Mousozoku" => '妄想族',
        "shinon (シノン)" => '詩乃',
        "thigh_boots" => '大腿靴',
        "grey_hair" => '灰髮',
        "love live! sunshine! (ラブライブ！サンシャイン!! )" => 'Love Live! Sunshine!!',
        "fate stay/night" => 'Fate/stay night',
        "fate series (フェイト・シリーズ)" => "Fate系列",
        "Tohsaka Rin (遠坂凛)" => '遠坂凜',
        "Momose Asuka (百瀬あすか)" => '百瀨飛鳥',
        "sailor_uniform" => '水手服',
        "petting" => '愛撫',
        "NieR Automata (ニエル オートマトン)" => '尼爾：自動人形',
        "Yorha No.2 Type B (ヨルハ2号B型)" => '寄葉2號B型',
        "Fukada Eimi (深田えいみ)" => '深田詠美',
        "white_hair" => '白髮',
        "cum_on_bod" => '體外射精',
        "3M1G" => '3男1女',
        "2M1G" => '2男1女',
        "Sword Art Online (ソードアート・オンライン)" => '刀劍神域',
        "Kirito (キリト)" => '桐人',
        "Hayami Nana (早見なな)" => '早見奈奈',
        "SOD_Create" => 'SODクリエイト',
        "Seishun_Jidai" => '青春時代',
        "gym_uniform" => '體操服',
        "black_hair" => '黑髮',
        "fingering" => '指交',
        "shorts" => '熱褲',
        "Kirisame Marisa (霧雨魔理沙)" => '霧雨魔理沙',
        "Touhou (東方)" => '東方Project',
        "masturbate" => '自慰',
        "socks" => '襪子',
        "5M1G" => '5男1女',
        "fate series (フェイト・シリーズ) fate/apocrypha" => 'Fate/Apocrypha',
        "Zen_nihon_Kameko_kyoudou_kumiai" => '全日本カメコ協同組合',
        "astolfo (アストルフォ)" => '阿斯托爾福',
        "cum_on_boobs" => '乳射',
        "thong" => '丁字褲',
        "Violet Evergarden (ヴァイオレット・エヴァーガーデン)" => '紫羅蘭永恆花園',
        "Nishita Karina (西田カリナ)" => '西田卡莉娜',
        "double_penetration" => '雙洞齊下',
        "butt_plug" => '肛門塞',
        "sex_toys" => '性玩具',
        "pillory" => '頸手枷',
        "facial" => '顏射',
        "rope" => '綑綁',
        "bdsm" => 'BDSM',
        "anal" => '肛交',
        "enoshima junko (江ノ島盾子)" => '江之島盾子', 
        "dangan ronpa (ダンガンロンパ)" => '槍彈辯駁',
        "shaved_pussy" => '白虎',
        "twin_tails" => '雙馬尾',
        "cum_on_ass" => '臀射',
        "handjob" => '手交',
        "blonde" => '金髮',
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
        "kneehighs" => '膝上襪',
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
        "dildo" => '假屌',
        "shielder" => 'Shielder',
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
        $videos = Video::where('foreign_sd', 'ilike', '%"cosplayjav"%')->where('tags_array', '!=', null)->orderBy('created_at', 'desc')->limit(10)->get();
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
