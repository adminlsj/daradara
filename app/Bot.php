<?php

namespace App;

use App\Video;
use App\Watch;
use App\Motherless;
use Mail;
use Image;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use SteelyWing\Chinese\Chinese;
use simplehtmldom\HtmlWeb;
use Spatie\Browsershot\Browsershot;
use Storage;

class Bot extends Model
{
    protected $casts = [
        'data' => 'array'
    ];

	protected $fillable = [
        'id', 'temp', 'data', 'created_at',
    ];

    public static $models = [
        'avatars', 'blogs', 'bots', 'comments', 'likes', 'saves', 'subscribes', 'users', 'videos', 'watches'
    ];

    public static function setSitemap()
    {
        // ini_set('max_execution_time', 300);
        // ini_set('memory_limit', '-1');

        $videos = Video::where('cover', '!=', null)->orderBy('created_at', 'desc')->get();

        $presets = '<?xml version="1.0" encoding="UTF-8"?>
            <urlset
              xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
              xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
              xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
                    http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
              xmlns:video="http://www.google.com/schemas/sitemap-video/1.1"
              xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

        $homeMap = '
            <url>
              <loc>https://hanime1.me/</loc>
              <lastmod>'.Carbon::now()->format('Y-m-d\Th:i:s').'+00:00'.'</lastmod>
              <priority>1.00</priority>
            </url>';

        $videoMap = '';
        foreach ($videos as $video) {
            $single = '
            <url>
                <loc>https://hanime1.me/watch?v='.$video->id.'</loc>
                <lastmod>'.$video->updated_at.'</lastmod>
                <priority>0.90</priority>
                <video:video>
                   <video:thumbnail_loc>https://i.imgur.com/'.$video->imgur.'.jpg</video:thumbnail_loc>
                   <video:title>'.htmlspecialchars($video->title).'</video:title>
                   <video:description>'.htmlspecialchars($video->caption).'</video:description>';

                   if ($video->outsource) {
                       $single = $single.'<video:player_loc>'.htmlspecialchars($video->sd).'</video:player_loc>';
                   } else {
                        $single = $single.'<video:content_loc>'.htmlspecialchars($video->sd).'</video:content_loc>';
                   }

                $single = $single.'<video:view_count>'.$video->views.'</video:view_count>
                   <video:publication_date>'.Carbon::parse($video->created_at)->format('Y-m-d\Th:i:s').'+00:00'.'</video:publication_date>
                   <video:live>no</video:live>';
                   foreach ($video->tags() as $tag) {
                        $single = $single.'<video:tag>'.htmlspecialchars($tag).'</video:tag>';
                   }
                $single = $single.'</video:video>
                 <image:image>
                   <image:loc>https://i.imgur.com/'.$video->imgur.'.jpg</image:loc>
                   <image:title>'.htmlspecialchars($video->title).'</image:title>
                   <image:caption>'.htmlspecialchars($video->caption).'</image:caption>
                 </image:image>
            </url>';
            $videoMap = $videoMap.$single;
        }

        Storage::disk('local')->put('sitemap.xml', $presets.$homeMap.$videoMap.'</urlset>');
    }

    public static function updateAgefans(Bot $bot)
    {
        $current = Bot::get_string_between($bot->data['title'], '【第', '話】');
        $next = $current + 1;
        $title = str_replace('【第'.$current.'話】', '【第'.$next.'話】', $bot->data['title']);
        $next = $next < 10 ? '0'.$next : $next;
        $caption = str_replace('【第'.$current.'話】', '【第'.$next.'話】', $bot->data['title']);

        $url = explode('?', $bot->data['source'])[0];
        $query = explode('?', $bot->data['source'])[1];
        $playlist = explode('_', $query)[0];
        $episode = explode('_', $query)[1];
        $source = $url.'?'.$playlist.'_'.($episode + 1);

        $bot->data = [
            'name' => $bot->data['name'],
            'tags' => $bot->data['tags'],
            'imgur' => 'https://i.imgur.com/JJPMK1A.jpg',
            'title' => $title,
            'source' => $source,
            'caption' => $caption,
            'user_id' => $bot->data['user_id'],
            'playlist_id' => $bot->data['playlist_id'],
        ];
        $bot->save();
        return $bot;
    }

    public static function uploadUrlImage(String $url)
    {
        $image = Image::make($url);
        $image = $image->fit(2880, 1620);
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
        return $pms['data']['link'];
    }

    public static function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public static function is_mobile()
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
            return true;
        } else {
            return false;
        }
    }
}
