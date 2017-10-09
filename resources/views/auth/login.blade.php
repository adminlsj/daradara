@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: -20px">
    <div class="row">
        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="register col-md-8 col-md-offset-2">
                <div id="login-box">
                    <div class="register-left">
                        <h3 class="text-center" style="font-weight: 400; margin-bottom: 50px">Login</h3>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}" style="margin: 0">
                            <input id="email" type="text" name="email" value="{{ old('email') }}" required placeholder="E-mail">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}" style="margin: 0">
                            <input id="password" type="password" name="password" required placeholder="Password">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group" style="margin: 0">
                            <div class="checkbox">
                                <label style="font-size: 13px">
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>Remember Me
                                </label>
                            </div>
                        </div>

                        <button style="margin-top: 40px; font-size: 15px; width: 80%; margin-left: 10%" type="submit" class="btn btn-info btn-lg btn-block">登入</button>

                        <a style="font-size: 13px; width: 80%; margin-left: 10%; color:grey" class="btn btn-link" href="{{ route('password.request') }}">
                            Forgot Your Password?
                        </a>
                    </div>

                    <div class="register-right">
                        <span class="loginwith">Sign in with<br />social network</span>
                        <button class="social-signin facebook"><a style="color: white" href="{{ url('/auth/facebook') }}">Log in with facebook</a></button>
                        <button class="social-signin twitter">Log in with Twitter</button>
                        <button class="social-signin google">Log in with Google+</button>
                    </div>

                    <div class="or">
                        OR
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
