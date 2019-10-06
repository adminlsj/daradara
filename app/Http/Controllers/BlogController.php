<?php

namespace App\Http\Controllers;

use App\Blog;
use App\BlogImg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Storage;
use File;
use Image;
use DB;
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

    public function home(Request $request){
        $sideBlogsMobile = Blog::where('genre', 'blog')->orderBy('created_at', 'desc')->paginate(5);
        $html = $this->sidebarHTML($sideBlogsMobile);
        if ($request->ajax()) {
            return $html;
        }

        $caro_blogs = Blog::where('genre', 'blog')->inRandomOrder()->limit(5)->get();
        $textBlogs = Blog::where('genre', 'blog')->inRandomOrder()->limit(2)->get();

        $sideBlogsDesktop = Blog::where('genre', 'blog')->inRandomOrder()->limit(3)->get();
        return view('blog.genreIndex', compact('caro_blogs', 'textBlogs', 'sideBlogsMobile', 'sideBlogsDesktop'));
    }

    public function watch(Request $request){
        if ($request->has('v') && $request->v != 'null') {
            $video = Blog::find($request->v);
            $videos = Blog::where('category', $video->category)->orderBy('created_at', 'desc')->get();

            $current_blog = $video;
            $fb_title = $video->title;

            $video->views++;
            $video->save();
            $current_id = $video->id;

            return view('video.showWatch', compact('video', 'videos', 'current_blog', 'fb_title', 'current_id'));
        } else {
            $monday = Blog::where('category', 'monday')->orderBy('created_at', 'desc');
            $home = Blog::where('category', 'home')->orderBy('created_at', 'desc');
            $talk = Blog::where('category', 'talk')->orderBy('created_at', 'desc');

            $videos = [$monday->first(), $home->first(), $talk->first()];
            $counts = ['monday' => $monday->count(), 'home' => $home->count(), 'talk' => $talk->count()];
            $titles = ['monday' => '月曜夜未央 2019年完整版', 
                       'home' => '跟你回家可以嗎？2019年完整版',
                       'talk' => '閒聊007 2019年完整版'];
            $updates = ['monday' => '更新至 '.Carbon::parse($monday->first()->created_at)->format('Y.m.d').'】', 
                       'home' => '更新至 '.Carbon::parse($home->first()->created_at)->format('Y.m.d').'】',
                       'talk' => '更新至 '.Carbon::parse($talk->first()->created_at)->format('Y.m.d').'】'];
            $banners = ['monday' => 'https://i.imgur.com/iXyOfUsh.png', 
                       'home' => 'https://i.imgur.com/NF0Gqewh.png',
                       'talk' => 'https://i.imgur.com/BqVcMd9h.png'];

            $sideBlogsDesktop = Blog::where('genre', 'video')->inRandomOrder()->limit(3)->get();
            return view('video.watchIndex', compact('videos', 'counts', 'titles', 'banners', 'sideBlogsDesktop'));
        }
    }

    public function trending(Request $request){
        if ($request->has('v') && $request->v != 'null') {
            if (!($request->ajax())) {
                $request->session()->forget('seed');
            }
            if (!$request->session()->has('seed')) {
                $seed = mt_rand(-1*10000000, 1*10000000) / 10000000;
                $request->session()->put('seed', $seed);
            }
            $seed = $request->session()->pull('seed');
            $request->session()->put('seed', $seed);
            DB::select('SELECT setseed('.$seed.')');

            $video = Blog::find($request->v);

            $videosSelect = Blog::where('genre', '!=', 'blog')->where('id', '!=', $video->id)->inRandomOrder()->select('id', 'tags')->get()->toArray();
            $rankings = [];
            foreach ($videosSelect as $videoSelect) {
                $score = 0;
                foreach ($video->tags() as $tag) {
                    if (strpos($videoSelect['tags'], $tag) !== false) {
                        $score++;
                    }
                }
                array_push($rankings, ['score' => $score, 'id' => $videoSelect['id']]);
            }
            usort($rankings, function ($a, $b) {
                return $b['score'] <=> $a['score'];
            });

            $videosArray = [];
            foreach ($rankings as $rank) {
                array_push($videosArray, Blog::find($rank['id']));
            }

            $page = Input::get('page', 1); // Get the ?page=1 from the url
            $perPage = 10; // Number of items per page
            $offset = ($page * $perPage) - $perPage;

            $videos = new LengthAwarePaginator(
                array_slice($videosArray, $offset, $perPage, true), // Only grab the items we need
                count($videosArray), // Total items
                $perPage, // Items per page
                $page, // Current page
                ['path' => $request->url(), 'query' => $request->query()] // We need this so we can keep all old query parameters from the url
            );

            $html = $this->relatedLoadHTML($videos);
            if ($request->ajax()) {
                return $html;
            }

            $sideBlogsDesktop = Blog::where('category', 'video')->inRandomOrder()->limit(3)->get();
            $current_blog = $video;
            $fb_title = $video->title;

            $video->views++;
            $video->save();

            return view('video.show', compact('video', 'videos', 'sideBlogsDesktop', 'current_blog', 'fb_title'));
        } else {
            $videos = Blog::orderBy('views', 'desc')->paginate(5);
            $html = $this->videoLoadHTML($videos);
            if ($request->ajax()) {
                return $html;
            }

            $sideBlogsDesktop = Blog::where('category', 'video')->inRandomOrder()->limit(3)->get();
            return view('video.trendingIndex', compact('videos', 'sideBlogsDesktop'));
        }
    }

    public function genreIndex(Request $request, String $genre = 'laughseejapan'){
        if ($genre == 'laughseejapan') {
            $videos = Blog::where('genre', $genre)->orWhere('genre', 'watch')->orderBy('created_at', 'desc')->paginate(5);
            $html = $this->videoLoadHTML($videos);
            if ($request->ajax()) {
                return $html;
            }

            $sideBlogsDesktop = Blog::where('genre', $genre)->inRandomOrder()->limit(3)->get();

            return view('video.genreIndex', compact('videos', 'sideBlogsDesktop', 'genre'));

        } elseif ($genre == 'watch') {
            $monday = Blog::where('category', 'monday')->orderBy('created_at', 'desc');
            $home = Blog::where('category', 'home')->orderBy('created_at', 'desc');
            $talk = Blog::where('category', 'talk')->orderBy('created_at', 'desc');

            $videos = [$monday->first(), $home->first(), $talk->first()];
            $counts = ['monday' => $monday->count(), 'home' => $home->count(), 'talk' => $talk->count()];
            $titles = ['monday' => '月曜夜未央 2019年完整版', 'home' => '跟你回家可以嗎？2019年完整版', 'talk' => '閒聊007 2019年完整版'];

            $sideBlogsDesktop = Blog::where('genre', $genre)->inRandomOrder()->limit(3)->get();
            return view('video.watchIndex', compact('videos', 'counts', 'titles', 'sideBlogsDesktop', 'genre'));

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

    public function categoryIndex(Request $request, String $genre = 'laughseejapan', String $category = 'video'){
        if ($genre == 'laughseejapan') {

            if ($category == 'trending') {
                $videos = Blog::where('genre', $genre)->orderBy('views', 'desc')->paginate(5);
                $html = $this->videoLoadHTML($videos);
                if ($request->ajax()) {
                    return $html;
                }

                $sideBlogsDesktop = Blog::where('genre', $genre)->inRandomOrder()->limit(3)->get();
                return view('video.trendingIndex', compact('videos', 'sideBlogsDesktop', 'category', 'genre'));
            } else {

                $videos = Blog::where('genre', 'laughseejapan')->where('title', 'ILIKE', '%'.$category.'%')
                      ->orWhere('genre', 'laughseejapan')->where('tags', 'ILIKE', '%'.$category.'%')
                      ->orWhere('genre', 'watch')->where('title', 'ILIKE', '%'.$category.'%')
                      ->orWhere('genre', 'watch')->where('tags', 'ILIKE', '%'.$category.'%')
                      ->distinct()->orderBy('created_at', 'desc')->paginate(5);
                $html = $this->videoLoadHTML($videos);
                if ($request->ajax()) {
                    return $html;
                }

                $sideBlogsDesktop = Blog::where('genre', $genre)->inRandomOrder()->limit(3)->get();
                return view('video.categoryIndex', compact('videos', 'sideBlogsDesktop', 'category', 'genre'));
            }

        } else {
            $sideBlogsMobile = Blog::where('genre', $genre)->where('category', $category)->orderBy('created_at', 'desc')->paginate(5);
            $html = $this->sidebarHTML($sideBlogsMobile);
            if ($request->ajax()) {
                return $html;
            }

            $sideBlogsDesktop = Blog::where('genre', $genre)->inRandomOrder()->limit(3)->get();
            return view('blog.categoryIndex', compact('sideBlogsMobile', 'sideBlogsDesktop', 'category', 'genre'));
        }
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
    public function show(Request $request, String $genre = 'laughseejapan', String $category = 'video', Blog $blog)
    {
        if ($genre == 'laughseejapan') {

            if (!($request->ajax())) {
                $request->session()->forget('seed');
            }

            $video = $blog;

            $loop = 0;
            $videos = [];
            foreach ($video->tags() as $tag) {
                if ($loop == 0) {
                    $videos = Blog::where('tags', 'like', '%'.$tag.'%')->where('id', '!=', $video->id);
                } else {
                    $videos = $videos->orWhere('tags', 'like', '%'.$tag.'%')->where('id', '!=', $video->id);
                }
                $loop++;
            }

            if (!$request->session()->has('seed')) {
                $seed = mt_rand(-1*10000000, 1*10000000) / 10000000;
                $request->session()->put('seed', $seed);
            }

            $seed = $request->session()->pull('seed');
            $request->session()->put('seed', $seed);
            DB::select('SELECT setseed('.$seed.')');
            $videos = $videos->inRandomOrder()->paginate(5);
            $html = $this->videoLoadHTML($videos);
            if ($request->ajax()) {
                return $html;
            }

            $sideBlogsDesktop = Blog::where('genre', $genre)->inRandomOrder()->limit(3)->get();
            $current_blog = $video;
            $fb_title = $video->title;

            $video->views++;
            $video->save();

            return view('video.show', compact('video', 'videos', 'sideBlogsDesktop', 'current_blog', 'fb_title', 'category', 'genre'));

        } elseif ($genre == 'watch') {
            $video = $blog;
            $videos = Blog::where('genre', $genre)->where('category', $category)->where('id', '!=', $video->id)->orderBy('created_at', 'desc')->paginate(10);
            $html = $this->relatedLoadHTML($videos);
            if ($request->ajax()) {
                return $html;
            }

            $sideBlogsDesktop = Blog::where('genre', $genre)->inRandomOrder()->limit(3)->get();
            $current_blog = $video;
            $fb_title = $video->title;

            $video->views++;
            $video->save();

            return view('video.show', compact('video', 'videos', 'sideBlogsDesktop', 'current_blog', 'fb_title', 'category', 'genre'));

        } else {
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

    public function videoLoadHTML($videos)
    {
        $html = '';
        foreach ($videos as $video) {
            $html .= view('video.singleVideoPost', compact('video'));
        }
        return $html;
    }

    public function relatedLoadHTML($videos)
    {
        $html = '';
        foreach ($videos as $video) {
            $html .= view('video.singleRelatedPost', compact('video'));
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

    public function search(Request $request)
    {
        $query = request('query');
        $queryArray = [];
        preg_match_all('/./u', $query, $queryArray);
        $queryArray = $queryArray[0];
        if (($key = array_search(' ', $queryArray)) !== false) {
            unset($queryArray[$key]);
        }

        $videosSelect = Blog::where('genre', '!=', 'blog')->orderBy('created_at', 'desc')->select('id', 'title', 'tags')->get()->toArray();
        $rankings = [];
        foreach ($videosSelect as $videoSelect) {
            $score = 0;
            foreach ($queryArray as $q) {
                if (is_numeric($q)) {
                    if (strpos($videoSelect['title'], $q) !== false) {
                        $score++;
                    }
                } else {
                    if (strpos($videoSelect['title'], $q) !== false) {
                        $score++;
                    }
                    if (strpos($videoSelect['tags'], $q) !== false) {
                        $score++;
                    }
                }
            }
            if ($score > 0) {
                array_push($rankings, ['score' => $score, 'id' => $videoSelect['id']]);
            }
        }
        usort($rankings, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        $videosArray = [];
        foreach ($rankings as $rank) {
            array_push($videosArray, Blog::find($rank['id']));
        }

        $page = Input::get('page', 1); // Get the ?page=1 from the url
        $perPage = 10; // Number of items per page
        $offset = ($page * $perPage) - $perPage;

        $videos = new LengthAwarePaginator(
            array_slice($videosArray, $offset, $perPage, true), // Only grab the items we need
            count($videosArray), // Total items
            $perPage, // Items per page
            $page, // Current page
            ['path' => $request->url(), 'query' => $request->query()] // We need this so we can keep all old query parameters from the url
        );

        $html = $this->relatedLoadHTML($videos);
        if ($request->ajax()) {
            return $html;
        }


        /* $query = request('query');          
        $videos = Blog::where('title', 'ILIKE', '%'.$query.'%')->orWhere('tags', 'ILIKE', '%'.$query.'%')
                        ->distinct()->orderBy('created_at', 'desc')->paginate(5);
        $html = $this->videoLoadHTML($videos);
        if ($request->ajax()) {
            return $html;
        } */

        $sideBlogsDesktop = Blog::where('genre', 'laughseejapan')->inRandomOrder()->limit(3)->get();
        return view('video.search', compact('videos', 'sideBlogsDesktop', 'query'));
    }

    public function contact()
    {
        $genre = 'laughseejapan';
        $category = 'video';
        return view('layouts.contact', compact('genre', 'category'));
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
