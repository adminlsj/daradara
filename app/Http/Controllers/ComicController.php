<?php

namespace App\Http\Controllers;

use App\Comic;

class ComicController extends Controller
{
    public function showCover(Comic $comic)
    {
        $metadata = ['同人' => $comic->parodies, '角色' => $comic->characters, '標籤' => $comic->tags, '作者' => $comic->artists, '社團' => $comic->groups, '語言' => $comic->languages, '分類' => $comic->categories];

        $tags = $tags_random = $comic->tags;
        $tags_slice = array_slice($tags_random, 0, 5);
        $related = Comic::where(function($query) use ($tags_slice, $tags) {
            foreach ($tags_slice as $tag) {
                $query->orWhere('tags', 'like', '%"'.$tag.'"%');
            }
        })->inRandomOrder()->limit(6)->get();

        return view('comic.show-cover', compact('comic', 'metadata', 'related'));
    }

    public function showContent(Comic $comic, int $page)
    {
        return view('comic.show-content', compact('comic', 'page'));
    }
}
