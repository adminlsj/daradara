<?php

namespace App\Http\Controllers;

use App\User;
use App\Video;
use App\Watch;
use App\Avatar;
use Illuminate\Http\Request;
use Hash;
use Storage;
use File;
use Image;
use Mail;
use Auth;
use App\Mail\UserStartUpload;
use Redirect;
use Carbon\Carbon;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('edit', 'update', 'destroy', 'storeAvatar');
        $this->middleware('sameUser')->only('edit', 'update', 'destroy', 'storeAvatar', 'userEditUpload', 'userUpdateUpload');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Request $request)
    {
        $watches = $user->watches();
        $first = true;
        if ($watches->first()) {
            foreach ($watches as $watch) {
                if ($first) {
                    $videos = Video::where('category', $watch->category);
                    $first = false;
                } else {
                    $videos = $videos->orWhere('category', $watch->category);
                }
            }
            $videos = $videos->orderBy('uploaded_at', 'desc')->paginate(12);

            $html = '';
            foreach ($videos as $video) {
                $html .= view('video.singleLoadMoreSliderVideos', compact('video'));
            }
            if ($request->ajax()) {
                return $html;
            }

        } else {
            $videos = null;
        }

        return view('user.show', compact('user', 'watches', 'videos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|same:password',
        ]);

        $user->name = request('name');
        $user->email = request('email');
        if ($user->password != request('password')) {
            $user->password = Hash::make(request('password'));
        }
        $user->save();
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function userStartUpload(Request $request)
    {
        $user = auth()->user();
        Mail::to('laughseejapan@gmail.com')->send(new UserStartUpload($user));
        return redirect()->action('UserController@userEditUpload', ['user' => $user]);
    }

    public function userEditUpload(User $user, Request $request)
    {
        return view('user.upload', compact('user'));
    }

    public function userUpdateUpload(User $user, Request $request)
    {
        $img = $_FILES['image'];
        if ($img['name'] == '') {  
            echo "<h2>An Image Please.</h2>";
        } else {
            $filename = $img['tmp_name'];
            $client_id = "932b67e13e4f069";
            $handle = fopen($filename, "r");
            $data = fread($handle, filesize($filename));
            $pvars   = array('image' => base64_encode($data));
            $timeout = 30;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
            curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
            $out = curl_exec($curl);
            curl_close ($curl);
            $pms = json_decode($out, true);
            $url = $pms['data']['link'];
            if ($url != "") {
                if ($request->type == 'channel') {
                    $watch = Watch::create([
                        'id' => Watch::orderBy('id', 'desc')->first()->id + 1,
                        'user_id' => $user->id,
                        'genre' => $request->genre,
                        'category' => $request->title,
                        'season' => '2020年',
                        'title' => $request->title,
                        'description' => $request->description,
                        'cast' => $request->tags,
                        'is_ended' => false,
                        'imgur' => $this->get_string_between($url, 'https://i.imgur.com/', '.'),
                    ]);
                    return Redirect::back()->withErrors('已成功創建頻道《'.$request->title.'》');

                } elseif ($request->type == 'video') {
                    $latest = Watch::where('title', request('channel'))->first()->videos()->last();
                    $title = request('title');
                    if ($title == "") {
                        $prevEpisode = $this->get_string_between($latest->title, '【第', '話】');
                        $episode = $prevEpisode;
                        if (is_numeric($prevEpisode) && floor($prevEpisode) != $prevEpisode) {
                            $episode = $prevEpisode + 0.5;
                        } else {
                            $episode = $prevEpisode + 1;
                        }
                        $title = str_replace($prevEpisode, $episode, $latest->title);
                    }

                    $video = Video::create([
                        'id' => Video::orderBy('id', 'desc')->first()->id + 1,
                        'title' => $title,
                        'caption' => request('description'),
                        'hd' => request('link'),
                        'sd' => request('link'),
                        'imgur' => $this->get_string_between($url, 'https://i.imgur.com/', '.'),
                        'genre' => $latest == null ? request('channel') : $latest->genre,
                        'category' => $latest == null ? request('channel') : $latest->category,
                        'season' => $latest == null ? '2020年' : $latest->season,
                        'tags' => request('tags') == "" ? $latest->tags : request('tags'),
                        'views' => Video::where('genre', 'variety')->whereDate('uploaded_at', '>=', Carbon::now()->subWeeks(4))->orWhere('genre', 'drama')->whereDate('uploaded_at', '>=', Carbon::now()->subWeeks(1))->orderBy('views', 'desc')->first()->views - 1,
                        'duration' => request('duration') == null ? 2000 : request('duration'),
                        'outsource' => false,
                        'created_at' => Carbon::createFromFormat('Y-m-d\TH:i:s', request('created_at'))->format('Y-m-d H:i:s'),
                        'uploaded_at' => Carbon::createFromFormat('Y-m-d\TH:i:s', request('uploaded_at'))->format('Y-m-d H:i:s'),
                    ]);

                    foreach ($video->sd() as $sd) {
                        $video->sd = str_replace($sd, Video::getLinkBB($sd, $video->outsource), $video->sd);
                        $video->save();
                    }

                    if (Auth::check() && Auth::user()->email == 'laughseejapan@gmail.com') {
                        $users = [];
                        $userArray = [];

                        if ($video->category != 'video') {
                            $watch = $video->watch();
                            $watch->updated_at = $video->uploaded_at;
                            $watch->save();

                            $subscribes = $watch->subscribes();
                            foreach ($subscribes as $subscribe) {
                                $user = $subscribe->user();
                                array_push($userArray, $user->id);
                            }
                        }

                        foreach ($video->tags() as $tag) {
                            $subscribes = Subscribe::where('tag', $tag)->get();
                            foreach ($subscribes as $subscribe) {
                                if (!in_array($subscribe->user()->id, $userArray)) {
                                    array_push($userArray, $subscribe->user()->id);
                                }
                            }
                        }

                        foreach ($userArray as $user_id) {
                            array_push($users, User::find($user_id));
                        }

                        foreach ($users as $user) {
                            Mail::to($user->email)->send(new SubscribeNotify($user, $video));
                            if (strpos($user->alert, 'subscribe') === false) {
                                $user->alert = $user->alert."subscribe";
                                $user->save();
                            }
                        }
                    }

                    return Redirect::back()->withErrors('已成功上傳影片《'.$title.'》');
                }
            } else {
                return Redirect::back()->withErrors('封面圖片上傳失敗，請重新上傳。');
            } 
        }
    }

    public function storeAvatar(User $user, Request $request)
    {
        $this->validate($request, [
            'avatar' => 'required|image',
        ]);

        if ($user->avatar != null) {
            if ($user->avatar->filename != "default_freerider_profile_pic") {
                Storage::disk('s3')->delete('avatars/originals/'.$user->avatar->filename.'.jpg');
                Storage::disk('s3')->delete('avatars/thumbnails/'.$user->avatar->filename.'.jpg');
            }
            $user->avatar->delete();
        }

        $avatar = request()->file('avatar');
        $extension = $avatar->getClientOriginalExtension();

        $image_thumb = Image::make($avatar);
        if ($image_thumb->height() <= $image_thumb->width()) {
            $image_thumb = $image_thumb->crop($image_thumb->height(), $image_thumb->height())->resize(100, 100);
        } else {
            $image_thumb = $image_thumb->crop($image_thumb->width(), $image_thumb->width())->resize(100, 100);
        }
        $image_thumb = $image_thumb->stream();

        Storage::disk('s3')->put('avatars/originals/'.$avatar->getFilename().'.jpg', File::get($avatar));
        Storage::disk('s3')->put('avatars/thumbnails/'.$avatar->getFilename().'.jpg', $image_thumb->__toString());

        Avatar::create([
            'user_id' => $user->id,
            'filename' => $avatar->getFilename(),
            'mime' => $avatar->getClientMimeType(),
            'original_filename' => $avatar->getClientOriginalName(),
        ]);

        return back();
    }

    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
