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

		<div class="paravi-padding-setup" style="padding-top: 20px; padding-bottom: 20px; background-color: #F9F9F9; margin-bottom: 25px">
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

      <div class="user-show-tab">
        <a href="{{ route('user.show', [$user, 'featured']) }}" class="user-show-tablinks active">首頁</a>
        <a href="{{ route('user.show', [$user, 'videos']) }}" class="user-show-tablinks">影片</a>
        <a style="width: 100px;" href="{{ route('user.show', [$user, 'playlists']) }}" class="user-show-tablinks">播放清單</a>
        <a href="{{ route('user.show', [$user, 'about']) }}" class="user-show-tablinks">簡介</a>
      </div>
		</div>

    <div class="paravi-padding-setup user-show-top-panel">
      <div class="row">
        <div class="col-md-6">
          @include('video.player')
        </div>
        <div class="col-md-6">
          <div style="margin-top: 0px; margin-bottom: 0px" class="video-slider-title">
            <a href="{{ route('video.watch') }}?v={{ $video->id }}"><h4>{{ $video->title }}</h4></a>
          </div>
          <h5 style="line-height: 37px; color: dimgray; font-weight: 500; margin-top: -15px;">{{ $user->name }} • {{ Carbon\Carbon::parse($video->uploaded_at)->diffForHumans() }}</h5>
          <h5 class="hidden-xs hidden-sm" style="color: dimgray; font-weight: 400; margin-top: -5px; line-height: 20px; margin-bottom: -5px; white-space: pre-wrap;">{{ $video->caption }}</h5>
          <h5 class="hidden-xs hidden-sm" style="font-weight: 400; line-height: 20px; margin-bottom: 15px">
            @foreach ($video->tags() as $tag)
                <a style="margin-right: 3px; color: #4377e8;" href="{{ route('video.subscribeTag') }}?query={{ $tag }}">#{{ $tag }}</a>
            @endforeach
          </h5>
        </div>
      </div>
    </div>

    <div class="video-slider-title paravi-padding-setup">
      <a href="{{ route('user.show', [$user, 'videos']) }}"><h4>最新精彩內容<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
    </div>
    @include('video.single-video-slider', ['videos' => $videos])

    <div class="video-slider-title paravi-padding-setup">
      <a href="{{ route('user.show', [$user, 'playlists']) }}"><h4>建立的播放清單<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
    </div>
    @include('video.single-playlist-slider', ['playlists' => $playlists])

    <!--<div class="explore-slider-title paravi-padding-setup">
        <h4>上傳的影片</h4>
    </div>
    <div class="row no-gutter load-more-container">
      <div class="video-sidebar-wrapper">
          <div id="sidebar-results"></div>
          <div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 25px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
      </div>
    </div>-->

	</div>
</div>

@endsection

@section('script')
  @parent
  <script src="{{ mix('js/loadMore.js') }}"></script>
@endsection