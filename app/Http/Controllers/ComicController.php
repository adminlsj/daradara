<?php

namespace App\Http\Controllers;

use App\Comic;
use App\Nhentai;
use Illuminate\Http\Request;

class ComicController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->has('query') || $request->page == 1) {
            $trending = Comic::orderBy('day_views', 'desc')->select('id', 'galleries_id', 'title_n_before', 'title_n_pretty', 'title_n_after', 'extension', 'created_at')->limit(6)->get();
        } else {
            $trending = null;
        }
        $newest = Comic::orderBy('created_at', 'desc')->select('id', 'galleries_id', 'title_n_before', 'title_n_pretty', 'title_n_after', 'extension', 'created_at')->paginate(30);

        return view('comic.index', compact('trending', 'newest'));
    }

    public function showCover(Request $request)
    {
        $cid = $request->comic;
        if (is_numeric($cid) && $comic = Comic::find($cid)) {

            $metadata = ['parodies' => $comic->parodies, 'characters' => $comic->characters, 'tags' => $comic->tags, 'artists' => $comic->artists, 'groups' => $comic->groups, 'languages' => $comic->languages, 'categories' => $comic->categories];

            if ($comic->playlist_id) {
                $comics = Comic::where('playlist_id', $comic->playlist_id)->orderBy('created_at', 'desc')->get();
            } else {
                $comics = null;
            }

            $tags = $tags_random = $comic->tags;
            $tags_slice = array_slice($tags_random, 0, 3);
            $related = Comic::where(function($query) use ($tags_slice, $tags) {
                foreach ($tags_slice as $tag) {
                    $query->orWhere('tags', 'like', '%"'.$tag.'"%');
                }
            })->inRandomOrder()->limit(6)->get();

            return view('comic.show-cover', compact('comic', 'comics', 'metadata', 'related'));

        } else {
            abort(404);
        }
    }

    public function showContent(Request $request)
    {
        $cid = $request->comic;
        if (is_numeric($cid) && $comic = Comic::find($cid)) {

            $page = $request->page;

            $extensions = json_encode($comic->extensions);

            $comic->day_views++;
            $comic->week_views++;
            $comic->views++;
            $comic->save();

            return view('comic.show-content', compact('comic', 'page', 'extensions'));

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
                break;
        }

        $comics = $comics->orderBy('created_at', 'desc')->select('id', 'galleries_id', 'title_n_before', 'title_n_pretty', 'title_n_after', 'extension', 'created_at')->paginate(30);

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
                break;
        }

        $comics = $comics->orderBy('created_at', 'desc')->select('id', 'galleries_id', 'title_n_before', 'title_n_pretty', 'title_n_after', 'extension', 'created_at')->paginate(30);

        $count = json_decode(Nhentai::${$column.'_array'}, true)[$value];

        return view('comic.search-tags', compact('comics', 'column', 'value', 'count'));
    }

    public function getRandomComic()
    {
        $random = Comic::inRandomOrder()->select('id')->first();
        return response()->json([
            'id' => $random->id,
        ]);
    }
}
