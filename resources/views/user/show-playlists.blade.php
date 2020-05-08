@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')

<div class="hidden-sm hidden-xs sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>
<div class="main-content">
	<div style="background-color: #F5F5F5;">

		<div class="user-show-general-panel" style="padding-top: 20px; background-color: #F5F5F5;">
      <div class="paravi-padding-setup">
        <img class="lazy" style="float:left; border-radius: 50%; width: 70px; height: 70px;" src="{{ $user->avatarCircleB() }}" data-src="{{ $user->avatar == null ? $user->avatarDefault() : $user->avatar->filename }}" data-srcset="{{ $user->avatar == null ? $user->avatarDefault() : $user->avatar->filename }}">
        @if (Auth::check() && $user->id == Auth::user()->id)
          <form style="width:auto; height: auto; font-size: 1em; margin-top: 9px;" id="logout-form" action="{{ route('logout') }}" method="POST" class="pull-right">
              {{ csrf_field() }}
              <button style="background-color: inherit !important; color: #d84b6b" class="btn btn-info" type="submit">登出</button>
          </form>
          <a style="width:auto; height: auto; font-size: 1em; margin-top: 9px; margin-right: 5px; color: white" class="btn btn-info pull-right" href="{{ route('user.userEditUpload', $user) }}">上傳影片</a>
        @endif
        <div style="height: 70px; margin-left: 80px">
          <div style="font-size: 1.5em">{{ $user->name }}</div>
          <div style="color: gray">{{ $subscribers }} 位訂閱者</div>
        </div>
      </div>

      <div class="subscribes-tab" style="margin-top: 20px; margin-bottom: 0px">
        <a href="{{ route('user.show', [$user, 'featured']) }}" style="margin-right: 5px;">首頁</a>
        <a href="{{ route('user.show', [$user, 'videos']) }}" style="margin-right: 5px;">影片</a>
        <a href="{{ route('user.show', [$user, 'playlists']) }}" class="active" style="margin-right: 5px;">播放清單</a>
        <a href="{{ route('user.show', [$user, 'about']) }}" style="margin-right: 5px;">簡介</a>
      </div>
    </div>

    <div class="row no-gutter load-more-container">
      <div class="video-sidebar-wrapper">
          <div id="sidebar-results"><!-- results appear here --></div>
          <div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 25px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
      </div>
    </div>

  </div>
</div>

@endsection

@section('script')
  @parent
  <script src="{{ mix('js/loadMore.js') }}"></script>
@endsection