<?php

namespace App;

use App\Comic;
use App\Helper;
use Carbon\Carbon;

class Nhentai
{
    public static $parseExt = [
        'j' => 'jpg',
        'p' => 'png'
    ];

    public static $tags = [
        "group" => '群交',
        "stockings" => '絲襪', 
        "schoolgirl uniform" => 'JK制服', 
        "glasses" => '眼鏡娘', 
        "nakadashi" => '中出', 
        "blowjob" => '口交', 
        "incest" => '近親', 
        "tankoubon" => '單行本', 
        "impregnation" => '受孕', 
        "schoolboy uniform" => 'DK制服', 
        "bbm" => '黑肉棒', 
        "story arc" => '劇情向', 
        "pregnant" => '懷孕', 
        "sweating" => '大汗淋漓', 
        "handjob" => '手交', 
        "bbw" => '肉感女', 
        "daughter" => '女兒',
        "anal" => '肛門',
        "yaoi" => '耽美', 
        "males only" => '只有男性', 
        "full censorship" => '全碼', 
        "multi-work series" => '橫跨系列', 
        "muscle" => '肌肉', 
        "anal intercourse" => '肛交',
        "big breasts" => '巨乳', 
        "sole female" => '女獨秀', 
        "sole male" => '男獨秀', 
        '單女' => '女獨秀',
        '單男' => '男獨秀',
        "shotacon" => '正太控', 
        "milf" => '熟女', 
        "hairy" => '黑森林', 
        "mother" => '母', 
        "sunglasses" => '墨鏡', 
        "mouth mask" => '口罩', 
        "artistcg" => 'CG繪畫',
        "defloration" => '破處',
        "x-ray" => '透視',
        "ffm threesome" => '兩女一男3P',
        "urination" => '放尿',
        "multimouth blowjob" => '多重口交',
        "paizuri" => '乳交',
        "very long hair" => '極長髮',
        "pantyhose" => '連褲襪',
        "cheating" => '偷吃',
        "beauty mark" => '美人痣',
        "cousin" => '表親',
        "bondage" => '束縛',
        "sex toys" => '性玩具', 
        "femdom" => '女王樣', 
        "collar" => '項圈', 
        "sister" => '姐妹', 
        "crossdressing" => '異性裝扮', 
        "lingerie" => '情趣內衣', 
        "uncensored" => '無碼', 
        "gag" => '搞笑', 
        "gloves" => '手套', 
        "urethra insertion" => '尿道插入', 
        "latex" => '皮衣', 
        "shibari" => '綁縛', 
        "bisexual" => '雙性戀', 
        "twins" => '雙胞胎', 
        "corset" => '馬甲', 
        "shimaidon" => '姐妹丼',
        "double penetration" => '雙洞齊下',
        "dilf" => '熟男',
        "ponytail" => '單馬尾',
        "twintails" => '雙馬尾',
        "mmf threesome" => '兩男一女3P', 
        "drugs" => '藥物', 
        "condom" => '安全套', 
        "tanlines" => '曬痕', 
        "drunk" => '醉酒', 
        "bandages" => '繃帶', 
        "sarashi" => '白布',
        "doujinshi" => '同人誌',
        "full color" => '全彩',
        "fingering" => '指交', 
        "blindfold" => '眼罩', 
        "coach" => '教練',
        "ahegao" => '阿嘿顏', 
        "mosaic censorship" => '半碼',
        "kemonomimi" => '獸耳', 
        "tail" => '尾巴',
        "lolicon" => '蘿莉控', 
        "low lolicon" => '低階蘿莉控',
        "big penis" => '大屌', 
        "gyaru" => '辣妹', 
        "domination loss" => '攻轉受',
        "yuri" => '百合', 
        "females only" => '只有女性',
        "comic" => '漫畫', 
        "western" => '西方',
        "small penis" => '小屌',
        "prostitution" => '風俗娘',
        "futanari" => '扶他', 
        "dark skin" => '黑皮膚', 
        "mind break" => '精神崩潰', 
        "garter belt" => '吊帶襪', 
        "demon girl" => '惡魔', 
        "scat" => '鬼畜', 
        "kissing" => '親吻', 
        "rimjob" => '毒龍鑽', 
        "monster girl" => '魔物娘', 
        "horns" => '魔角', 
        "smell" => '體臭', 
        "nun" => '修女', 
        "farting" => '放屁', 
        "coprophagia" => '食糞',
        "shared senses" => '共享感官',
        "elf" => '妖精', 
        "hairy armpits" => '腋毛', 
        "smegma" => '包皮垢', 
        "goblin" => '哥布林',
        "tomgirl" => '娘娘腔',
        "footjob" => '腳交', 
        "prostate massage" => '前列腺按摩', 
        "spanking" => '打屁股', 
        "bdsm" => 'BDSM', 
        "yandere" => '病嬌',
        "rape" => '強制', 
        "scanmark" => '附註', 
        "scar" => '疤痕', 
        "mind control" => '精神控制', 
        "sleeping" => '睡姦', 
        "piercing" => '穿環', 
        "manga" => '漫畫', 
        "swimsuit" => '泳裝', 
        "teacher" => '老師', 
        "facial hair" => '鬍鬚', 
        "oyakodon" => '母女丼', 
        "vomit" => '嘔吐', 
        "dark nipples" => '黑乳頭', 
        "webtoon" => 'Webtoon', 
        "kimono" => '和服', 
        "teacher" => '老師', 
        "nurse" => '護士', 
        "focus anal" => '肛門注目', 
        "mmm threesome" => '男男男3P', 
        "policewoman" => '女警',
        "unusual pupils" => '異型瞳',
        "deepthroat" => '深喉',
        "deepthroat" => '虛擬YouTuber',
        "dick growth" => '肉棒成長', 
        "dickgirl on male" => '扶他幹男性', 
        "snuff" => '鼻菸', 
        "guro" => '獵奇', 
        "vampire" => '吸血鬼', 
        "filming" => '攝影', 
        "bloomers" => '燈籠褲', 
        "tracksuit" => '運動服', 
        "masturbation" => '自慰', 
        "non-h" => '非色情', 
        "christmas" => '聖誕節', 
        "deer girl" => '麋鹿女', 
        "bikini" => '比基尼', 
        "cowgirl" => '女上位', 
        "soushuuhen" => '總集篇', 
        "tutor" => '導師',
        "cunnilingus" => '舐陰',
        "virginity" => '童貞',
        "oil" => '潤滑油',
        "school swimsuit" => '死庫水',
        "dog girl" => '碧池',
        "harem" => '後宮',
        "gender bender" => '中性人',
        "solo action" => '單人秀',
        "big clit" => '大陰蒂',
        "wings" => '翅膀',
        "netorare" => 'NTR',
        "big ass" => '大屁股',
        "hidden sex" => '暗示性交',
        "exhibitionism" => '露體癖',
        "voyeurism" => '偷窺',
        "lactation" => '噴奶',
        "maid" => '女僕',
        "frottage" => '摩擦', 
        "demon" => '惡魔',
        "watermarked" => '水印',
        "ghost" => '幽靈',
        "ryona" => '凌虐',
        "dismantling" => '摧毀',
        "crotch tattoo" => '淫紋',
        "fox girl" => '狐狸女',
        "wolf girl" => '狼女',
        "blackmail" => '勒索',
        "tomboy" => '假小子',
        "anthology" => '精選集',
        "small breasts" => '貧乳',
        "chinese dress" => '旗袍',
        "cheerleader" => '啦啦隊',
        "tentacles" => '觸手',
        "monster" => '怪獸',
        "birth" => '分娩',
        "body writing" => '身體寫字',
        "gothic lolita" => '哥德蘿莉塔',
        "bukkake" => '顏射',
        "corruption" => '精神侵蝕',
        "business suit" => '西裝', 
        "stuck in wall" => '卡牆', 
        "catgirl" => '貓娘', 
        "bunny girl" => '兔女郎', 
        "slave" => '奴隸',
        "chikan" => '痴漢',
        "shimapan" => '條紋內褲',
        "breast feeding" => '哺乳',
        "old man" => '老男人',
        "military" => '軍裝',
        "public use" => '肉便器',
        "inflation" => '爆精',
        "miko" => '巫女',
        "nose hook" => '鼻勾',
        "time stop" => '時間停止',
        "magical girl" => '魔法少女',
        "apron" => '圍裙',
        "tribadism" => '女陰摩擦',
        "foot licking" => '舔腳',
        "inseki" => '姻親',
        "torture" => '折磨',
        "leotard" => '緊身連衣褲',
        "oppai loli" => '童顏巨乳',
        "huge breasts" => '豪乳',
        "armpit licking" => '舔腋下',
        "armpit sex" => '腋交',
    ];

