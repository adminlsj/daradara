<?php

namespace App\Http\Controllers;

use App\User;
use App\Video;
<<<<<<< HEAD
use App\Watch;
=======
use App\Playlist;
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
use App\Subscribe;
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
<<<<<<< HEAD
        $watches = $user->watches();
        $subscribers = 0;
        if ($watches->first()) {
            foreach ($watches as $watch) {
                $subscribers = $subscribers + Subscribe::where('tag', $watch->title)->count();
            }
        }

        switch ($request->genre) {
            case 'featured':
                if ($request->ajax()) {
                    $videos = Video::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(12);
                    $html = '';
                    foreach ($videos as $video) {
                        $html .= view('video.singleLoadMoreSliderVideos', compact('video'));
                    }
                    return $html;
                }
                return view('user.show-featured', compact('user', 'subscribers'));

            case 'playlists':
                return view('user.show-playlists', compact('user', 'watches', 'subscribers'));

            case 'about':
                return view('user.show-about', compact('user', 'subscribers'));
            
            default:
                if ($request->ajax()) {
                    $videos = Video::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(12);
                    $html = '';
                    foreach ($videos as $video) {
                        $html .= view('video.singleLoadMoreSliderVideos', compact('video'));
                    }
                    return $html;
                }
                return view('user.show-featured', compact('user', 'subscribers'));
                break;
        }
    }

    public function showPlaylist(User $user, Request $request)
    {
        $watches = $user->watches();

        $subscribers = 0;
        if ($watches->first()) {
            foreach ($watches as $watch) {
                $subscribers = $subscribers + Subscribe::where('tag', $watch->title)->count();
            }
        }

        return view('user.show-playlists', compact('user', 'watches', 'subscribers'));
=======
        $playlists = $user->playlists();
        $subscribers = 0;
        if ($playlists->first()) {
            foreach ($playlists as $playlist) {
                $subscribers = $subscribers + Subscribe::where('tag', $playlist->title)->count();
            }
        }

        $videos = Video::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(12);
        $html = '';
        foreach ($videos as $video) {
            $html .= view('video.load-more', compact('video'));
        }
        if ($request->ajax()) {
            return $html;
        }

        return view('user.show', compact('user', 'playlists', 'videos', 'subscribers'));
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
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

<<<<<<< HEAD
    public function userStartUpload(Request $request)
    {
        $user = auth()->user();
        Mail::to('laughseejapan@gmail.com')->send(new UserStartUpload($user));
        return redirect()->action('UserController@userEditUpload', ['user' => $user]);
    }

    public function userEditUpload(User $user, Request $request)
    {
        $watches = $user->watches();
        return view('user.upload', compact('user', 'watches'));
=======
    public function userEditUpload(User $user, Request $request)
    {
        $playlists = $user->playlists();
        return view('user.upload', compact('user', 'playlists'));
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
    }

    public function userUpdateUpload(User $user, Request $request)
    {
        if ($request->type == 'playlist') {
<<<<<<< HEAD
            $watch = Watch::create([
                'id' => Watch::orderBy('id', 'desc')->first()->id + 1,
                'user_id' => $user->id,
                'genre' => '',
                'category' => '',
                'season' => '',
                'title' => $request->title,
                'description' => $request->description,
                'cast' => '',
                'is_ended' => false,
                'imgur' => '',
            ]);
            return Redirect::back()->withErrors('已成功建立播放列表《'.$request->title.'》');
=======
            $playlist = Playlist::create([
                'id' => Watch::orderBy('id', 'desc')->first()->id + 1,
                'user_id' => $user->id,
                'title' => $request->title,
                'description' => $request->description,
            ]);
            return Redirect::back()->withErrors('已成功建立播放列表《'.$playlist->title.'》');
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c

        } elseif ($request->type == 'video') {
            $original = request()->file('image');
            $image = Image::make($original);
            $image = $image->fit(2880, 1620);
            $image = $image->stream();
            $pvars = array('image' => base64_encode($image));

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . '932b67e13e4f069'));
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
            $out = curl_exec($curl);
            curl_close ($curl);
            $pms = json_decode($out, true);
            $url = $pms['data']['link'];

            if ($url != "") {
                $video = Video::create([
                    'id' => Video::orderBy('id', 'desc')->first()->id + 1,
                    'user_id' => $user->id,
                    'playlist_id' => request('channel'),
                    'title' => request('title'),
<<<<<<< HEAD
                    'caption' => request('description'),
                    'hd' => request('link'),
                    'sd' => request('link'),
                    'imgur' => $this->get_string_between($url, 'https://i.imgur.com/', '.'),
                    'genre' => '',
                    'category' => '',
                    'season' => '',
                    'tags' => implode(' ', preg_split('/\s+/', request('tags'))),
                    'views' => 0,
                    'duration' => request('duration') == null ? 2000 : request('duration'),
=======
                    'description' => request('description'),
                    'link' => request('link'),
                    'imgur' => $this->get_string_between($url, 'https://i.imgur.com/', '.'),
                    'tags' => implode(' ', preg_split('/\s+/', request('tags'))),
                    'views' => 0,
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
                    'outsource' => true,
                    'created_at' => Carbon::createFromFormat('Y-m-d\TH:i:s', request('created_at'))->format('Y-m-d H:i:s'),
                    'uploaded_at' => Carbon::createFromFormat('Y-m-d\TH:i:s', request('uploaded_at'))->format('Y-m-d H:i:s'),
                ]);

                if ($video->playlist_id != '') {
<<<<<<< HEAD
                    $watch = $video->watch();
                    $watch->updated_at = $video->updated_at;
                    $watch->save();
=======
                    $playlist = $video->playlist();
                    $playlist->updated_at = $playlist->updated_at;
                    $playlist->save();
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
                }

                /*$users = [];
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
                }*/

                return Redirect::back()->withErrors('已成功上傳影片《'.$video->title.'》');
            }
        } else {
            return Redirect::back()->withErrors('封面圖片上傳失敗，請重新上傳。');
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
