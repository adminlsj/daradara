<?php

namespace App\Http\Controllers;

use App\Blog;
use App\BlogImg;
use App\Watch;
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
use Response;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('edit', 'update', 'destroy');
    }

    public function home(Request $request){
        $videos = Blog::whereDate('created_at', '>=', Carbon::now()->subMonths(6))
                      ->where('views', '>=', '500000')->inRandomOrder()->limit(8)->get();
        $variety = Blog::where('genre', 'variety')
                       ->whereDate('created_at', '>=', Carbon::now()->subMonths(6))
                       ->where('views', '>=', '500000')->inRandomOrder()->limit(8)->get();
        $drama = Blog::where('genre', 'drama')
                     ->whereDate('created_at', '>=', Carbon::now()->subMonths(12))
                     ->where('views', '>=', '200000')->inRandomOrder()->limit(8)->get();
        $anime = Blog::where('genre', 'anime')
                     ->whereDate('created_at', '>=', Carbon::now()->subMonths(12))
                     ->where('views', '>=', '200000')->inRandomOrder()->limit(8)->get();

        return view('video.home', compact('videos', 'variety', 'drama', 'anime'));
    }

    public function genre(Request $request){
        $genre = $request->path();
        if ($genre == 'variety') {
            $watches = Watch::where('genre', $genre)->get();
        } else {
            $year = $request->has('y') && $request->y != null ? $request->y : '2019';
            if ($request->has('m') && $request->m != null) {
                $watches = Watch::where('genre', $genre)->whereYear('created_at', $year)->whereMonth('created_at', $request->m)->get();
            } else {
                $watches = Watch::where('genre', $genre)->whereYear('created_at', $year)->get();
            }
        }

        $is_program = true;

        return view('video.watchIndex', compact('genre', 'watches', 'is_program'));
    }

    public function intro(String $genre, String $title, Request $request){
        $title = str_replace("_", " / ", $title);
        $title = str_replace("-", " ", $title);
        $watch = Watch::where('genre', $genre)->where('title', $title)->first();
        $videos = Blog::where('category', $watch->category)->orderBy('created_at', 'asc')->get();

        $is_program = true;
        return view('video.intro', compact('watch', 'videos', 'is_program'));
    }

    public function watch(Request $request){
        /*$id = 1360;
        $genre = 'variety';
        $category = 'lddtz';
        $created_at = new Carbon('2019-01-12 14:47:15');
        for ($i = 1; $i <= 50; $i++) { 
            $video = Blog::create([
                'id' => $id,
                'title' =>  $created_at->format('Y.m.d').' 嵐的大挑戰 / 交給嵐吧',
                'caption' => $created_at->format('Y.m.d').' 嵐的大挑戰 / 交給嵐吧',
                'genre' => $genre,
                'category' => $category,
                'tags' => '嵐的大挑戰 交給嵐吧',
                'hd' => 'https://archive.org/download/sqzw_11/SQZW0'.$i.'.mp4',
                'sd' => 'https://archive.org/download/sqzw_11/SQZW0'.$i.'.mp4',
                'imgur' => 'pending',
                'views' => 100000,
                'duration' => 0,
                'outsource' => false,
                'created_at' => $created_at,
            ]);
            $created_at = $created_at->addDays(7);
            $id++;
        }*/

        /*$id = 1682;
        $genre = 'anime';
        $category = 'gfsn';
        $title = '高分少女 第二季';
        $created_at = new Carbon('2019-10-05 17:21:35');
        for ($i = 1; $i <= 8; $i++) { 
            $video = Blog::create([
                'id' => $id,
                'title' =>  $title.'【第'.$i.'話】',
                'caption' => $title.'【第'.$i.'話】',
                'genre' => $genre,
                'category' => $category,
                'tags' => '高分少女',
                'hd' => 'https://archive.org/download/sqzw_11/SQZW0'.$i.'.mp4',
                'sd' => 'https://archive.org/download/sqzw_11/SQZW0'.$i.'.mp4',
                'imgur' => 'pending',
                'views' => 100000,
                'duration' => 0,
                'outsource' => true,
                'created_at' => $created_at,
            ]);
            $created_at = $created_at->addDays(7);
            $id++;
        }
        $watch = Watch::create([
            'id' => 97,
            'genre' => $genre,
            'category' => $category,
            'title' => $title,
            'description' => '',
            'imgur' => '',
        ]);*/

        if ($request->has('v') && $request->v != 'null') {
            $video = Blog::find($request->v);

            if ($video->category == 'video') {
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

                $videos = [];
                for ($i = 0; $i < 30; $i++) { 
                    array_push($videos, Blog::find($rankings[$i]['id']));
                }

                $video->views++;
                $video->save();

                $current = $video;
                $is_program = false;

                return view('video.show', compact('video', 'videos', 'current', 'is_program'));

            } else {
                if ($video->genre == 'drama' || $video->genre == 'anime') {
                    $videos = Blog::where('category', $video->category)->orderBy('created_at', 'asc')->get();
                } else {
                    $videos = Blog::where('category', $video->category)->orderBy('created_at', 'desc')->get();
                }

                $query = Blog::where('category', $video->category)->orderBy('created_at', 'asc')->pluck('id')->toArray();
                $current = array_search($video->id, $query);
                while(key($query) !== null && key($query) !== $current) next($query);

                $prev = 0; $next = 0;
                if ($this->has_prev($query)) {
                    $prev = prev($query);
                    next($query);
                } else {
                    $prev = false;
                }
                if ($this->has_next($query)) {
                    $next = next($query);
                } else {
                    $next = false;
                }

                $video->views++;
                $video->save();

                $genre = $video->genre;

                $watch = Watch::where('category', $video->category)->first();

                $current = $video;
                $is_program = true;

                return view('video.showWatch', compact('genre', 'video', 'videos', 'prev', 'next', 'watch', 'current', 'is_program'));
            }
        }
    }

    public function rank(Request $request){
        if ($request->has('g') && $request->g != 'null') {
            $genre = $request->g;
            $months = 3;
            switch ($genre) {
                case 'variety':
                    $months = 3;
                    break;
                case 'drama':
                    $months = 12;
                    break;
                case 'anime':
                    $months = 12;
                    break;
                default:
                    $months = 3;
                    break;
            }
            $videos = Blog::where('genre', $genre)->whereDate('created_at', '>=', Carbon::now()->subMonths($months))->orderBy('views', 'desc')->paginate(10);
            $html = $this->rankLoadHTML($videos);
            if ($request->ajax()) {
                return $html;
            }

            return view('video.rankIndex', compact('videos'));
        } else {
            $videos = Blog::whereDate('created_at', '>=', Carbon::now()->subMonths(3))->orderBy('views', 'desc')->paginate(10);
            $html = $this->rankLoadHTML($videos);
            if ($request->ajax()) {
                return $html;
            }

            return view('video.rankIndex', compact('videos'));
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
        if ($genre == 'blog') {
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

    public function searchLoadHTML($videos)
    {
        $html = '';
        $is_program = false;
        foreach ($videos as $video) {
            $html .= view('video.singleRelatedPost', compact('video', 'is_program'));
        }
        return $html;
    }

    public function rankLoadHTML($videos)
    {
        $html = '';
        foreach ($videos as $video) {
            $html .= view('video.rankVideoPost', compact('video'));
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

        $html = $this->searchLoadHTML($videos);
        if ($request->ajax()) {
            return $html;
        }

        return view('video.search', compact('videos', 'query'));
    }

    public function contact()
    {
        $genre = 'laughseejapan';
        $category = 'video';
        $is_program = false;
        return view('layouts.contact', compact('genre', 'category', 'is_program'));
    }

    public function policy()
    {
        $is_program = false;
        return view('layouts.policy', compact('is_program'));
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

    public function has_prev(array $_array)
    {
      return prev($_array) !== false ?: key($_array) !== null;
    }

    public function has_next(array $_array)
    {
      return next($_array) !== false ?: key($_array) !== null;
    }

    public function sitemap()
    {
        $videos = Blog::orderBy('created_at', 'desc')->get();
        $watches = Watch::orderBy('created_at', 'desc')->get();
        $time = Carbon::now()->format('Y-m-d\Th:i:s').'+00:00';
        return Response::view('layouts.sitemap', compact('videos', 'watches', 'time'))->header('Content-Type', 'application/xml');
    }
}
