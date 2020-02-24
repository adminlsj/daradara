@extends('layouts.app')

@section('nav')
    @include('layouts.nav-main', ['logoImage' => 'https://i.imgur.com/M8tqx5K.png', 'backgroundColor' => 'white', 'itemsColor' => "gray", 'menuBtnColor' => '#595959'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
    @include('video.sidebarMenu', ['theme' => 'white'])
</div>

<div class="main-content">
    <div id="loginModal" style="background-color: #F5F5F5;">
        <form method="POST" action="{{ route('login') }}">

          {{ csrf_field() }}

          <div style="padding: 15px;">
            <div style="border: 0px; position: relative;" class="modal-header">
              <h4 style="color: #3F3F3F; margin-bottom: 0px; font-size: 1.7em" class="modal-title" id="loginModalLabel">登入帳戶</h4>
            </div>
            <div style="color: #3F3F3F; margin-top: -15px; font-size: 1.1em" class="modal-body">
              <span style="font-weight: 500;">暫不開放公開註冊。</span>
              <div class="form-group" style="margin-top: 20px;">
                <input type="email" class="form-control" name="email" id="email" placeholder="電郵地址" required>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="密碼" required>
              </div>
              <button style="height: 45px; margin-top: 10px; font-size: 1em;" type="submit" class="btn btn-info" name="submit">登入</button>
              <hr style="margin:15px 0px">
              <span style="font-weight: 400">暫不開放公開註冊。</span>&nbsp;
            </div>
          </div>

        </form>
    </div>
</div>
@endsection
