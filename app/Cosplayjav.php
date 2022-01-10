<?php

namespace App;

use App\Video;
use App\Helper;
use Carbon\Carbon;

class Cosplayjav
{
    public static $removed = [
        "60fps", "jav_full_hd", "tagme actress", "tagme_actress", "jav", "sex", "720p", "anime", "video", "wings", "cosplay", "idolmaster", "cosplay_sex", "split_roast", "koshimizu_sachiko", "Sano_Ai", "idolmaster_cinderella_girls", "dressing", "Kosutchi", "lightning", "pantsu", "final_fantasy", "doujin", "imageset", "Dangan_ronpa", "Enoshima_Junko", "bondage", "bukkake", "SAIT-024", "anal_toys", "nishita_karina", "Nanpa_Mokushiroku", "Violet Evergarden", "Violet_Evergarden", "NCY-104", "astolfo", "fate/apocrypha", "touhou", "kirisame_marisa", "kirito", "SDAB-183", "SOD_Create", "Hayami_Nana", "tagme_series", "tagme_character", "sword_art_online", "MIAA-448", "fukada_eimi", "NieR_Automata", "Yorha_No.2_Type_B", "MMUS-053", "grinding", "handjob_cum", "tohsaka_rin", "Momose_Asuka", "fate_stay/night", "love_live!_sunshine!", "tagme character", "fate_series", "shinon", "full_hd", "HOIZ-022", "Wakamiya Hono (若宮穂乃), Sakuraba Hikari (桜庭ひかり), Inaba Ruka (稲場るか)", "cum_on_belly", "Mashu_Kyrielight", "NCYF-008", "tagme series (私にタグ シリーズ)", "Kuroki_Ikumi", "shuten_douji", "DBVB-024", "crossdresser", "xidaidai", "phone_ver", "vaginal_sticker", "phone_resolution", "tagme series (私にタグ シリーズ)", "feet", "solo", "eromanga_sensei", "keqing", "Xingqiu", "CPDE-048", "ANX-136", "yuuri_maina", "Saimin_Rei_Onna", "Sakurauchi_Riko", "aikatsu", "hoshimiya_ichigo", "Zero_Two", "hololive", "Shirogane_Noel", "Usada_Pekora", "medium_hair", "izayoi_sakuya", "CP_Denen", "Lumine", "COSX-010", "azur lane", "Atago_(azur_lane)", "kokoro", "NCYF-012", "Minatsuki_Hikaru", "princess_connect", "barbara", "Barbara_(genshin_impact)", "bodystocking", "cow_uniform", "ja_full_hd", "Nagisa_mowu_miao", "garter_straps", "yurippe", "angel_beats", "nakamura_yuri", "Boku_no_kanojo_wa_cosplayer", "abigail_williams", "amiya_(arknights)", "houshou_marine", "dildo_blowjob", "Atsuki", "Honolulu", "Honolulu_(azur_lane)", "gudako", "female_protagonist_(fate/grand_order)", "BDA-145", "Satou_Nonoka", "Cheshire", "censored_face", "Fischl", "fischl", "super_sonico", "cum_on_stockings", "Kamisato_Ayaka", "Raiden_Shogun", "Tsuki_desu", "sawamura_eriri_spancer", "saenai_heroine_no_sodatekata", "marie_rose", "dead_or_alive", "NCY-129", "gawr_gura", "male_anus_licking", "hataraku_saibou", "U-1196 / White blood cell", "480p", "sex_friend", "Roxy_Migurdia", "Mushoku_Tensei:_Isekai_Ittara_Honki_Dasu", "Kanna_Kamui", "kobayashi-san_chi_no_maid_dragon", "sakurajima_mai", "seishun_buta_yarou_wa_bunny_girl_senpai_no_yume_wo_minai", "fire_force", "tamaki_kotatsu", "fujiwara_chika", "rem", "Re:_Zero_kara_Hajimeru_Isekai_Seikatsu", "Katsushika_Hokusai", "Yokomiya_Nanami", "emilia", "kantai_collection", "taihou"
    ];

