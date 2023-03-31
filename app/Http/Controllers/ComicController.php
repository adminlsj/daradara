<?php

namespace App\Http\Controllers;

use App\Comic;
use App\Nhentai;
use App\Helper;
use Illuminate\Http\Request;
use Redirect;
use Storage;

class ComicController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->has('query') || $request->page == 1) {
            $trending = Comic::orderBy('day_views', 'desc')->select('id', 'nhentai_id', 'galleries_id', 'title_n_before', 'title_n_pretty', 'title_n_after', 'extension', 'prefix', 'created_at')->limit(6)->get();
        } else {
            $trending = null;
        }
        $newest = Comic::orderBy('created_at', 'desc')->select('id', 'nhentai_id', 'galleries_id', 'title_n_before', 'title_n_pretty', 'title_n_after', 'extension', 'prefix', 'created_at')->paginate(30);

        $newest->setPath('');

        return view('comic.index', compact('trending', 'newest'));
    }

    public function showCover(Request $request)
    {
        $cid = $request->comic;
        if (is_numeric($cid) && $comic = Comic::find($cid)) {

            $metadata = ['parodies' => $comic->parodies, 'characters' => $comic->characters, 'tags' => $comic->tags, 'artists' => $comic->artists, 'groups' => $comic->groups, 'languages' => $comic->languages, 'categories' => $comic->categories];

            $comics = null;
            if ($comic->playlist_id) {
                $comics = Comic::where('playlist_id', $comic->playlist_id)->orderBy('created_at', 'desc')->get();
            } else {
                if (!empty($comic->title_o_pretty)) {
                    $title = explode(' ', $comic->title_o_pretty)[0];
                    $column = 'title_o_pretty';
                } elseif (!empty($comic->title_n_pretty)) {
                    $title = explode(' ', $comic->title_n_pretty)[0];
                    $column = 'title_n_pretty';
                }
                $title = preg_split('//u', $title, -1, PREG_SPLIT_NO_EMPTY);
                array_pop($title);
                array_pop($title);
                $title = '%'.implode($title).'%';
                if ($comic->artists != []) {
                    $comics = Comic::where('artists', 'like', '%'.$comic->artists[0].'%')->where($column, 'like', $title)->orderBy('created_at', 'desc')->limit(12)->get();
                } elseif ($comic->groups != []) {
                    $comics = Comic::where('groups', 'like', '%'.$comic->groups[0].'%')->where($column, 'like', $title)->orderBy('created_at', 'desc')->limit(12)->get();
                }
            }

            $tags = $tags_random = $comic->tags;
            shuffle($tags_random);
            $tags_slice = array_slice($tags_random, 0, 2);
            $related = Comic::where(function($query) use ($tags_slice) {
                foreach ($tags_slice as $tag) {
                    $tag = Helper::convertBin2hex($tag);
                    $query->orWhere('searchtext', 'like', '%'.$tag.'%');
                }
            })->orderBy('day_views', 'desc')->limit(500)->pluck('id')->toArray();

            $count = count($related);
            if ($count <= 1) {
                $related = Comic::where('id', $related)->select('id', 'nhentai_id', 'galleries_id', 'title_n_before', 'title_n_pretty', 'title_n_after', 'extension', 'prefix', 'created_at')->get();
            } else {
                $selected = $count < 6 ? $count : 6;
                $related = array_rand($related, $selected);
                $related = Comic::select('id', 'nhentai_id', 'galleries_id', 'title_n_before', 'title_n_pretty', 'title_n_after', 'extension', 'prefix', 'created_at')->find($related);
            }

            $prefix = '';
            $prefix_t = '';
            $is_nhentai = true;
            if ($comic->nhentai_id != null) {
                $prefix = 'https://i.nhentai.net/galleries/'.$comic->galleries_id.'/';
                $prefix_t = 'https://t.nhentai.net/galleries/'.$comic->galleries_id.'/';
            } else {
                $prefix = $prefix_t = $comic->prefix;
                $is_nhentai = false;
            }

            return view('comic.show-cover', compact('comic', 'comics', 'metadata', 'related', 'prefix', 'prefix_t', 'is_nhentai'));

        } else {
            abort(404);
        }
    }

    public function showContent(Request $request)
    {
        $cid = $request->comic;
        if (is_numeric($cid) && $comic = Comic::find($cid)) {

            $page = $request->page;

            if ($page < 1) return redirect()->action('ComicController@showContent', ['comic' => $comic, 'page' => 1]);
            if ($page > $comic->pages) return redirect()->action('ComicController@showContent', ['comic' => $comic, 'page' => $comic->pages]);

            $extensions = json_encode($comic->extensions);

            $comic->day_views++;
            $comic->week_views++;
            $comic->views++;
            $comic->save();

            $prefix = '';
            $is_nhentai = true;
            if ($comic->nhentai_id != null) {
                $prefix = 'https://i.nhentai.net/galleries/'.$comic->galleries_id.'/';
            } else {
                $prefix = $comic->prefix;
                $is_nhentai = false;
            }

            return view('comic.show-content', compact('comic', 'page', 'extensions', 'prefix', 'is_nhentai'));

        } else {
            abort(404);
        }
    }

    public function showTags(Request $request)
    {
        $column = $request->column;
        if (!in_array($column, ['tags', 'artists', 'characters', 'parodies', 'groups'])) {
            abort(404);
        }
        $tags = json_decode(Nhentai::${$column.'_array'}, true);
        return view('comic.show-tags', compact('column', 'tags'));
    }

    public function search(Request $request)
    {
        $query = strlen(request('query')) > 1000 ? abort(404) : request('query');
        $query = strtolower($query);
        $query = preg_replace('/\s+/', '', $query);
        $query = preg_split('//u', $query, -1, PREG_SPLIT_NO_EMPTY);
        foreach ($query as &$character) {
            if (strlen($character) != mb_strlen($character, 'utf-8')) {
                $character = bin2hex(iconv('UTF-8', 'UTF-16BE', $character));
            }
        }
        $query = '%'.implode($query).'%';
        $comics = Comic::where('searchtext', 'like', $query);

        switch (request('sort')) {
            case 'popular-today':
                $comics = $comics->orderBy('day_views', 'desc');
                break;

            case 'popular-week':
                $comics = $comics->orderBy('week_views', 'desc');
                break;

            case 'popular':
                $comics = $comics->orderBy('views', 'desc');
                break;
            
            default:
                $comics = $comics->orderBy('created_at', 'desc');
                break;
        }

        $comics = $comics->select('id', 'nhentai_id', 'galleries_id', 'title_n_before', 'title_n_pretty', 'title_n_after', 'extension', 'prefix', 'created_at')->paginate(30);

        $comics->setPath('');
        
        return view('comic.search', compact('comics', 'query'));
    }

    public function searchTags(String $column, String $value, String $time = null)
    {
        if (!in_array($column, array_keys(Nhentai::$columns))) {
            abort(404);
        }

        // $comics = Comic::where($column, 'like', '%"'.$value.'"%');

        $query = strlen($value) > 1000 ? abort(404) : $value;
        $query = strtolower($query);
        $query = preg_replace('/\s+/', '', $query);
        $query = preg_split('//u', $query, -1, PREG_SPLIT_NO_EMPTY);
        foreach ($query as &$character) {
            if (strlen($character) != mb_strlen($character, 'utf-8')) {
                $character = bin2hex(iconv('UTF-8', 'UTF-16BE', $character));
            }
        }
        $query = '%'.implode($query).'%';
        $comics = Comic::where('searchtext', 'like', $query);

        switch ($time) {
            case 'popular-today':
                $comics = $comics->orderBy('day_views', 'desc');
                break;

            case 'popular-week':
                $comics = $comics->orderBy('week_views', 'desc');
                break;

            case 'popular':
                $comics = $comics->orderBy('views', 'desc');
                break;
            
            default:
                $comics = $comics->orderBy('created_at', 'desc');
                break;
        }

        $comics = $comics->select('id', 'nhentai_id', 'galleries_id', 'title_n_before', 'title_n_pretty', 'title_n_after', 'extension', 'prefix', 'created_at')->paginate(30);

        $comics->setPath('');

        $count = $comics->total();

        return view('comic.search-tags', compact('comics', 'column', 'value', 'count'));
    }

    public function getRandomComic()
    {
        $random = Comic::inRandomOrder()->select('id')->first();
        return response()->json([
            'id' => $random->id,
        ]);
    }

    public function renameComicImages()
    {
        $loop = 0;
        $images = Storage::disk('local')->files('video');
        foreach ($images as $image) {
            $extension = explode('.', $image)[1];
            if ($extension == 'jpg') {
                if ($loop < 10) {
                    Storage::disk('local')->move($image, "video/00{$loop}.jpg");
                } elseif ($loop < 100) {
                    Storage::disk('local')->move($image, "video/0{$loop}.jpg");
                } else {
                    Storage::disk('local')->move($image, "video/{$loop}.jpg");
                }
                $loop++;
            }
        }
    }

    public function uploadComicFrom431()
    {
        $existing = Comic::find(431);
        $comic = Comic::create([
            'nhentai_id' => $existing->nhentai_id,
            'galleries_id' => $existing->galleries_id,
            'title_n_before' => $existing->title_n_before,
            'title_n_pretty' => $existing->title_n_pretty,
            'title_n_after' => $existing->title_n_after,
            'title_o_before' => $existing->title_o_before,
            'title_o_pretty' => $existing->title_o_pretty,
            'title_o_after' => $existing->title_o_after,
            'parodies' => $existing->parodies,
            'characters' => $existing->characters,
            'tags' => $existing->tags,
            'artists' => $existing->artists,
            'groups' => $existing->groups,
            'languages' => $existing->languages,
            'categories' => $existing->categories,
            'pages' => $existing->pages,
            'extension' => $existing->extension,
            'extensions' => $existing->extensions,
            'created_at' => $existing->created_at,
            'prefix' => $existing->prefix,
        ]);

        $searchtext = $comic->title_n_before
                     .$comic->title_n_pretty
                     .$comic->title_n_after
                     .$comic->title_o_before
                     .$comic->title_o_pretty
                     .$comic->title_o_after
                     .implode($comic->parodies)
                     .implode($comic->characters)
                     .implode($comic->tags)
                     .implode($comic->artists)
                     .implode($comic->groups)
                     .implode($comic->languages)
                     .implode($comic->categories);
        $searchtext = mb_strtolower($searchtext);
        $searchtext = preg_replace('/\s+/', '', $searchtext);
        $searchtext = preg_split('//u', $searchtext, -1, PREG_SPLIT_NO_EMPTY);
        foreach ($searchtext as &$character) {
            if (strlen($character) != mb_strlen($character, 'utf-8')) {
                $character = bin2hex(iconv('UTF-8', 'UTF-16BE', $character));
            }
        }
        $searchtext = implode($searchtext);
        $comic->searchtext = $searchtext;
        $comic->save();
        $existing->delete();

        return Redirect::route('comic.showCover', ['comic' => $comic->id]);
    }
}
