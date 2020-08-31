<?php

namespace App\Http\Controllers;

use App\User;
use App\Video;
use App\PendingVideo;
use App\Watch;
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
use App\Jobs\SendSubscriptionEmail;

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
        $subscribers = 5000;
        /*if ($watches->first()) {
            foreach ($watches as $watch) {
                $subscribers = $subscribers + Subscribe::where('tag', $watch->title)->count();
            }
        }*/

        switch ($request->genre) {
            case 'videos':
                if ($request->ajax()) {
                    $videos = Video::where('user_id', $user->id)->orderBy('created_at', 'desc')->select('id', 'user_id', 'imgur', 'title')->paginate(30);
                    $html = '';
                    foreach ($videos as $video) {
                        $html .= view('video.card', compact('video'));
                    }
                    return $html;
                }
                return view('user.show-videos', compact('user', 'subscribers'));
                break;

            case 'playlists':
                if ($request->ajax()) {
                    $userWatches = Watch::withVideos()->where('user_id', $user->id)->orderBy('updated_at', 'desc')->select('id', 'title')->paginate(24);
                    $html = '';
                    foreach ($userWatches as $watch) {
                        $video = $watch->videos->first();
                        $html .= view('video.singleLoadMoreSliderPlaylists', compact('watch', 'video'));
                    }
                    return $html;
                }
                return view('user.show-playlists', compact('user', 'watches', 'subscribers'));

            case 'about':
                return view('user.show-about', compact('user', 'subscribers'));
            
            default:
                $videos = Video::with('user:id,name')->where('user_id', $user->id)->orderBy('uploaded_at', 'desc')->limit(8)->select('id', 'user_id', 'imgur', 'title')->get();
                $trendings = Video::with('user:id,name')->where('user_id', $user->id)->whereDate('uploaded_at', '>=', Carbon::now()->subWeeks(1))->orderBy('views', 'desc')->limit(8)->select('id', 'user_id', 'imgur', 'title')->get();
                $playlists = Watch::withVideos()->where('user_id', $user->id)->orderBy('created_at', 'desc')->limit(8)->select('id', 'title')->get();
                $is_mobile = $this->checkMobile();
                return view('user.show-featured', compact('user', 'subscribers', 'videos', 'trendings', 'playlists', 'is_mobile'));
                break;
        }
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
        if (Auth::user()->email == 'guaishushukanlifan@qq.com' || Auth::user()->email == 'laughseejapan@gmail.com') {
            $watches = $user->watches();
            return view('user.upload', compact('user', 'watches'));
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

                $foreign_sd = request('foreign_sd');
                if (strpos($foreign_sd, 'spankbang') !== false) {
                    $sd = Video::getSpankbang($foreign_sd, implode(' ', preg_split('/\s+/', request('tags'))));
                    $foreign_sd = ['spankbang' => $foreign_sd];

                } elseif (strpos($foreign_sd, 'youjizz') !== false) {
                    $sd = Video::getYoujizz($foreign_sd);
                    $foreign_sd = ['youjizz' => $foreign_sd];

                } elseif (strpos($foreign_sd, 'slutload') !== false) {
                    $sd = Video::getSlutload($foreign_sd);
                    $foreign_sd = ['slutload' => $foreign_sd];
                }

                $video = Video::create([
                    'user_id' => $user->id,
                    'playlist_id' => request('channel'),
                    'title' => request('title'),
                    'translations' => ['JP' => request('translations')],
                    'caption' => request('description'),
                    'sd' => $sd,
                    'imgur' => $this->get_string_between($url, 'https://i.imgur.com/', '.'),
                    'tags' => implode(' ', preg_split('/\s+/', request('tags'))),
                    'views' => 0,
                    'outsource' => false,
                    'created_at' => Carbon::createFromFormat('Y-m-d\TH:i:s', request('created_at'))->format('Y-m-d H:i:s'),
                    'uploaded_at' => Carbon::createFromFormat('Y-m-d\TH:i:s', request('created_at'))->format('Y-m-d H:i:s'),
                    'foreign_sd' => $foreign_sd,
                    'cover' => request('cover'),
                ]);

                $userArray = [];
                if ($video->playlist_id != '') {
                    $watch = $video->watch;
                    $watch->updated_at = $video->uploaded_at;
                    $watch->save();

                    $subscribes = $watch->subscribes();
                    foreach ($subscribes as $subscribe) {
                        $user = $subscribe->user();
                        if (strpos($user->alert, 'subscribe') === false) {
                            $user->alert = $user->alert."subscribe";
                            $user->save();
                        }
                        array_push($userArray, $user->id);
                    }
                }

                foreach ($video->tags() as $tag) {
                    $subscribes = Subscribe::where('tag', $tag)->get();
                    foreach ($subscribes as $subscribe) {
                        if (!in_array($subscribe->user()->id, $userArray)) {
                            $user = $subscribe->user();
                            if (strpos($user->alert, 'subscribe') === false) {
                                $user->alert = $user->alert."subscribe";
                                $user->save();
                            }
                        }
                    }
                }

                // SendSubscriptionEmail::dispatch($video);

                return Redirect::route('video.watch', ['v' => $video->id]);
            }
        } else {
            return Redirect::back()->withErrors('封面圖片上傳失敗，請重新上傳。');
        }
    }

    public function getSourceQQ(Request $request)
    {
        $id = $request->id;
        if (strpos($id, '1098_') !== false) {
            return 'https://www.agefans.tv/age/player/ckx1/?url='.urlencode(Video::getSourceQQ("https://quan.qq.com/video/".$id));
        } elseif (strpos($id, '1006_') !== false || strpos($id, '1097_') !== false) {
            return 'https://www.agefans.tv/age/player/ckx1/?url='.urlencode(Video::getSourceQZ($id));
        } elseif (strpos($id, 'gss3.baidu.com') !== false) {
            return 'https://www.agefans.tv/age/player/ckx1/?url='.urlencode($id);
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

    public function checkMobile()
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $is_mobile = false;
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) { 
            $is_mobile = true;
        }
        return $is_mobile;
    }
}