    public static $languages = [
        "japanese" => '日本語', 
        "translated" => '翻譯', 
        "chinese" => '中文',
        "english" => '英語',
    ];

    public static $categories = [
        "doujinshi" => '同人誌', 
        "manga" => '漫畫', 
        "non-h" => '一般向',
    ];

    public static $columns = [
        "parodies" => '同人', 
        "characters" => '角色', 
        "tags" => '標籤',
        "artists" => '作者',
        "groups" => '社團',
        "languages" => '語言',
        "categories" => '分類',
    ];

    public static function translateNhentaiTags()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $comics = Comic::where('tags', '!=', null)->orderBy('id', 'asc')->get();
        $translations = Nhentai::$tags;
        foreach ($comics as $comic) {
            $tags = $comic->tags;
            foreach ($tags as &$tag) {
                if (array_key_exists($tag, $translations)) {
                    $tag = $translations[$tag];
                }
            }
            $comic->tags = $tags;
            $comic->save();
        }
    }

    public static function translateNhentaiLanguages()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $comics = Comic::where('languages', '!=', null)->orderBy('id', 'asc')->get();
        $translations = Nhentai::$languages;
        foreach ($comics as $comic) {
            $languages = $comic->languages;
            foreach ($languages as &$language) {
                if (array_key_exists($language, $translations)) {
                    $language = $translations[$language];
                }
            }
            $comic->languages = $languages;
            $comic->save();
        }
    }

    public static function translateNhentaiCategories()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        $comics = Comic::where('categories', '!=', null)->orderBy('id', 'asc')->get();
        $translations = Nhentai::$categories;
        foreach ($comics as $comic) {
            $categories = $comic->categories;
            foreach ($categories as &$category) {
                if (array_key_exists($category, $translations)) {
                    $category = $translations[$category];
                }
            }
            $comic->categories = $categories;
            $comic->save();
        }
    }
}