    public static $translations = [
        "taihou (kantai collection)" => '大鳳',
        "Kantai Collection (艦隊これくしょん)" => '艦隊Collection',
        "Emilia (エミリア)" => '愛蜜莉雅',
        "Otokohime" => '男姫',
        "Otohime" => '男姫',
        "Kirisaki_Chitoge" => '桐崎千棘',
        "deai_CHU" => '出会いCHU',
        "nisekoi" => '偽戀',
        "Yokomiya Nanami (横宮七海)" => '横宮七海',
        "Saikyou_Zokusei" => '最強属性',
        "Katsushika Hokusai (葛飾北斎)" => '葛飾北齋',
        "Shiro_Ando" => '白餡堂',
        "blindfold" => '眼罩',
        "wedding_dress" => '婚紗',
        "Rem (レム)" => '雷姆',
        "Fujiwara Chika (藤原 千花)" => '藤原千花',
        "fire force" => '炎炎消防隊',
        "tamaki kotatsu (環古達)" => '環古達',
        "Seishun Buta Yarou wa Bunny Girl Senpai no Yume wo Minai (青春ブタ野郎はバニーガール先輩の夢を見ない)" => '青春豬頭少年不會夢到兔女郎學姊',
        "Sakurajima Mai (桜島 麻衣)" => '櫻島麻衣',
        "ponytail" => '馬尾',
        "Kobayashi-san-chi no Maid Dragon (小林さんちのメイドラゴン)" => '小林家的龍女僕',
        "Kanna Kamui (カンナカムイ)" => '康娜卡姆依',
        "sweet_lolita_dress" => '甜系蘿莉塔',
        "sweet_lolita" => '甜系蘿莉塔',
        "mask" => '面罩',
        "Mushoku Tensei: Isekai Ittara Honki Dasu" => '無職轉生～到了異世界就拿出真本事～',
        "Roxy Migurdia (ロキシー・ミグルディ)" => '洛琪希·米格路迪亞',
        "SexFriend" => 'Sex Friend',
        "White_blood_cell" => '白血球',
        "Hataraku Saibou (はたらく細胞)" => '工作細胞',
        "gawr gura (がうる・ぐら)" => '噶嗚·古拉',
        "rimjob" => '毒龍鑽',
        "Dead or alive (デッドオアアライブ)" => '生死格鬥系列',
        "Marie Rose (マリー・ローズ)" => '瑪麗·蘿絲',
        "gothic_lolita_dress" => '哥德蘿莉塔',
        "goth_lolita_dress" => '哥德蘿莉塔',
        "gothic_lolita" => '哥德蘿莉塔',
        "goth_lolita" => '哥德蘿莉塔',
        "sawamura eriri spancer (澤村・スペンサー・英梨々)" => '澤村·史賓瑟·英梨梨',
        "saenai heroine no sodatekata (冴えない彼女の育てかた )" => '不起眼女主角培育法',
        "shaced_pussy" => '白虎',
        "uncensored" => '無碼',
        "green_hair" => '綠髮',
        "foreigner" => '外國人',
        "glasses" => '眼鏡娘',
        "Sucrose" => '砂糖',
        "braid" => '辮子',
        "Raiden Shogun (雷電将軍)" => '雷電將軍',
        "Kamisato Ayaka (神里綾華)" => '神里綾華',
        "Nidaime_tsubanomi_ojisam" => '二代目つば飲みおじさん',
        "Super Sonico (すーぱーそに子)" => '超級索尼子',
        "nurse_uniform" => '女醫護士',
        "cum_on_legs" => '腿射',
        "yukata" => '和服',
        "Fischl_(genshin_impact)" => '菲謝爾',
        "plugsuit" => '作戰服',
        "Cheshire (CN: 柴郡 · JP: チェシャー)" => '柴郡',
        "Satou Nonoka (佐藤ののか)" => '佐藤乃乃果',
        "Face_sitting" => '顏面騎乘',
        "mousouzoku" => '妄想族',
        "footjob" => '腳交',
        "Bermuda" => 'バミューダ',
        "fate series (フェイト・シリーズ) fate/grand order" => 'Fate系列',
        "Gudako (ぐだ子) / female protagonist (fate/grand order)" => '藤丸立香',
        "cosplay_ippon_shoubu" => 'コスプレ一本勝負',
        "side_ponytail" => '馬尾',
        "orange_hair" => '橘髮',
        "Honolulu (azur lane) CN: 火奴鲁鲁 · JP: ホノルル" => '火奴魯魯',
        "Atsuki (あつき)" => 'あつき',
        "shower" => '洗澡',
        "houshou marine (宝鐘マリン)" => '寶鐘瑪琳',
        "amiya (arknights)" => '阿米婭',
        "arknights" => '明日方舟',
        "fate/grand order" => 'Fate/Grand Order',
        "abigail williams (アビゲイル・ウィリアムズ)" => '艾比蓋兒·威廉斯',
        "ball_sucking" => '舔蛋蛋',
        "ball_licking" => '舔蛋蛋',
        "bikini" => '比基尼',
        "Nakamura Yuri (仲村 ゆり) “yurippe”" => '仲村百合',
        "angel beats (エンジェルビーツ)" => '天使的脈動',
        "lingerie" => '性感內衣',
        "garter_belt" => '吊襪帶',
        "Nagisa mowu miao (nagisa魔物喵)" => 'nagisa魔物喵',
        "Barbara (genshin impact)" => '芭芭拉',
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
