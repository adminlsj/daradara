<?php

namespace App\Http\Controllers;

use App\Blog;
use App\BlogImg;
use Illuminate\Http\Request;
use Storage;
use File;
use Image;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::all()->sortByDesc('created_at');
        $caro_blogs = Blog::inRandomOrder()->limit(5)->get();

        return view('blog.index', compact('blogs', 'caro_blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $blog = Blog::create([
            'title' => request('title'),
            'content' => request('content'),
            'is_travel' => request('is_travel'),
            'is_japan' => request('is_japan'),
            'is_korea' => request('is_korea'),
            'is_taiwan' => request('is_taiwan'),
            'is_food' => request('is_food'),
            'is_fashion' => request('is_fashion'),
        ]);

        if (request('blogImgs')) {
            foreach (request('blogImgs') as $image) {

                $image_thumb = Image::make($image);
                $image_thumb = $image_thumb->crop(600, 330)->resize(600, 330);
                $image_thumb = $image_thumb->stream();

                Storage::disk('s3')->put('blogImgs/originals/'.$blog->id.'/'.$image->getClientOriginalName(), File::get($image));
                Storage::disk('s3')->put('blogImgs/thumbnails/'.$blog->id.'/'.$image->getClientOriginalName(), $image_thumb->__toString());

                BlogImg::create([
                    'blog_id' => $blog->id,
                    'filename' => $image->getClientOriginalName(),
                    'mime' => $image->getClientMimeType(),
                    'original_filename' => $image->getClientOriginalName(),
                ]);
            }
        }

        return redirect()->action('BlogController@show', ['blog' => $blog]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        $content = $blog->content;

        $content = str_replace('(SUB)', '<h5 style="font-size:20px;font-weight:300">', $content);
        $content = str_replace('(/SUB)', '</h5>', $content);

        $content = str_replace('(CONT)', '<div style="white-space: pre-line;">', $content);
        $content = str_replace('(/CONT)', '</div>', $content);

        $content = str_replace('(IMG)', '<img class="img-responsive border-radius-2" style="padding-top:15px;padding-bottom:15px;width:100%; height:100%" src="https://s3-us-west-2.amazonaws.com/freerider/blogImgs/originals/'.$blog->id.'/', $content);
        $content = str_replace('(/IMG)', '.jpg" alt="First slide">', $content);

        $content = str_replace('(BLANK)', '<p style="margin:35px"></p>', $content);

        $similar_blogs = Blog::inRandomOrder()->limit(10)->get();

        return view('blog.show', compact('blog', 'content', 'similar_blogs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
