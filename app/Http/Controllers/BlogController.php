<?php

namespace App\Http\Controllers;

use App\Blog;
use App\BlogImg;
use App\Job;
use Illuminate\Http\Request;
use Storage;
use File;
use Image;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store', 'edit', 'update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::all()->sortByDesc('created_at');
        $caro_blogs = Blog::inRandomOrder()->limit(5)->get();

        $relatedJobs = Job::inRandomOrder()->limit(20)->get();
        $relatedBlogs = Blog::inRandomOrder()->limit(20)->get();

        return view('blog.index', compact('blogs', 'caro_blogs', 'relatedJobs', 'relatedBlogs'));
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
                Storage::disk('s3')->put('blogImgs/originals/'.$blog->id.'/'.$image->getClientOriginalName(), File::get($image));
                BlogImg::create([
                    'blog_id' => $blog->id,
                    'filename' => $image->getClientOriginalName(),
                    'mime' => $image->getClientMimeType(),
                    'original_filename' => $image->getClientOriginalName(),
                ]);
            }

            $image_thumb = Image::make(request('blogImgs')[0]);
            $image_thumb = $image_thumb->resize(480, 360);
            $image_thumb = $image_thumb->stream();
            Storage::disk('s3')->put('blogImgs/thumbnails/'.$blog->id.'/'.request('blogImgs')[0]->getClientOriginalName(), $image_thumb->__toString());
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

        $content = str_replace('(LINK)', '<a target="_blank" href=', $content);
        $content = str_replace('(/LINK)', '</a>', $content);

        $content = str_replace('(IMG)', '<img class="img-responsive border-radius-2" style="padding-top:15px;padding-bottom:15px;width:100%; height:100%" src="https://s3.amazonaws.com/twobayjobs/blogImgs/originals/'.$blog->id.'/', $content);
        $content = str_replace('(/IMG)', '.jpg" alt="First slide">', $content);

        $content = str_replace('(BLANK)', '<p style="margin:35px"></p>', $content);

        $content = str_replace('(Adsense)',
            '<div class="col-sm-12 col-md-12 col-md-12" style="margin-top:25px;">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- Home Page Ads -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-4485968980278243"
                     data-ad-slot="9914751067"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                <br>
            </div>'
        , $content);

        $content = explode('(LOGO)', $content);

        $similar_blogs = Blog::inRandomOrder()->limit(20)->get();

        $relatedJobs = Job::inRandomOrder()->limit(20)->get();
        $relatedBlogs = Blog::inRandomOrder()->limit(20)->get();

        $fb_title = $blog->content;
        $fb_title = str_replace('(SUB)', '', $fb_title);
        $fb_title = str_replace('(/SUB)', '', $fb_title);
        $fb_title = str_replace('(CONT)', '', $fb_title);
        $fb_title = str_replace('(/CONT)', '', $fb_title);
        $fb_title = str_replace('(IMG)', '', $fb_title);
        $fb_title = str_replace('(/IMG)', '', $fb_title);
        $fb_title = str_replace('(BLANK)', '', $fb_title);
        $fb_title = str_replace('(Adsense)', '', $fb_title);

        return view('blog.show', compact('blog', 'content', 'similar_blogs', 'relatedJobs', 'relatedBlogs', 'fb_title', 'displayJobs'));
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
