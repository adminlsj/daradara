<?php

namespace App\Http\Controllers;

use App\User;
use App\Video;
use App\Watch;
use Illuminate\Http\Request;
use Image;
use Auth;
use Redirect;
use Carbon\Carbon;
use Helper;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('edit', 'update', 'destroy', 'storeAvatar');
        $this->middleware('sameUser')->only('edit', 'update', 'destroy', 'storeAvatar', 'userEditUpload', 'userUpdateUpload');
    }

    public function userEditUpload(User $user, Request $request)
    {
        if (in_array($user->id, [1, 6944])) {
            $watches = $user->watches();
            return view('user.upload', compact('user', 'watches'));
        } else {
            return view('user.verify', compact('user'));
        }
    }

    public function userUpdateUpload(User $user, Request $request)
    {
        if ($request->type == 'playlist') {
            $watch = Watch::create([
                'user_id' => $user->id,
                'title' => $request->title,
                'description' => $request->description,
            ]);
            return Redirect::route('user.userEditUpload', ['user' => $user, 'watches' => $user->watches()]);

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

                $sd = $foreign_sd = request('foreign_sd');
                if (strpos($foreign_sd, 'spankbang') !== false) {
                    $sd = Video::getSpankbang($foreign_sd, implode(' ', preg_split('/\s+/', request('tags'))));
                    $foreign_sd = ['spankbang' => $foreign_sd];

                } elseif (strpos($foreign_sd, 'youjizz') !== false) {
                    $sd = Video::getYoujizz($foreign_sd);
                    $foreign_sd = ['youjizz' => $foreign_sd];

                }

                $video = Video::create([
                    'user_id' => $user->id,
                    'playlist_id' => request('channel'),
                    'title' => request('title'),
                    'translations' => ['JP' => request('translations')],
                    'caption' => request('description'),
                    'sd' => $sd,
                    'imgur' => Helper::get_string_between($url, 'https://i.imgur.com/', '.'),
                    'tags' => implode(' ', preg_split('/\s+/', request('tags'))),
                    'views' => 0,
                    'outsource' => false,
                    'created_at' => Carbon::createFromFormat('Y-m-d\TH:i:s', request('created_at'))->format('Y-m-d H:i:s'),
                    'uploaded_at' => Carbon::createFromFormat('Y-m-d\TH:i:s', request('created_at'))->format('Y-m-d H:i:s'),
                    'foreign_sd' => $sd == $foreign_sd ? null : $foreign_sd,
                    'cover' => request('cover'),
                ]);

                return Redirect::route('video.watch', ['v' => $video->id]);

            } else {
                return Redirect::back()->withErrors('封面圖片上傳失敗，請重新上傳。');
            }
            
        } else {
            return Redirect::back()->withErrors('封面圖片上傳失敗，請重新上傳。');
        }
    }
}
