@extends('layouts.app')

@section('head')
    @parent
    @include('video.videoHead')
@endsection

@section('nav')
  @include('nav.main')
@endsection

@section('content')
<div id="content-div">

  @include('video.playModal')
  @include('video.userReportModal')
  @include('video.shareModal')

  <div class="hidden-xs" style="position: relative;">
    <img class="lazy" style="background-color: black; width: 100%; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0.3)));" src="https://i.imgur.com/CJ5svNv.png" data-src="{{ $video->imgur() }}" data-srcset="{{ $video->imgur() }}" alt="{{ $video->title }}">
    <div id="home-banner-wrapper" style="position: absolute; left: 4%; color: white">
      <h3 class="hidden-sm hidden-md" style="font-weight: bold"><span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me</h3>
      <h1 style="margin: 0; line-height: 45px; margin-bottom: -5px; font-weight: bold;">{{ $video->title }}</h1>
      <h4 class="hidden-xs">{{ $video->translations['JP'] }} • 中文字幕 • {{ $video->caption }}</h4>

      <div style="margin-top: -20px; margin-bottom: 28px; white-space: initial;">
        <a style="color: white; border: 1px solid white; padding: 5px 7px;" href="/"><span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me</a>
        @foreach ($tags as $tag)
          <div style="margin-bottom: 12px; display: inline-block;">
            <a style="color: white; border: 1px solid white; padding: 5px 7px;" href="/search?tags%5B%5D={{ $tag }}">{{ $tag }}</a>
          </div>
        @endforeach
      </div>

      <div style="margin-top: -10px; margin-bottom: -11px">
        <div style="display: inline-block; padding: 10px 30px 7px 20px;" data-toggle="modal" data-target="#playModal" class="hover-opacity-all home-banner-btn home-banner-play-btn play-btn"><span style="vertical-align: middle; font-size: 2em; margin-top: -4px; padding-right: 5px;" class="material-icons">play_arrow</span>播放</div>

        &nbsp;

        <div id="info-btn-wrapper" style="display: inline-block;">
          @if (!Auth::check())
            <div data-toggle="modal" data-target="#signUpModal" style="text-decoration: none; color: inherit; display: inline-block;">
              <button id="info-desktop-like-btn" class="no-button-style" type="submit"><i style="margin-top: -5px; margin-left: 0px;" class="material-icons-outlined">thumb_up</i></button>
            </div>
          @else
            <form style="display: inline-block;" class="video-like-form" action="{{ route('video.like') }}" method="POST">
              {{ csrf_field() }}
              <input name="like-user-id" type="hidden" value="{{ Auth::user()->id }}">
              <input name="like-foreign-type" type="hidden" value="video">
              <input name="like-foreign-id" type="hidden" value="{{ $video->id }}">
              <input name="like-is-positive" type="hidden" value="{{ true }}">
              @include('video.info-desktop-like-btn')
            </form>
          @endif

          <button class="no-button-style" id="comment-icon"><i style="margin-top: 6px; margin-left: 1px; font-size: 1.9em" class="material-icons">chat</i></button>

          <button class="no-button-style" data-toggle="modal" data-target="#shareModal"><i style="-moz-transform: scale(-1, 1);-webkit-transform: scale(-1, 1);-o-transform: scale(-1, 1);-ms-transform: scale(-1, 1);transform: scale(-1, 1); margin-right: 3px; margin-top: 2px; margin-left: 3px; font-size: 2.3em" class="material-icons">reply</i></button>

          @if (!Auth::check())
            <div data-toggle="modal" data-target="#signUpModal" style="text-decoration: none; color: inherit; display: inline-block;" class="single-icon-wrapper">
              <button id="info-desktop-save-btn" class="no-button-style" type="submit"><i style="margin-top: -1px; margin-left: 0px; font-size: 2.3em" class="material-icons" title="加入我的清單">add</i></button>
            </div>
          @else
            <form style="display: inline-block;" class="video-save-form" action="{{ route('video.save') }}" method="POST">
              {{ csrf_field() }}
              <input name="save-user-id" type="hidden" value="{{ Auth::user()->id }}">
              <input name="save-video-id" type="hidden" value="{{ $video->id }}">
              @include('video.info-desktop-save-btn')
            </form>
          @endif

          <button class="no-button-style" data-toggle="modal" data-target="#reportModal"><i style="margin-top: 5px; margin-left: 1px; font-size: 2em" class="material-icons">flag</i></button>

        </div>

      </div>
    </div>
  </div>

  <div class="hidden-sm hidden-md hidden-lg" style="position: relative; text-align: center;">
    <img style="width: 40%; margin-top: 70px; box-shadow: 3px 3px 10px black;" src="{{ $video->cover }}">
    <div style="text-align: center; color: white; margin-top: 15px;">
      <h1 id="shareBtn-title" style="font-size: 22px; font-weight: bold; margin: 0; padding: 0 4%; line-height: 30px">{{ $video->translations['JP'] }}</h1>
      <div style="width: 92%; margin-top: 18px;">
        <div data-toggle="modal" data-target="#playModal" style="cursor: pointer; font-size: 14px; border-radius: 3px; text-decoration: none; background-color: red; color: black; color: white; margin-left: 4%; padding: 5px 0" class="btn-block play-btn"><span style="vertical-align: middle; font-size: 2em; margin-top: -3px; padding-right: 3px; color: white;" class="material-icons">play_arrow</span>播放</div>
      </div>
      <h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; line-height: 16px; font-size: 12px; width: 92%; margin-left: 4%; text-align: left; margin-bottom: -2px;">{{ $video->title }} • 中文字幕 • {{ $video->caption }}</h4>

      <h5 style="text-align: left; padding: 0 4%; color: darkgray; font-size: 11px; line-height: 16px;">
        標籤: 
        @foreach ($tags as $tag)
            <a style="color: darkgray;" href="/search?tags%5B%5D={{ $tag }}">{{ $tag }}</a>{{ $loop->last ? '' : ', ' }}
        @endforeach
      </h5>
      
      <div class="show-panel-icons" style="margin:0; margin-top: 15px;">
        <div id="video-like-form-wrapper" class="hover-opacity-all">
          @if (!Auth::check())
            <div data-toggle="modal" data-target="#signUpModal" style="text-decoration: none; color: inherit" class="single-icon-wrapper">
              <div class="single-icon no-select">
                <i class="material-icons-outlined">thumb_up</i>
                <div>{{ App\Like::count('video', $video->id, true) }}</div>
              </div>
            </div>
          @else
            <form class="video-like-form" action="{{ route('video.like') }}" method="POST">
              {{ csrf_field() }}
              <input name="like-user-id" type="hidden" value="{{ Auth::user()->id }}">
              <input name="like-foreign-type" type="hidden" value="video">
              <input name="like-foreign-id" type="hidden" value="{{ $video->id }}">
              <input name="like-is-positive" type="hidden" value="{{ true }}">
              @include('video.info-mobile-like-btn')
            </form>
          @endif
        </div>

        <div id="comment-icon" class="single-icon-wrapper">
          <div class="single-icon no-select hover-opacity-all" style="position: relative;">
            <i class="material-icons">chat</i>
            <div>評論</div>
          </div>
        </div>

        <div id="shareBtn" class="single-icon-wrapper" data-toggle="modal" data-target="#shareModal">
          <div class="single-icon no-select hover-opacity-all">
            <i class="material-icons noselect" style="-moz-transform: scale(-1, 1);-webkit-transform: scale(-1, 1);-o-transform: scale(-1, 1);-ms-transform: scale(-1, 1);transform: scale(-1, 1); font-size: 2.2em; margin-top: -4px;">reply</i>
            <div style="margin-top: -5px;">分享</div>
          </div>
        </div>
        <div id="video-save-form-wrapper" class="hover-opacity-all">
          @if (!Auth::check())
            <div data-toggle="modal" data-target="#signUpModal" style="text-decoration: none; color: inherit" class="single-icon-wrapper">
              <div class="single-icon no-select">
                <i class="material-icons">add</i>
                <div>儲存</div>
              </div>
            </div>
          @else
            <form class="video-save-form" action="{{ route('video.save') }}" method="POST">
              {{ csrf_field() }}
              <input name="save-user-id" type="hidden" value="{{ Auth::user()->id }}">
              <input name="save-video-id" type="hidden" value="{{ $video->id }}">
              @include('video.info-mobile-save-btn')
            </form>
          @endif
        </div>

        <div class="single-icon-wrapper" data-toggle="modal" data-target="#reportModal">
          <div class="single-icon no-select hover-opacity-all">
            <i class="material-icons noselect">flag</i>
            <div>報告</div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <img class="hidden-sm hidden-md hidden-lg" style="width: 100%; position: absolute; top: 0; left: 0; z-index: -1; filter: blur(10px) brightness(70%); -webkit-filter: blur(10px) brightness(70%); -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0))); padding-bottom: 30px" src="{{ $video->cover }}">

  <div id="home-rows-wrapper" class="intro-rows-wrapper" style="position: relative;">
    <h3>集數列表</h3>
    <div class="home-rows-videos-wrapper no-scrollbar-style">
      @foreach ($videos as $video)
        <a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video->id }}">
          <div id="home-rows-videos-div" style="position: relative; display: inline-block;">
            <img src="{{ $video->cover }}">
            <div id="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 3px 3px; background: linear-gradient(to bottom, transparent 0%, black 120%);">{{ $video->title }}</div>
            </div>
        </a>
      @endforeach
    </div>

    <h3>相關推薦</h3>
    <div class="home-rows-videos-wrapper" style="white-space: normal;">
      @foreach ($recommends as $video)
        <a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video->id }}">
          <div id="home-rows-videos-div" style="position: relative; display: inline-block; margin-bottom:50px">
            <img src="{{ $video->cover }}">
            <div id="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 3px 3px; background: linear-gradient(to bottom, transparent 0%, black 120%);">{{ $video->title }}</div>
            </div>
        </a>
      @endforeach
    </div>
  </div>
</div>

@include('layouts.nav-bottom')
@if (!Auth::check())
  @include('user.signUpModal')
  @include('user.loginModal')
@endif

@endsection