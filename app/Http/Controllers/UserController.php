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
        $this->middleware('auth')->only('edit', 'update', 'destroy');
        $this->middleware('sameUser')->only('edit', 'update', 'destroy');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('user.show', compact('user'));
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
        $user->description = request('description');
        $user->bank_account = request('bank_account');
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
}
