<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Savelist;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected function redirectTo()
    {
        $previousUrl = Session::get('previousUrl');
        if ($previousUrl !== '') {
            return $previousUrl;
        } else {
            return '/';
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ], [
            'email.unique' => 'This email address has been registered already. If you forgot your password, please contact us at swiftshare@gmail.com',
            'email.max'  => 'This email address is too long',
            'password.min'  => 'Please enter a password longer than 6 characters',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'avatar_temp' => 'https://vdownload.hembed.com/image/icon/user_default_image.jpg?secure=ue9M119kdZxHcZqDPrunLQ==,4855471320'
        ]);

        // Create user anime watching statuslist
        Savelist::create([
            'user_id' => $user->id,
            'title' => 'watching',
            'is_status' => true,
            'is_private' => false,
            'type' => 'anime'
        ]);

        // Create user anime planning statuslist
        Savelist::create([
            'user_id' => $user->id,
            'title' => 'planning',
            'is_status' => true,
            'is_private' => false,
            'type' => 'anime'
        ]);

        // Create user anime completed statuslist
        Savelist::create([
            'user_id' => $user->id,
            'title' => 'completed',
            'is_status' => true,
            'is_private' => false,
            'type' => 'anime'
        ]);

        // Create user anime rewatching statuslist
        Savelist::create([
            'user_id' => $user->id,
            'title' => 'rewatching',
            'is_status' => true,
            'is_private' => false,
            'type' => 'anime'
        ]);

        // Create user anime paused statuslist
        Savelist::create([
            'user_id' => $user->id,
            'title' => 'paused',
            'is_status' => true,
            'is_private' => false,
            'type' => 'anime'
        ]);

        // Create user anime dropped statuslist
        Savelist::create([
            'user_id' => $user->id,
            'title' => 'dropped',
            'is_status' => true,
            'is_private' => false,
            'type' => 'anime'
        ]);

        return $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user, true);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectTo());
    }
}
