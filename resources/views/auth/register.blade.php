@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: -20px">
    <div class="row">
        <form method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <div class="register col-md-8 col-md-offset-2">
                <div id="login-box">
                    <div class="register-left">
                        <h3 class="text-center" style="font-weight: 400; margin-bottom: 50px">Sign up</h3>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}" style="margin: 0">
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Name">
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

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
                            <input id="password-confirm" type="password" name="password_confirmation" required placeholder="Retype password">
                        </div>

                        <button style="margin-top: 40px; font-size: 15px; width: 80%; margin-left: 10%" type="submit" class="btn btn-info btn-lg btn-block">註冊</button>
                    </div>

                    <div class="register-right">
                        <span class="loginwith">Sign in with<br />social network</span>
                        <button class="social-signin facebook">Log in with facebook</button>
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
