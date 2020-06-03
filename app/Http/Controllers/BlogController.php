<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function show(Request $request)
    {
        $blog = Blog::find($request->r);
        $content = $blog->caption;

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

    public function loadBloglist(Request $request)
    {
        $blog = Blog::find($request->r);
        $current = $blog;

        $blog->views++;
        $blog->save();

        $videos = null;
        $videosSelect = Blog::where(function($query) use ($blog) {
            foreach ($blog->tags() as $tag) {
                $query->orWhere('tags', 'like', '%'.$tag.'%');
            }
        })->where('id', '!=', $blog->id)->inRandomOrder()->select('id', 'tags')->get()->toArray();

        $rankings = [];
        foreach ($videosSelect as $videoSelect) {
            $score = 0;
            foreach ($blog->tags() as $tag) {
                if (strpos($videoSelect['tags'], $tag) !== false) {
                    $score++;
                }
            }
            array_push($rankings, ['score' => $score, 'id' => $videoSelect['id']]);
        }
        usort($rankings, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        $related = [];
        $max = count($rankings) > 30 ? 30 : count($rankings) - 1;
        for ($i = 0; $i < $max; $i++) {
            array_push($related, Blog::find($rankings[$i]['id']));
        }

        $html = view('blog.blog-playlist-wrapper', compact('current', 'videos', 'related'));
        if ($request->ajax()) {
            return $html;
        }
    }
}
