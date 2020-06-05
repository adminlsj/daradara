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
<div class="main-content">
	<div style="background-color: #F5F5F5;">

    <div class="row no-gutter load-more-container" style="padding-top: 19px;">
      <img class="lazy user-show-title" style="float:left; width: 56px; height: 56px; border-top-left-radius: 3px; border-bottom-left-radius: 3px; margin-right: 15px" src="{{ $user->avatarCircleB() }}" data-src="{{ $user->avatar == null ? $user->avatarDefault() : $user->avatar->filename }}" data-srcset="{{ $user->avatar == null ? $user->avatarDefault() : $user->avatar->filename }}">
      <h5 class="user-show-title" style="font-size: 1em; color: #555555; font-weight: normal; line-height: 0px">{{ $subscribers }} 位訂閱者</h5>
      <h3 class="user-show-title no-select" style="font-size: 2em; margin-top: 4px; margin-bottom: 10px"><span style="font-size: 0.93em">{{ $user->name }}</span></h3>
    </div>

    <div class="subscribes-tab" style="border: none; margin-top: 4px; margin-bottom: 0px">
        <a href="{{ route('user.show', [$user, 'featured']) }}" style="margin-right: 5px;">首頁</a>
        <a href="{{ route('user.show', [$user, 'videos']) }}" class="active" style="margin-right: 5px;">影片</a>
        <a href="{{ route('user.show', [$user, 'playlists']) }}" style="margin-right: 5px;">播放清單</a>
        <a href="{{ route('user.show', [$user, 'about']) }}" style="margin-right: 5px;">簡介</a>
        @if (Auth::check() && $user->id == Auth::user()->id)
          <a href="{{ route('user.userEditUpload', $user) }}" style="margin-right: 5px;">上傳影片</a>
        @endif
    </div>

    <div class="row no-gutter load-more-container" style="margin-top: 18px; padding-bottom: 5px;">
        <div class="video-sidebar-wrapper" style="position: relative; overflow-y: hidden;">
            <div id="sidebar-results"><!-- results appear here --></div>
            <div style="text-align: center;" class="ajax-loading-default"><img style="width: 40px; height: auto; padding-top: 20px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
            <div style="text-align: center;" class="ajax-loading"></div>
        </div>
    </div>

	</div>
</div>

@endsection

@section('script')
  @parent
  <script src="{{ mix('js/loadMore.js') }}"></script>
@endsection