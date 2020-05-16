@extends('layouts.app')

@section('head')
    @parent
    <title>{{ $user->name }}&nbsp;-&nbsp;娛見日本 LaughSeeJapan</title>
    <meta name="title" content="{{ $user->name }} - 娛見日本 LaughSeeJapan">
    <meta name="description" content="{{ $user->name }}">
@endsection

@section('nav')
	@include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')

<div class="hidden-sm hidden-xs sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>
<div class="main-content home">
	<div style="background-color: #F5F5F5;">

		<div class="home-genre-banner-wrapper" style="background-color: #EFE3E3; margin-bottom: 13px;">
      <img style="width: auto; height: 100%; float: right" src="https://i.imgur.com/Qlawqysh.png">
      <div class="home-genre-panel">
        <img class="lazy" style="float:left; width: 70px; height: 70px; border-top-left-radius: 3px; border-bottom-left-radius: 3px;" src="{{ $user->avatarCircleB() }}" data-src="{{ $user->avatar == null ? $user->avatarDefault() : $user->avatar->filename }}" data-srcset="{{ $user->avatar == null ? $user->avatarDefault() : $user->avatar->filename }}">
        <div style="height: 70px; margin-left: 85px; padding-top: 9px; padding-right: 15px;">
          <div style="font-size: 1.5em; font-weight: bold; color: #444444">{{ $user->name }}</div>
          <div style="color: gray; font-weight: bold; color: #666666">{{ $subscribers }} 位訂閱者</div>
        </div>
      </div>
      @if (Auth::check() && $user->id == Auth::user()->id)
        <div class="paravi-padding-setup" style="position: absolute; right: 0px; top: 10px">
          <form style="width:auto; height: auto; font-size: 1em; margin-top: 5px;" id="logout-form" action="{{ route('logout') }}" method="POST" class="pull-right">
              {{ csrf_field() }}
              <button style="background-color: inherit !important; color: #d84b6b;" class="btn btn-info" type="submit">登出</button>
          </form>
        </div>
      @endif
      <div class="subscribes-tab" style="border: none; position: absolute; bottom: -10px;">
        <a href="{{ route('user.show', [$user, 'featured']) }}" style="margin-right: 5px;">首頁</a>
        <a href="{{ route('user.show', [$user, 'videos']) }}" style="margin-right: 5px;">影片</a>
        <a href="{{ route('user.show', [$user, 'playlists']) }}" style="margin-right: 5px;">播放清單</a>
        <a href="{{ route('user.show', [$user, 'about']) }}" class="active" style="margin-right: 5px;">簡介</a>
        @if (Auth::check() && $user->id == Auth::user()->id)
          <a href="{{ route('user.userEditUpload', $user) }}" style="margin-right: 5px;">上傳影片</a>
        @endif
      </div>
    </div>

    <div class="paravi-padding-setup">
      <div>用戶名稱：{{ $user->name }}</div>
      <div>電郵地址：[***僅該用戶可查看***]</div>
    </div>
  </div>
</div>

@endsection

@section('script')
  @parent
  <script src="{{ mix('js/loadMore.js') }}"></script>
@endsection