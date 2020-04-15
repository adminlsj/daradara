@extends('layouts.app')

@section('nav')
  @include('nav.top')
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
    @include('nav.side')
</div>

<div class="main-content">
    <div id="signUpModal" style="background-color: #F5F5F5;">
        <form id="signUpModalForm" action="{{ route('register') }}" method="POST">

          {{ csrf_field() }}
          {{ Session::put('previousUrl', route('video.subscribes')) }}

          <div style="padding: 15px;">
            <div style="border: 0px; position: relative;" class="modal-header">
              <h4 style="color: #3F3F3F; margin-bottom: 0px; font-size: 1.7em" class="modal-title" id="signUpModalLabel">註冊帳戶</h4>
            </div>
            <div style="color: #3F3F3F; margin-top: -15px; font-size: 1.1em" class="modal-body">
              <div style="font-weight: 500;">在娛見日本 LaughSeeJapan 上享受最愛的影片、上傳原創內容，並與全世界觀眾分享您的影片。</div>
              <div class="form-group" style="margin-top: 20px;">
                <input type="email" class="form-control" name="email" id="email" placeholder="電郵地址" required>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="name" id="name" placeholder="名字" required>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="設定密碼" required>
              </div>
              <button style="height: 45px; margin-top: 10px; font-size: 1em;" type="submit" class="btn btn-info" name="submit">註冊</button>

              @include('layouts.socialLoginBtn')

              <div style="margin-top: 20px; font-size: 0.95em">
                <span style="font-weight: 400">已經有LaughSeeJapan帳戶了？</span>&nbsp;<a href="{{ route('login') }}" style="cursor: pointer; text-decoration: none; font-weight: 500;">登入</a>
              </div>
            </div>
          </div>

        </form>
    </div>
</div>
@endsection
