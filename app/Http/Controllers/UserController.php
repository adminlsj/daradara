<?php

namespace App\Http\Controllers;

use App\User;
use App\Avatar;
use Illuminate\Http\Request;
use Hash;
use Storage;
use File;
use Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('edit', 'update', 'destroy', 'storeAvatar');
        $this->middleware('sameUser')->only('edit', 'update', 'destroy', 'storeAvatar');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $watches = $user->watches();
        return view('user.show', compact('user', 'watches'));
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

    public function savedJobsIndex(User $user, Request $request)
    {
        $savedJobs = $user->savedJobs->sortByDesc('created_at');

        $resume = $user->resume;

        $haveResumeImg = false;
        if ($resume->resumeImg != null) {
            $haveResumeImg = true;
        }

        return view('user.saved-jobs-index', compact('savedJobs', 'resume', 'haveResumeImg'));
    }
}
