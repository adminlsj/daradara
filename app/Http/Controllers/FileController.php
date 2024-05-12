<?php

namespace App\Http\Controllers;

use App\User;
use App\File;
use App\Watch;
use Illuminate\Http\Request;
use Image;
use Auth;
use Redirect;
use Carbon\Carbon;
use App\Helper;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('edit', 'update', 'destroy', 'indexPlaylist', 'storeAvatar');
        $this->middleware('sameUser')->only('edit', 'update', 'destroy', 'storeAvatar', 'userEditUpload', 'userUpdateUpload');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $files = File::where('user_id', $user->id)->get();
        return view('file.index', compact('user', 'files'));
    }

    public function show(Request $request, File $file)
    {
        $views = $file->views;
        $views++;
        $file->views = $views;
        $file->save();
        $download_url = $this->sign_hembed_url("https://swiftshare.hanime1.com/file/{$file->id}/{$file->title}.{$file->extension}", env('HEMBED_TOKEN'), 43200);
        return view('file.show', compact('file', 'download_url'));
    }

    public function store(Request $request, User $user)
    {
        if ($file = request()->file('image')) {
            $title = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); 
            $extension = $file->extension();
            $size = $file->getSize();
            $file = File::create([
                'user_id' => $user->id,
                'title' => $title,
                'extension' => $extension,
                'size' => $size,
                'url' => 'temp',
                'views' => 0,
                'downloads' => 0,
                'client_ip' => '127.0.0.1'
            ]);

            Storage::disk('local')->put("file/{$file->id}/{$file->title}.{$file->extension}", $file);

            return Redirect::route('file.show', ['file' => $file, 'title' => $file->title.'.'.$file->extension]);
        }
    }

    public function download(Request $request, File $file)
    {
        return response()->download(storage_path("/storage/app/file/{$file->id}/{$file->title}.{$file->extension}"));
    }

    public static function sign_hembed_url($url, $securityKey, $expiration_time = 3600)
    {
        $url_scheme = parse_url($url, PHP_URL_SCHEME);
        $url_host = parse_url($url, PHP_URL_HOST);
        $url_path = parse_url($url, PHP_URL_PATH);
        $url_query = parse_url($url, PHP_URL_QUERY);

        $expires = time() + $expiration_time;
        $token = md5("$expires$url_path $securityKey", true);
        $token = base64_encode($token);
        $token = strtr($token, '+/', '-_');
        $token = str_replace('=', '', $token);

        return "{$url_scheme}://{$url_host}{$url_path}?token={$token}&expires={$expires}";
    }
}
