@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: -20px">
    <div class="row">
        <form method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <div class="register col-md-8 col-md-offset-2">
                <div id="login-box">
                    <div class="register-right">
                        <h3 class="text-center" style="font-weight: 400; margin-bottom: 50px">註冊</h3>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}" style="margin: 0">
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="名字">
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}" style="margin: 0">
                            <input id="email" type="text" name="email" value="{{ old('email') }}" required placeholder="電郵地址">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}" style="margin: 0">
                            <input id="password" type="password" name="password" required placeholder="密碼">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group" style="margin: 0">
                            <input id="password-confirm" type="password" name="password_confirmation" required placeholder="確認密碼">
                        </div>

                        <button style="margin-top: 40px; font-size: 15px; width: 80%; margin-left: 10%" type="submit" class="btn btn-info btn-lg btn-block">註冊</button>
                    </div>

                    <div class="register-left">
                        <span class="loginwith">Sign in with<br />social network</span>
                        <a class="btn social-signin facebook" href="{{ url('/auth/facebook') }}">Log in with Facebook</a>
                        <a class="btn social-signin twitter">Log in with Twitter</a>
                        <a class="btn social-signin google">Log in with Google+</a>
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
