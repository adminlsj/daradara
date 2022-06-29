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
}
