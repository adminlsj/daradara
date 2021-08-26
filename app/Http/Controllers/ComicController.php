<?php

namespace App\Http\Controllers;

use App\Comic;
use App\Nhentai;
use Illuminate\Http\Request;

class ComicController extends Controller
{
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
            $tags_slice = array_slice($tags_random, 0, 5);
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

    public function searchTags(String $column, String $value, String $time = null)
    {
        if (!in_array($column, array_keys(Nhentai::$columns))) {
            abort(403);
        }

        $comics = Comic::where($column, 'ilike', '%"'.$value.'"%');

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

        return view('comic.search-tags', compact('comics', 'column', 'value'));
    }
}
