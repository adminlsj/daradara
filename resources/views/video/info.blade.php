@extends('layouts.app')

@section('nav')
  @include('nav.main')
@endsection

@section('content')
<div id="content-div">

  <div class="hidden-xs" style="position: relative;">
    <img style="width: 100%; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0.3)));" src="{{ $video->imgur() }}">
    <div id="home-banner-wrapper" style="position: absolute; left: 4%; color: white">
      <h3 style="font-weight: bold"><span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me</h3>
      <h1 style="margin: 0">{{ explode('/', $video->title)[0] }}</h1>
      <h4 class="hidden-xs">{{ $video->caption }}</h4>
      <div style="margin-top: -10px; margin-bottom: -11px">
        <a href="{{ route('video.watch') }}?v={{ $video->id }}" target="_blank" class="hover-opacity-all home-banner-btn home-banner-play-btn"><span style="vertical-align: middle; font-size: 2em; margin-top: -3px; padding-right: 5px;" class="material-icons">play_arrow</span>播放</a>

        &nbsp;

        <div id="info-btn-wrapper" style="display: inline-block;">

          <div><i style="margin-top: 10px; margin-left: 11px;" class="material-icons">thumb_up</i></div>

          <div id="comment-icon"><i style="margin-top: 11px; margin-left: 11px; font-size: 1.9em" class="material-icons">chat</i></div>

          <div><i style="-moz-transform: scale(-1, 1);-webkit-transform: scale(-1, 1);-o-transform: scale(-1, 1);-ms-transform: scale(-1, 1);transform: scale(-1, 1); margin-right: 3px; margin-top: 6px; margin-left: 8px; font-size: 2.3em" class="material-icons">reply</i></div>

          <div><i style="margin-right: 3px; margin-top: 8px; margin-left: 9px; font-size: 2.2em" class="material-icons">add</i></div>

          <div><i style="margin-right: 3px; margin-top: 9px; margin-left: 11px; font-size: 2em" class="material-icons">flag</i></div>

        </div>

      </div>
    </div>
  </div>

  <div class="hidden-sm hidden-md hidden-lg" style="position: relative; text-align: center;">
    <img style="width: 40%; margin-top: 70px; box-shadow: 3px 3px 10px black;" src="{{ $video->cover }}">
    <div style="text-align: center; color: white; margin-top: 20px;">
      <h1 style="font-size: 22px; font-weight: bold; margin: 0">{{ explode('/', $video->title)[0] }}</h1>
      <div style="width: 92%; margin-top: 18px;">
        <a href="{{ route('video.watch') }}?v={{ $video->id }}" target="_blank" style="cursor: pointer; font-size: 14px; border-radius: 3px; text-decoration: none; background-color: red; color: black; color: white; margin-left: 4%; padding: 5px 0" class="btn-block"><span style="vertical-align: middle; font-size: 2em; margin-top: -3px; padding-right: 3px; color: white;" class="material-icons">play_arrow</span>播放</a>
      </div>
      <h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; line-height: 16px; font-size: 12px; width: 92%; margin-left: 4%;">{{ $video->caption }}</h4>
      
      <div class="show-panel-icons" style="margin:0; margin-top: 15px;">
        <div id="video-like-form-wrapper" class="hover-opacity-all">
          @include('video.like-btn-wrapper')
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
          @include('video.save-btn-wrapper')
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

  <img class="hidden-sm hidden-md hidden-lg" style="width: 100%; position: absolute; top: 0; left: 0; z-index: -1; filter: blur(10px) brightness(65%); -webkit-filter: blur(10px) brightness(65%);" src="{{ $video->cover }}">

  <div id="home-rows-wrapper" class="intro-rows-wrapper" style="position: relative;">
    @foreach ($rows as $title => $videos)
      <h3>{{ $title }}</h3>
      <div class="home-rows-videos-wrapper" style="white-space: normal;">
        @foreach ($videos as $video)
          <a style="text-decoration: none;" href="{{ route('video.info') }}?v={{ $video->id }}">
            <div id="home-rows-videos-div" style="position: relative; display: inline-block; {{ $loop->parent->iteration > 1 ? 'margin-bottom:50px' : '' }}">
              <img src="{{ $video->cover }}">
              <div id="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 3px 3px; background: linear-gradient(to bottom, transparent 0%, black 120%);">{{ explode('/', $video->title)[0] }}</div>
              </div>
          </a>
        @endforeach
      </div>
    @endforeach
  </div>

  <div class="hidden-xs" style="position: relative; padding: 0 4%; margin-top: 50px">
    <div style="margin-left: -15px; display: inline-block;">
      <a class="hidden-xs" href="/contact" style="padding: 0px 15px; color: dimgray">廣告</a>
      <a class="hidden-xs" href="/about" style="padding: 0px 15px; color: dimgray">Hanime1</a>
      <a href="/about" style="padding: 0px 15px; color: dimgray">關於</a>
      <a href="/contact" style="padding: 0px 15px; color: dimgray">聯絡</a>
    </div>

    <div style="float: right; margin-right: -15px; display: inline-block;">
      <a href="/terms" style="padding: 0px 15px; color: dimgray"><span class="hidden-xs">服務</span>條款</a>
      <a href="/policies" style="padding: 0px 15px; color: dimgray">社群<span class="hidden-xs">規範</span></a>
      <a href="/copyright" style="padding: 0px 15px; color: dimgray">版權<span class="hidden-xs">申訴</span></a>
    </div>

    <div style="margin-top: 10px; margin-bottom: 10px">
      <div style="display: inline-block; color: dimgray"><span class="hidden-xs">本網站已依台灣網站內容分級規定處理，</span>未滿十八歲者不得瀏覽</div>
      <img style="display: inline-block; margin-top: -2px; margin-left: 5px" height='13' src="https://i.imgur.com/aJ6decG.gif">
    </div>
  </div>

</div>

@include('layouts.nav-bottom')

@endsection