<?php

namespace App\Http\Controllers;

use App\Blog;
use App\BlogImg;
use Illuminate\Http\Request;
use Storage;
use File;
use Image;
use App\Mail\Contact;
use App\Mail\ContactUser;
use Carbon\Carbon;


class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('edit', 'update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function genreIndex(Request $request, String $genre = 'laughseejapan'){
        if ($genre == 'laughseejapan') {
            $videos = Blog::where('genre', $genre)->orderBy('created_at', 'desc')->paginate(3);
            $html = $this->videoLoadHTML($videos);
            if ($request->ajax()) {
                return $html;
            }

            $textBlogs = Blog::where('genre', $genre)->inRandomOrder()->limit(3)->get();

            $sideBlogsDesktop = Blog::where('genre', $genre)->inRandomOrder()->limit(3)->get();

            return view('video.genreIndex', compact('videos', 'textBlogs', 'sideBlogsDesktop', 'genre'));
        } else {
            $sideBlogsMobile = Blog::where('genre', $genre)->orderBy('created_at', 'desc')->paginate(5);
            $html = $this->sidebarHTML($sideBlogsMobile);
            if ($request->ajax()) {
                return $html;
            }

            $caro_blogs = Blog::where('genre', $genre)->inRandomOrder()->limit(5)->get();
            $textBlogs = Blog::where('genre', $genre)->inRandomOrder()->limit(2)->get();

            $sideBlogsDesktop = Blog::where('genre', $genre)->inRandomOrder()->limit(3)->get();
            return view('blog.genreIndex', compact('caro_blogs', 'textBlogs', 'sideBlogsMobile', 'sideBlogsDesktop', 'genre'));
        }
    }

    public function categoryIndex(Request $request, String $genre = 'travel', String $category = 'japan'){
        $sideBlogsMobile = Blog::where('genre', $genre)->where('category', $category)->orderBy('created_at', 'desc')->paginate(5);
        $html = $this->sidebarHTML($sideBlogsMobile);
        if ($request->ajax()) {
            return $html;
        }

        $sideBlogsDesktop = Blog::where('genre', $genre)->inRandomOrder()->limit(3)->get();
        return view('blog.categoryIndex', compact('sideBlogsMobile', 'sideBlogsDesktop', 'category', 'genre'));
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
            'category' => request('category'),
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
            $image_thumb = $image_thumb->crop(350, 350);
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
    public function show(Request $request, String $genre = 'travel', String $category = 'japan', Blog $blog)
    {
        $sideBlogsMobile = Blog::where('genre', $genre)->where('category', $category)->orderBy('created_at', 'desc')->paginate(5);
        $html = $this->sidebarHTML($sideBlogsMobile);
        if ($request->ajax()) {
            return $html;
        }
        $sideBlogsDesktop = Blog::where('genre', $genre)->inRandomOrder()->limit(3)->get();

        $content = $blog->content;

        $content = str_replace('(SUB)', '<h5 style="font-size:2.1rem;font-weight:bold; line-height:30px;">', $content);
        $content = str_replace('(/SUB)', '</h5>', $content);

        $content = str_replace('(CONT)', '<div style="font-size:1.6rem;white-space: pre-line;">', $content);
        $content = str_replace('(/CONT)', '</div>', $content);

        $content = str_replace('(LINK)', '<a target="_blank" href=', $content);
        $content = str_replace('(/LINK)', '</a>', $content);

        $content = str_replace('(IMG)', '<img class="img-responsive border-radius-2" style="padding-top:15px;padding-bottom:15px;width:100%; height:100%" src="https://s3.amazonaws.com/twobayjobs/blogImgs/originals/'.$blog->id.'/', $content);
        $content = str_replace('(/IMG)', '.jpg" alt="日本旅行推薦">', $content);

        $content = str_replace('(TwitterIMG)', '<blockquote class="twitter-tweet"><p lang="ja" dir="ltr">
                <a href="', $content);
        $content = str_replace('(/TwitterIMG)', '"></a></blockquote>
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8">
            </script>', $content);

        $content = str_replace('(BLANK)', '<p style="margin:15px"></p>', $content);

        $contentTopData = "";
        $contentData = "";
        switch ($genre) {
            case 'travel':
                if ($category == 'japan' || $category == 'korea') {
                    $contentTopData = '4060710969';
                    $contentData = '9914751067';
                    break;
                } elseif ($category == 'japanews') {
                    $contentTopData = '8818645799';
                    $contentData = '1365206344';
                    break;
                }
            case 'tech':
                $contentTopData = '2660986465';
                $contentData = '7254837598';
                break;
            default:
                $contentTopData = '4060710969';
                $contentData = '9914751067';
                break;
        }
        $content = str_replace('(AdsenseTop)',
            '<div style="margin:25px 0px;">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- Content-Top -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-4485968980278243"
                     data-ad-slot="'.$contentTopData.'"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>'
        , $content);
        
        $content = str_replace('(Adsense)',
            '<div style="margin:25px 0px;">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- Content -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-4485968980278243"
                     data-ad-slot="'.$contentData.'"
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

        $current_blog = $blog;

        return view('blog.show', compact('blog', 'content', 'fb_title', 'current_blog', 'sideBlogsMobile', 'sideBlogsDesktop', 'category', 'genre'));
    }

    public function showOnly(Request $request, Blog $blog)
    {
        $sideBlogsDesktop = Blog::inRandomOrder()->get();
        $sideBlogsMobile = Blog::orderBy('created_at', 'desc')->paginate(5);
        $html = $this->sidebarHTML($sideBlogsMobile);
        if ($request->ajax()) {
            return $html;
        }

        $content = $blog->content;

        $content = str_replace('(SUB)', '<h5 style="font-size:2.1rem;font-weight:bold; line-height:30px;">', $content);
        $content = str_replace('(/SUB)', '</h5>', $content);

        $content = str_replace('(CONT)', '<div style="font-size:1.6rem;white-space: pre-line;">', $content);
        $content = str_replace('(/CONT)', '</div>', $content);

        $content = str_replace('(LINK)', '<a target="_blank" href=', $content);
        $content = str_replace('(/LINK)', '</a>', $content);

        $content = str_replace('(IMG)', '<img class="img-responsive border-radius-2" style="padding-top:15px;padding-bottom:15px;width:100%; height:100%" src="https://s3.amazonaws.com/twobayjobs/blogImgs/originals/'.$blog->id.'/', $content);
        $content = str_replace('(/IMG)', '.jpg" alt="日本旅行推薦">', $content);

        $content = str_replace('(BLANK)', '<p style="margin:15px"></p>', $content);

        $content = str_replace('(AdsenseTop)',
            '<div style="margin:25px 0px;">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- Content-Top -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-4485968980278243"
                     data-ad-slot="4060710969"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>'
        , $content);
        
        $content = str_replace('(Adsense)',
            '<div style="margin:25px 0px;">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- Content -->
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-4485968980278243"
                     data-ad-slot="9914751067"
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

        $current_blog = $blog;
        $similar_blogs = Blog::inRandomOrder()->get();

        $category = 'japan';
        return view('blog.show', compact('blog', 'content', 'similar_blogs', 'fb_title', 'current_blog', 'sideBlogsDesktop', 'sideBlogsMobile', 'category', 'genre'));
    }

    public function sidebarHTML($sideBlogsMobile)
    {
        $html = '';
        foreach ($sideBlogsMobile as $blog) {
            $html .='<div class="row hover-box-shadow" style="margin:0px -5px; padding: 15px 15px;">
                        <a href="'.env("APP_URL", "https://www.freeriderhk.com").'/'.$blog->genre.'/'.$blog->category.'/'.$blog->id.'">
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

    public function videoLoadHTML($videos)
    {
        $html = '';
        foreach ($videos as $video) {
            $html .='<div style="overflow:hidden" class="fb-video"
                      data-href="'.$video->content.'"
                      data-width="auto"
                      data-allowfullscreen="true"
                      data-autoplay="false"
                      data-show-captions="false"></div>

                    <div class="video-title-container">
                        <div>
                            <a href="https://www.facebook.com/laughseejapan/" target="_blank">
                                <img src="https://twobayjobs.s3.amazonaws.com/avatars/originals/default_laughseejapan_profile_pic.jpg" class="video-profile-pic" width="40px" height="40px">
                            </a>
                        </div>
                        <div>
                            <a href="'.env("APP_URL", "https://www.freeriderhk.com").'/'.$video->genre.'/'.$video->category.'/'.$video->id.'" target="_blank">
                                <h4 class="video-title">'.$video->title.'</h4>
                            </a>
                            <p class="video-caption">'.$video->caption.'</p>
                            <p class="video-tags">娛見日本@laughseejapan | <a href="'.env("APP_URL", "https://www.freeriderhk.com").'/laughseejapan/'.$video->category.'">'.array_search($video->category, Blog::$genres[$video->genre]['categories']).'</a> | '.Carbon::parse($video->created_at)->format('Y-m-d').'</span></p>
                        </div>
                    </div>​<br>';
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

    public function contact()
    {
        $category = 'japan';
        return view('layouts.contact', compact('category'));
    }

    public function policy()
    {
        $category = 'japan';
        return view('layouts.policy', compact('category'));
    }

    public function sendMail(String $status)
    {
        $category = 'japan';
        switch ($status) {
            case 'contact':
                $user_email = request('email');
                $title = request('title');
                $text = request('text');
                \Mail::to('u3514481@connect.hku.hk')->send(new Contact($user_email, $title, $text));
                \Mail::to(request('email'))->send(new ContactUser($user_email, $title, $text));
                break;
            
            default:
                break;
        }
        return redirect('/');
    }
}
