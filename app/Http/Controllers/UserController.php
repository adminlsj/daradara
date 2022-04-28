<?php

namespace App\Http\Controllers;

use App\User;
use App\Video;
use App\Watch;
use App\Save;
use App\Like;
use App\Playlist;
use App\Playitem;
use Illuminate\Http\Request;
use Image;
use Auth;
use Redirect;
use Carbon\Carbon;
use App\Helper;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('edit', 'update', 'destroy', 'indexPlaylist', 'storeAvatar');
        $this->middleware('sameUser')->only('edit', 'update', 'destroy', 'storeAvatar', 'userEditUpload', 'userUpdateUpload');
    }

    public function edit(Request $request, User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $type = $request->type;

        if ($type == 'photo') {
            $original = $request->file('photo');
            $image = Image::make($original);
            $image = $image->fit(300, 300);
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
                $avatar = str_replace('.jpg', 'b.jpg', $url);
                $avatar = str_replace('.png', 'b.png', $avatar);
                $user->avatar_temp = $avatar;
                $user->save();
            } else {
                return back()->withErrors(['error' => '圖片上傳失敗']);
            }

        } elseif ($type == 'profile') {

            $this->validate(request(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,'.$user->id
            ]);

            $user->name = request('name');
            $user->email = request('email');
            $user->save();

        } elseif ($type == 'password') {

            $this->validate(request(), [
                'password_new' => 'required|string|min:6',
                'password_new_confirm' => 'required|string|min:6|same:password_new',
                'password_old' => ['required', function ($attribute, $value, $fail) use ($user) {
                    if (!\Hash::check($value, $user->password)) {
                        return $fail(__('舊密碼錯誤'));
                    }
                }],
            ], [
                'password_new_confirm.same' => '新密碼 與 確認新密碼 不相符',
            ]);

            $user->password = bcrypt(request('password_new'));
            $user->save();

        }

        return back()->withErrors(['success' => '已成功更新帳戶資料']);;
    }

    public function userEditUpload(User $user, Request $request)
    {
        if (in_array($user->id, [1, 6944])) {
            $watches = $user->watches;
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

                $tags = implode(' ', preg_split('/\s+/', request('tags')));
                $tags_array = [];
                foreach (explode(' ', $tags) as $tag) {
                    $tags_array[$tag] = 10;
                }
                $video = Video::create([
                    'user_id' => $user->id,
                    'playlist_id' => request('channel'),
                    'title' => request('title'),
                    'translations' => ['JP' => request('translations')],
                    'caption' => request('description'),
                    'sd' => $sd,
                    'imgur' => Helper::get_string_between($url, 'https://i.imgur.com/', '.'),
                    'tags' => $tags,
                    'tags_array' => $tags_array,
                    'views' => 0,
                    'outsource' => false,
                    'created_at' => Carbon::createFromFormat('Y-m-d\TH:i:s', request('created_at'))->format('Y-m-d H:i:s'),
                    'uploaded_at' => Carbon::createFromFormat('Y-m-d\TH:i:s', request('created_at'))->format('Y-m-d H:i:s'),
                    'foreign_sd' => $sd == $foreign_sd ? null : $foreign_sd,
                    'cover' => request('cover'),
                    'uncover' => strpos(request('cover'), 'E6mSQA2') !== false ? true : false,
                ]);

                return Redirect::route('video.watch', ['v' => $video->id]);

            } else {
                return Redirect::back()->withErrors('封面圖片上傳失敗，請重新上傳。');
            }
            
        } else {
            return Redirect::back()->withErrors('封面圖片上傳失敗，請重新上傳。');
        }
    }

    public function indexPlaylist(Request $request)
    {
        $user = Auth::user();

        $saves = Save::with(['video' => function($query) {
            $query->where('cover', '!=', null)->select('id', 'title', 'cover', 'imgur');
        }])->where('user_id', $user->id)->orderBy('created_at', 'desc')->limit(21)->get();

        $likes = Like::where('user_id', $user->id)->where('foreign_type', 'video')->orderBy('created_at', 'desc')->limit(21)->get()->load(['video' => function ($query) {
            $query->where('cover', '!=', null)->select('id', 'title', 'cover', 'imgur');
        }]);

        $playlists = Playlist::withCount('videos', 'videos_ref')->with([
            'videos' => function($query) {
                $query->select('videos.id', 'cover', 'imgur')->orderBy('playitems.created_at', 'desc')->limit(1);
            },
            'videos_ref' => function($query) {
                $query->select('videos.id', 'cover', 'imgur')->orderBy('playitems.created_at', 'desc')->limit(1);
            },
            'user' => function($query) {
                $query->select('users.id', 'name');
            },
            'user_ref' => function($query) {
                $query->select('users.id', 'name');
            },
            'playlist_ref' => function($query) {
                $query->select('id', 'title', 'description');
            }
        ])->where('user_id', $user->id)->orderBy('created_at', 'desc')->limit(200)->get();

        return view('playlist.index', compact('user', 'saves', 'likes', 'playlists'));
    }

    public function showPlaylist(Request $request)
    {
        $user = auth()->user();
        $pid = $request->list;
        $title = '播放清單';
        $sub = '分類';
        $editable = false;

        if ($pid == 'WL' && auth()->check()) {
            $results = Save::with(['video' => function($query) {
                $query->where('cover', '!=', null)->select('id', 'title', 'cover', 'imgur');
            }])->where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(42);
            $title = '稍後觀看';
            $sub = '儲存';
            $editable = true;

        } elseif ($pid == 'LL' && auth()->check()) {
            $results = Like::with(['video' => function($query) {
                $query->where('cover', '!=', null)->select('id', 'title', 'cover', 'imgur');
            }])->where('user_id', $user->id)->where('foreign_type', 'video')->orderBy('created_at', 'desc')->paginate(42);
            $title = '喜歡的影片';
            $sub = '讚好';
            $editable = true;

        } elseif (is_numeric($pid) && $playlist = Playlist::find($pid)) {
            if ($playlist->reference_id) {
                return Redirect::route('playlist.show', ['list' => $playlist->reference_id]);
            }
            $results = Playitem::with(['video' => function($query) {
                $query->where('cover', '!=', null)->select('id', 'title', 'cover', 'imgur');
            }])->where('playlist_id', $playlist->id)->orderBy('created_at', 'desc')->paginate(42);
            $title = $playlist->title;
            $sub = '清單';
            $editable = $user && $user->id == $playlist->user_id ? true : false;

        } else {
            abort(404);
        }

        $doujin = false;

        return view('playlist.show', compact('results', 'title', 'sub', 'doujin', 'pid', 'editable'));
    }

    public function createPlaylist(Request $request)
    {
        $user = Auth::user();

        $playlist = Playlist::create([
            'user_id' => $user->id,
            'title' => request('playlist-title'),
            'is_private' => true,
        ]);

        $playitem = Playitem::create([
            'user_id' => $user->id, 
            'playlist_id' => $playlist->id, 
            'video_id' => request('create-playlist-video-id'),
        ]);

        $first = false;
        $id = $playlist->id;
        $checked = true;
        $title = $playlist->title;
        $checkbox = '';
        $checkbox .= view('video.playlist-checkbox', compact('first', 'id', 'checked', 'title', 'checkbox'));

        return response()->json([
            'checkbox' => $checkbox,
            'csrf_token' => csrf_token(),
        ]);
    }
}
