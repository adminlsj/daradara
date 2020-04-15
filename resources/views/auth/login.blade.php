@extends('layouts.app')

@section('nav')
  @include('nav.top')
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
    @include('nav.side')
</div>

<div class="main-content">
    <div id="loginModal" style="background-color: #F5F5F5;">
        <form method="POST" action="{{ route('login') }}">

          {{ csrf_field() }}
          {{ Session::put('previousUrl', route('subscribe.index')) }}

          <div style="padding: 15px;">
            <div style="border: 0px; position: relative;" class="modal-header">
              <h4 style="color: #3F3F3F; margin-bottom: 0px; font-size: 1.7em" class="modal-title" id="loginModalLabel">登入帳戶</h4>
            </div>
            <div style="color: #3F3F3F; margin-top: -15px; font-size: 1.1em" class="modal-body">
              <span style="font-weight: 500;">在娛見日本 LaughSeeJapan 上享受最愛的影片、上傳原創內容，並與全世界觀眾分享您的影片。</span>
              <div class="form-group" style="margin-top: 20px;">
                <input type="email" class="form-control" name="email" id="email" placeholder="電郵地址" required>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="密碼" required>
              </div>
              <button style="height: 45px; margin-top: 10px; font-size: 1em;" type="submit" class="btn btn-info" name="submit">登入</button>
              @include('auth.social-btns')

              <div style="margin-top: 20px; font-size: 0.95em">
                <span style="font-weight: 400">尚未擁有帳戶？</span>&nbsp;<a href="{{ route('register') }}" style="cursor: pointer; text-decoration: none; font-weight: 500;">註冊</a>
              </div>
            </div>
          </div>

        </form>
    </div>
</div>
@endsection
