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

    public function index(Request $request, String $genre = 'travel', String $category = 'japan'){
        $sideBlogsMobile = Blog::where('category', $category)->orderBy('created_at', 'desc')->paginate(5);
        $html = $this->sidebarHTML($sideBlogsMobile);
        if ($request->ajax()) {
            return $html;
        }

        $caro_blogs = Blog::where('category', $category)->inRandomOrder()->limit(5)->get();
        return view('blog.index', compact('caro_blogs', 'sideBlogsMobile', 'category'));
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
            $image_thumb = $image_thumb->resize(600, 315);
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
        $sideBlogsMobile = Blog::where('category', $category)->orderBy('created_at', 'desc')->paginate(5);
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

        $content = str_replace('(TwitterIMG)',
            '<blockquote class="twitter-tweet"><p lang="ja" dir="ltr">
                <a href="'.$blog->twitterimg.'"></a>
            </blockquote>
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8">
            </script>'
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

        return view('blog.show', compact('blog', 'content', 'fb_title', 'current_blog', 'sideBlogsMobile', 'category'));
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
        return view('blog.show', compact('blog', 'content', 'similar_blogs', 'fb_title', 'current_blog', 'sideBlogsDesktop', 'sideBlogsMobile', 'category'));
    }

    public function sidebarHTML($sideBlogsMobile)
    {
        $html = '';
        foreach ($sideBlogsMobile as $blog) {
            $html .='<div class="col-xs-12 col-sm-6 col-md-6" style="padding: 0px 25px; margin-bottom:15px;">
                        <div class="hover-box-shadow"><a href="'.env("APP_URL", "https://www.freeriderhk.com").'/'.Blog::$pages[$blog->category]['genre'].'/'.$blog->category.'/'.$blog->id.'">
                            <div class="row">
                                <img style="width:100%;" src="https://s3.amazonaws.com/twobayjobs/blogImgs/thumbnails/'.$blog->id.'/'.$blog->blogImgs->sortby("created_at")->first()->filename.'" alt="日本文化">
                            </div>
                            <div class="row" style="background-color: #f3f3f3; padding:10px;">
                                <div class="related-blogs-date" style="font-size: 12.5px; color: #42464A; padding-left: 3px; padding-bottom: 3px">'.Carbon::parse($blog->created_at)->format("Y年m月d日").'</div>
                                <div style="font-weight: 600; font-size: 16px; color: black">'.str_limit($blog->title, 75).'</div>
                            </div>
                        </a></div>
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
