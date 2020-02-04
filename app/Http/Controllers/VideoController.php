<?php

namespace App\Http\Controllers;

use App\Video;
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

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('edit', 'update', 'destroy');
    }

    public function home(Request $request){
        $videos = Video::whereDate('created_at', '>=', Carbon::now()->subMonths(6))
                      ->where('views', '>=', '500000')->inRandomOrder()->limit(12)->get();
        $variety = Video::where('genre', 'variety')
                       ->whereDate('created_at', '>=', Carbon::now()->subMonths(6))
                       ->where('views', '>=', '500000')->inRandomOrder()->limit(12)->get();
        $drama = Video::where('genre', 'drama')
                     ->whereDate('created_at', '>=', Carbon::now()->subMonths(12))
                     ->where('views', '>=', '200000')->inRandomOrder()->limit(12)->get();
        $anime = Video::where('genre', 'anime')
                     ->whereDate('created_at', '>=', Carbon::now()->subMonths(12))
                     ->where('views', '>=', '200000')->inRandomOrder()->limit(12)->get();

        return view('video.home', compact('videos', 'variety', 'drama', 'anime'));
    }

    public function genre(Request $request){
        /*$id = 2224;
        $genre = 'anime';
        $category = 'zqxshz';
        $season = '第一季';
        $title = '最強學生會長';
        $created_at = new Carbon('2012-04-04 11:20:52');
        for ($i = 1; $i <= 21; $i++) { 
            $video = Video::create([
                'id' => $id,
                'title' =>  $title.'【第'.$i.'話】',
                'caption' => $title.'【第'.$i.'話】',
                'genre' => $genre,
                'category' => $category,
                'season' => $season,
                'tags' => '最強學生會長 最強會長黑神',
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
        }
        $watch = Watch::create([
            'id' => 183,
            'genre' => $genre,
            'category' => $category,
            'season' => $season,
            'title' => $title,
            'description' => '',
            'imgur' => '',
        ]);*/

        $genre = $request->path();
        if ($genre == 'variety') {
            $watches = Watch::where('genre', $genre)->get();
        } else {
            $year = $request->has('y') && $request->y != null ? $request->y : '2020';
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

        $videos = Video::where('category', $watch->category)->where('season', $watch->season);
        if ($genre == 'drama' || $genre == 'anime') {
            $videos = $videos->orderBy('created_at', 'asc')->get();
        } else {
            $videos = $videos->orderBy('created_at', 'desc')->get();
        }

        $dropdown = Watch::where('category', $watch->category)->orderBy('created_at', 'asc')->get();
        $related = Watch::where('genre', $watch->genre)->orderBy('created_at', 'desc')->limit(30)->get();

        $is_program = true;
        return view('video.intro', compact('watch', 'videos', 'dropdown', 'related', 'is_program'));
    }

    public function watch(Request $request){
        /*$id = 1360;
        $genre = 'variety';
        $category = 'lddtz';
        $created_at = new Carbon('2019-01-12 14:47:15');
        for ($i = 1; $i <= 50; $i++) { 
            $video = Video::create([
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

        if ($request->has('v') && $request->v != 'null') {
            $video = Video::find($request->v);
            $video->views++;
            $video->save();
            $current = $video;

            $videosSelect = Video::where('id', '!=', $video->id)->inRandomOrder()->select('id', 'tags')->get()->toArray();
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

            $related = [];
            for ($i = 0; $i < 30; $i++) {
                array_push($related, Video::find($rankings[$i]['id']));
            }

            if ($video->category == 'video') {
                $videos = $related;
                $is_program = false;
                return view('video.show', compact('video', 'videos', 'current', 'is_program'));

            } else {
                if ($video->genre == 'drama' || $video->genre == 'anime') {
                    $videos = Video::where('category', $video->category)->where('season', $video->season)->orderBy('created_at', 'asc')->get();
                } else {
                    $videos = Video::where('category', $video->category)->where('season', $video->season)->orderBy('created_at', 'desc')->get();
                }

                $query = Video::where('category', $video->category)->where('season', $video->season)->orderBy('created_at', 'asc')->pluck('id')->toArray();
                $now = array_search($video->id, $query);
                while(key($query) !== null && key($query) !== $now) next($query);

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

                $dropdown = Watch::where('category', $video->category)->orderBy('created_at', 'asc')->get();

                $watch = Watch::where('category', $video->category)->where('season', $video->season)->first();
                $genre = $video->genre;
                $is_program = true;

                return view('video.showWatch', compact('genre', 'video', 'videos', 'related', 'prev', 'next', 'dropdown', 'watch', 'current', 'is_program'));
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
            $videos = Video::where('genre', $genre)->whereDate('created_at', '>=', Carbon::now()->subMonths($months))->orderBy('views', 'desc')->paginate(10);
            $html = $this->rankLoadHTML($videos);
            if ($request->ajax()) {
                return $html;
            }

            return view('video.rankIndex', compact('videos'));
        } else {
            $videos = Video::whereDate('created_at', '>=', Carbon::now()->subMonths(3))->orderBy('views', 'desc')->paginate(10);
            $html = $this->rankLoadHTML($videos);
            if ($request->ajax()) {
                return $html;
            }

            return view('video.rankIndex', compact('videos'));
        }
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
            $html .= view('video.singleSearchVideo', compact('video', 'is_program'));
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
     * @param  \App\Video  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $blog)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Video  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Video  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $blog)
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

        $videosSelect = Video::where('genre', '!=', 'blog')->orderBy('created_at', 'desc')->select('id', 'title', 'tags')->get()->toArray();
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
            array_push($videosArray, Video::find($rank['id']));
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

    public function searchGoogle(Request $request)
    {
        return view('video.searchGoogle');
    }

    public function has_prev(array $_array)
    {
      return prev($_array) !== false ?: key($_array) !== null;
    }

    public function has_next(array $_array)
    {
      return next($_array) !== false ?: key($_array) !== null;
    }

    public function getSourceIG(Request $request)
    {
        $url = Input::get('urlIG');
        try {
            $curl_connection = curl_init($url.'?__a=1');
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);

            $data = json_decode(curl_exec($curl_connection), true);
            curl_close($curl_connection);
            return $data['graphql']['shortcode_media']['video_url'];
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function updateDuration(Request $request)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $video = Video::find(Input::get('video'));
        $video->duration = Input::get('dura');
        $out->writeln("Duration is ".Input::get('dura'));
        $video->save();
    }
}
