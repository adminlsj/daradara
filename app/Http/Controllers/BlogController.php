<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->get();
        $is_program = false;
        return view('blog.index', compact('blogs', 'is_program'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Video  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Blog $blog)
    {
        $content = $blog->content;

        $content = str_replace('(SUB)', '<h5 style="font-size:2.1rem;font-weight:bold; line-height:30px;">', $content);
        $content = str_replace('(/SUB)', '</h5>', $content);

        $content = str_replace('(CONT)', '<div style="font-size:1.6rem;white-space: pre-line;">', $content);
        $content = str_replace('(/CONT)', '</div>', $content);

        $content = str_replace('(LINK)', '<a target="_blank" href=', $content);
        $content = str_replace('(/LINK)', '</a>', $content);

        $content = str_replace('(IMG)', '<img class="img-responsive border-radius-2" style="padding-top:15px;padding-bottom:15px;width:100%; height:100%" src="https://i.imgur.com/', $content);
        $content = str_replace('(/IMG)', 'h.jpg" alt="'.$blog->title.'">', $content);

        $content = str_replace('(TwitterIMG)', '<blockquote class="twitter-tweet"><p lang="ja" dir="ltr">
                <a href="', $content);
        $content = str_replace('(/TwitterIMG)', '"></a></blockquote>
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8">
            </script>', $content);

        $content = str_replace('(BLANK)', '<p style="margin:15px"></p>', $content);

        $content = str_replace('(Adsense)',
            '<div style="margin-top:15px;margin-bottom:15px;">
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- Blog Show Ads -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-4485968980278243"
                     data-ad-slot="6532428575"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>'
        , $content);

        $content = explode('(LOGO)', $content);

        $fb_title = $blog->content;
        $fb_title = str_replace('(SUB)', '', $fb_title);
        $fb_title = str_replace('(/SUB)', '', $fb_title);
        $fb_title = str_replace('(CONT)', '', $fb_title);
        $fb_title = str_replace('(/CONT)', '', $fb_title);
        $fb_title = str_replace('(IMG)', '', $fb_title);
        $fb_title = str_replace('(/IMG)', '', $fb_title);
        $fb_title = str_replace('(BLANK)', '', $fb_title);
        $fb_title = str_replace('(Adsense)', '', $fb_title);

        $current = $blog;
        $sideBlogsDesktop = Blog::all();
        $is_program = false;

        $sideBlogsMobile = Blog::all();
        $sideBlogsDesktop = Blog::all();

        return view('blog.show', compact('blog', 'content', 'fb_title', 'current', 'sideBlogsMobile', 'sideBlogsDesktop', 'is_program'));
    }

    public function sidebarHTML($sideVideosMobile)
    {
        $html = '';
        foreach ($sideVideosMobile as $blog) {
            $html .='<div class="row hover-box-shadow" style="margin:0px -5px; padding: 15px 15px;">
                        <a href="https://www.laughseejapan.com'.'/'.$blog->genre.'/'.$blog->category.'/'.$blog->id.'">
                            <div class="col-xs-3" style="position:relative; padding-right:5px">
                                <div class="row">
                                    <img style="width:100%; border-radius:2px" src="https://s3.amazonaws.com/twobayjobs/blogImgs/thumbnails/'.$blog->id.'/'.$blog->blogImgs->sortby("created_at")->first()->filename.'" alt="日本文化">
                                    <div class="related-blogs-date" style="font-size: 12.5px; color: gray; position:absolute; bottom:1px; right:-93px; font-weight:400;">'.Carbon::parse($blog->created_at)->format("Y-m-d").'</div>
                                </div>
                            </div>

                            <div style="padding: 0px 30px 0px 40px" class="col-xs-9">
                                <div class="row">
                                    <div class="blog-title">'.str_limit($blog->title, 95).'</div>
                                    <div class="hidden-xs" style="font-weight: 400; font-size: 13.5px; color: #696969; margin-top:10px">'.str_limit($blog->caption, 300).'</div>
                                </div>
                            </div>
                        </a>
                    </div>';
        }
        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
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
