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
        $files = File::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('file.index', compact('user', 'files'));
    }

    public function show(Request $request, File $file)
    {
        $views = $file->views;
        $views++;
        $file->views = $views;
        $file->save();
        $download_url = $this->sign_hembed_url("https://swiftshare.me/file/{$file->id}/{$file->title}.{$file->extension}", env('HEMBED_TOKEN'), 43200);
        return view('file.show', compact('file', 'download_url'));
    }

    public function store(Request $request, User $user)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        
        if ($uploaded_file = request()->file('image')) {
            $title = pathinfo($uploaded_file->getClientOriginalName(), PATHINFO_FILENAME); 
            $extension = $uploaded_file->extension();
            $size = $uploaded_file->getSize();
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

            Storage::disk('local')->put("file/{$file->id}/{$file->title}.{$file->extension}", file_get_contents($uploaded_file));

            return Redirect::route('file.show', ['file' => $file, 'title' => $file->title.'.'.$file->extension]);
        }
    }

    public function download(Request $request, File $file)
    {
        $downloads = $file->downloads;
        $downloads++;
        $file->downloads = $downloads;
        $file->save();

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
