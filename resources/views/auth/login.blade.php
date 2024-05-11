@extends('layouts.app')

@section('nav')
    @include('nav.md')
@endsection

@section('content')

  <div id="loginModal" class="list-rows-wrapper" style="padding: 0 13.6%; color: white;">
      <form method="POST" action="{{ route('login') }}">

        {{ csrf_field() }}
        {{ Session::put('previousUrl', '/') }}

        <h4 style="font-size: 1.7em;">Login</h4>
        <div style="font-size: 1.1em;">
          <span style="font-weight: 500;">Upload, store, and share your files on <span style="font-weight: bold">SwiftShare.org</span>. All in a Swift.</span>
          <div class="form-group" style="margin-top: 20px;">
            <input style="background-color: #131313; color: gray;" type="email" class="form-control" name="email" id="email" placeholder="電郵地址" required>
          </div>
          <div class="form-group">
            <input style="background-color: #131313; color: gray;" type="password" class="form-control" name="password" id="password" placeholder="密碼" required>
          </div>

          <div style="margin-top: 20px; margin-bottom: 20px; font-size: 0.95em">
            <a href="/password/reset" target="_blank" style="cursor: pointer; text-decoration: none; font-weight: 500;">Forget password?</a>
          </div>

          <button style="height: 45px; margin-top: 10px; font-size: 1em; background-color: red !important; border-color: red !important;" type="submit" class="btn btn-info" name="submit">登入</button>
          @include('layouts.socialLoginBtn')

          <div style="margin-top: 20px; font-size: 0.95em">
            <span style="font-weight: 400">Don't have an account yet?</span>&nbsp;<a href="{{ route('register') }}" style="cursor: pointer; text-decoration: none; font-weight: 500;">Register</a>
          </div>
        </div>

      </form>
  </div>

  <br>

  @include('layouts.footer')

@endsection
