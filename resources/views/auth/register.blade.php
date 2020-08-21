@extends('layouts.app')

@section('nav')
    @include('nav.main', ['theme' => 'white'])
@endsection

@section('content')
  <div id="signUpModal" style="padding: 0 4%; margin-top: 100px; color: white;">
    <form action="{{ route('register') }}" method="POST">

      {{ csrf_field() }}
      {{ Session::put('previousUrl', '/') }}

      <h4 style="font-size: 1.7em">註冊帳戶</h4>
      <div style="font-size: 1.1em">
        <span style="font-weight: 500;">在 <span style="font-weight: bold">Hanime1.me</span> 上享受最愛的影片、崁入原創內容，並與全世界觀眾分享您的影片。</span>
        <div class="form-group" style="margin-top: 20px;">
          <input style="background-color: #131313; color: gray;" type="email" class="form-control" name="email" id="email" placeholder="電郵地址" required>
        </div>
        <div class="form-group">
          <input style="background-color: #131313; color: gray;" type="text" class="form-control" name="name" id="name" placeholder="名字" required>
        </div>
        <div class="form-group">
          <input style="background-color: #131313; color: gray;" type="password" class="form-control" name="password" id="password" placeholder="設定密碼" required>
        </div>
        <button style="height: 45px; margin-top: 10px; font-size: 1em; background-color: red !important; border-color: red !important;" type="submit" class="btn btn-info" name="submit">註冊</button>

        @include('layouts.socialLoginBtn')

        <div style="margin-top: 20px; font-size: 0.95em">
          <span style="font-weight: 400">已經有LaughSeeJapan帳戶了？</span>&nbsp;<a href="{{ route('login') }}" style="cursor: pointer; text-decoration: none; font-weight: 500;">登入</a>
        </div>
      </div>

    </form>
  </div>
@endsection
