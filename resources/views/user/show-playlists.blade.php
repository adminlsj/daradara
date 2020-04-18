@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')

<div class="hidden-sm hidden-xs sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>
<div class="main-content">
	<div style="background-color: #F5F5F5; min-height: calc(100vh - 50px);">

		<div class="paravi-padding-setup" style="padding-top: 20px; padding-bottom: 20px; background-color: #F9F9F9">
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
        <a href="{{ route('user.show', [$user, 'featured']) }}" class="user-show-tablinks">首頁</a>
        <a href="{{ route('user.show', [$user, 'playlists']) }}" class="user-show-tablinks active">播放清單</a>
        <a href="{{ route('user.show', [$user, 'about']) }}" class="user-show-tablinks">簡介</a>
      </div>
		</div>

    <div class="explore-slider-title paravi-padding-setup">
        <h4>已建立的播放清單</h4>
    </div>
    @if ($watches->count() != 0)
      <div class="row no-gutter load-more-container">
        @foreach ($watches as $watch)
          <div class="col-xs-6 col-sm-3 col-md-3 hover-opacity-all load-more-wrapper" style="position: relative;">
              <a style="text-decoration: none; color: black" href="{{ route('video.playlist') }}?list={{ $watch->id }}">
                <img style="width: 100%; height: 100%;" src="{{ $watch->videos()->first() ? $watch->videos()->first()->imgurH() : 'https://i.imgur.com/JMcgEkPl.jpg' }}" alt="{{ $watch->title }}">
                <span>
                  <div style="margin: 0;position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                    <div>{{ $watch->videos()->count() }}</div>
                    <i style="font-size: 1.6em; margin-right: -2px" class="material-icons">playlist_play</i>
                  </div>
                </span>

                <div class="hover-underline">
                  <h4 style="padding-right: 10px" class="text-ellipsis">{{ $watch->title }}</h4>
                </div>
              </a>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</div>

@endsection