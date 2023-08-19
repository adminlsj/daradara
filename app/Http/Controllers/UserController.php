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
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . '072cefc76176835'));
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

            $name = strtolower(request('name'));
            if (strpos($name, 'ye9x') === false && strpos($name, 'ai129') === false) {

                $user->name = request('name');
                $user->email = request('email');
                $user->save();

            } else {
                abort(403);
            }

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
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . '072cefc76176835'));
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
        $description = null;
        $editable = false;
        $count = 0;
        $playlist = null;

        if ($pid == 'WL' && auth()->check()) {
            $results = Save::with(['video' => function($query) {
                $query->where('cover', '!=', null)->select('id', 'title', 'cover', 'imgur');
            }])->where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(42);
            $title = '稍後觀看';
            $count = $results->total();
            $editable = true;

        } elseif ($pid == 'LL' && auth()->check()) {
            $results = Like::with(['video' => function($query) {
                $query->where('cover', '!=', null)->select('id', 'title', 'cover', 'imgur');
            }])->where('user_id', $user->id)->where('foreign_type', 'video')->orderBy('created_at', 'desc')->paginate(42);
            $title = '喜歡的影片';
            $count = $results->total();
            $editable = true;

        } elseif (is_numeric($pid) && $playlist = Playlist::find($pid)) {
            if ($playlist->reference_id) {
                return Redirect::route('playlist.show', ['list' => $playlist->reference_id]);
            }
            $results = Playitem::with(['video' => function($query) {
                $query->where('cover', '!=', null)->select('id', 'title', 'cover', 'imgur');
            }])->where('playlist_id', $playlist->id)->orderBy('created_at', 'desc')->paginate(42);
            $title = $playlist->title;
            $description = $playlist->description;
            $count = $results->total();
            $editable = $user && $user->id == $playlist->user_id ? true : false;

        } else {
            abort(404);
        }

        $doujin = false;

        return view('playlist.show', compact('results', 'title', 'sub', 'description', 'doujin', 'pid', 'editable', 'count', 'playlist'));
    }

    public function createPlaylist(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'playlist-title' => 'required|string|max:255',
        ]);

        $playlist = Playlist::create([
            'user_id' => $user->id,
            'title' => request('playlist-title'),
            'description' => request('playlist-description'),
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
        $private = false;
        $checkbox = '';
        $checkbox .= view('video.playlist-checkbox', compact('first', 'id', 'checked', 'title', 'private'));

        $save_icon = 'playlist_add_check';
        $save_text = '已儲存';
        $save_btn = '';
        $save_btn .= view('video.saveBtn-new', compact('save_icon', 'save_text'));

        return response()->json([
            'checkbox' => $checkbox,
            'saveBtn' => $save_btn,
            'csrf_token' => csrf_token(),
        ]);
    }

    public function addPlaylist(Request $request)
    {
        $user = Auth::user();
        $pid_ref = request('playlist-reference-id');

        if (is_numeric($pid_ref) && $playlist_ref = Playlist::find($pid_ref)) {

            if ($playlist = Playlist::where('user_id', $user->id)->where('reference_id', $playlist_ref->id)->first()) {
                $playlist->delete();
                $exists = false;

            } else {
                $playlist = Playlist::create([
                    'user_id' => $user->id,
                    'reference_id' => $playlist_ref->id,
                    'reference_user_id' => $playlist_ref->user_id,
                    'title' => 'Reference',
                ]);
                $exists = true;
            }

            $add_btn = '';
            $add_btn .= view('playlist.add-btn', compact('exists'));

            return response()->json([
                'add_btn' => $add_btn,
                'csrf_token' => csrf_token(),
            ]);

        } else {
            abort(404);
        }
    }

    public function updatePlaylist(Request $request, Playlist $playlist)
    {
        if (auth()->check() && auth()->user()->id == $playlist->user_id) {

            if (request('playlist-delete')) {
                $playlist->delete();
                return Redirect::route('playlist.index');

            } else {
                $request->validate([
                    'playlist-title' => 'required|string|max:255',
                ]);
                $playlist->title = request('playlist-title');
                $playlist->description = request('playlist-description');
                $playlist->save();
                return Redirect::back();
            }

        } else {
            abort(403);
        }
    }

    public function deletePlayitem(Request $request)
    {
        $user = auth()->user();
        $playlist_id = request('playlist_id');
        $video_id = request('video_id');
        $count = request('count');

        if ($playlist_id == 'WL' && $save = Save::where('user_id', $user->id)->where('video_id', $video_id)->first()) {
            $save->delete();
            $count--;

        } elseif ($playlist_id == 'LL' && $like = Like::where('user_id', $user->id)->where('foreign_id', $video_id)->where('foreign_type', 'video')->first()) {
            $like->delete();
            $count--;

        } elseif (is_numeric($playlist_id) && $playitem = Playitem::where('user_id', $user->id)->where('playlist_id', $playlist_id)->where('video_id', $video_id)->first()) {
            $playitem->delete();
            $count--;

        } else {
            abort(404);
        }

        return response()->json([
            'video_id' => $video_id,
            'count' => $count,
            'csrf_token' => csrf_token(),
        ]);
    }
}
