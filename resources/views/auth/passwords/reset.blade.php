@extends('layouts.app')

@section('nav')
    @include('nav.main', ['theme' => 'white'])
@endsection

@section('content')

  <div id="loginModal" class="list-rows-wrapper" style="padding: 0 4%; color: white;">
      <form method="POST" action="{{ route('password.request') }}">

        {{ csrf_field() }}

        <input type="hidden" name="token" value="{{ $token }}">

        <h4 style="font-size: 1.7em;">重設密碼</h4>
        <div style="font-size: 1.1em;">
          <span style="font-weight: 500;">在 <span style="font-weight: bold">Hanime1.me</span> 上享受最愛的影片、崁入原創內容，並與全世界觀眾分享您的影片。</span>
          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}" style="margin-top: 20px;">
            <input style="background-color: #131313; color: gray;" type="email" class="form-control" name="email" id="email" placeholder="電郵地址" required autofocus>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <input style="background-color: #131313; color: gray;" type="password" class="form-control" name="password" id="password" placeholder="新密碼" required>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <input style="background-color: #131313; color: gray;" type="password" class="form-control" name="password_confirmation" id="password-confirm" placeholder="確認新密碼" required>
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
          </div>

          <button style="height: 45px; margin-top: 10px; font-size: 1em; background-color: red !important; border-color: red !important;" type="submit" class="btn btn-info" name="submit">重設密碼</button>

        </div>

      </form>
  </div>

@endsection
