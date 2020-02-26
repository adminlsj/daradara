<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use App\Avatar;
use App\Watch;
use Auth;
use Socialite;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $previousUrl = '';

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo()
    {
        if (strpos($this->previousUrl, "/watch?v=") !== FALSE) {
            return url()->previous().'&from_subscribe=1';

        } elseif ((strpos($previous, "/variety/") !== FALSE || strpos($previous, "/drama/") !== FALSE || strpos($previous, "/anime/") !== FALSE)) {
            return url()->previous().'?from_subscribe=1';

        } else {
            return '/subscribes';
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the OAuth Provider.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        $this->previousUrl = url()->previous();
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that 
     * redirect them to the authenticated users homepage.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return Redirect::to('auth/'.$provider);
        }

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect($this->redirectTo());
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        if ($authUser = User::where('provider_id', strval($user->getId()))->first()) {
            return $authUser;
        }

        if ($currentUser = User::where('email', $user->getEmail())->first()) {
            $currentUser->provider = $provider;
            $currentUser->provider_id = $user->getId();
            $currentUser->save();
            return $currentUser;
        }

        $localUser = User::create([
            'name'     => $user->getName(),
            'email'    => $user->getEmail(),
            'provider' => $provider,
            'provider_id' => $user->getId(),
            'password' => bcrypt(uniqid())
        ]);

        Avatar::create([
            'user_id'     => $localUser->id,
            'filename'    => $user->getAvatar(),
            'mime' => 'jpg',
            'original_filename' => $user->getAvatar(),
        ]);

        return $localUser;
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($request->ajax()) {
            return response()->json([
                'href' => route('user.show', auth()->user()),
                'email' => auth()->user()->email,
                'subscribe_user_id' => auth()->user()->id,
                'csrf_token' => csrf_token(),
            ]);
        }

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), true
        );
    }
}
