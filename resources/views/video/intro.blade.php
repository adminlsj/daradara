@extends('layouts.app')

@section('head')
    @parent
    <title>{{ $watch->title }}&nbsp;-&nbsp;播放清單&nbsp;-&nbsp;Hanime1</title>
    <meta name="title" content="{{ $watch->title }} 線上看 - 播放清單 - 娛見日本 LaughSeeJapan">
    <meta name="description" content="{{ $watch->title }} 線上看 - {{ $watch->description }}">

    @if ($first != null)
      <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "ImageObject",
        "name": "{{ $watch->title }}",
        "description": "{{ $watch->title }} 線上看 - {{ $watch->description }}",
        "contentUrl": "https://i.imgur.com/{{ $first->imgur }}l.png",
        "uploadDate": "{{ \Carbon\Carbon::parse($watch->updated_at)->format('Y-m-d\Th:i:s').'+00:00' }}"
      }
      </script>
    @endif
@endsection

@section('nav')
  @include('nav.main')
@endsection

@section('content')
<div id="content-div">

  <div class="hidden-xs" style="position: relative;">
    <img style="width: 100%; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0.3)));" src="{{ $watch->videos()->orderBy('created_at', 'desc')->first()->imgur() }}">
    <div id="home-banner-wrapper" style="position: absolute; left: 4%; color: white">
      <h3 style="font-weight: bold"><span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me</h3>
      <h1 style="margin: 0">{{ explode('/', $watch->title)[0] }}</h1>
      <h4 class="hidden-xs">{{ $watch->description }}</h4>
      <div>
        <a class="hover-opacity-all home-banner-btn home-banner-play-btn"><span style="vertical-align: middle; font-size: 2em; margin-top: -3px; padding-right: 5px" class="material-icons">play_arrow</span>播放</a>
        &nbsp;
        <a href="{{ route('video.playlist') }}?list={{ $watch->id }}" class="hover-opacity-all home-banner-btn home-banner-info-btn"><span style="vertical-align: middle; font-size: 1.7em; margin-top: -2px; padding-right: 7px" class="material-icons">info</span>更多資訊</a>
      </div>
    </div>
  </div>

  <div class="hidden-sm hidden-md hidden-lg" style="position: relative; text-align: center">
    <img style="width: 50%; margin-top: 60px; box-shadow: 3px 3px 10px black;" src="{{ $watch->videos()->orderBy('created_at', 'desc')->first()->cover }}">
    <div style="text-align: center; color: white; margin-top: 15px;">
      <h1 style="font-size: 30px; font-weight: bold; margin: 0">{{ explode('/', $watch->title)[0] }}</h1>
      <h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; line-height: 16px; font-size: 12px; width: 80%; margin-left: 10%;">{{ $watch->description }}</h4>
      <div style="margin-top: 20px; width: 100%">
        <div style="width: 33%; float:left; display: inline-block;">
          <span class="material-icons">add</span>
          <div style="font-size: 12px; margin-top: -1px">播放清單</div>
        </div>
        <div style="width: 33%; float:left; display: inline-block; margin-top: 10px;">
          <a class="hover-opacity-all home-banner-btn home-banner-play-btn" style="cursor: pointer; font-size: 14px; border-radius: 3px; text-decoration: none; background-color: white; padding: 7px 22px 7px 12px; color: black;"><span style="vertical-align: middle; font-size: 2em; margin-top: -3px; padding-right: 3px" class="material-icons">play_arrow</span>播放</a>
        </div>
        <div style="width: 33%; float:left; display: inline-block;">
          <span class="material-icons">info</span>
          <div style="font-size: 12px; margin-top: 0px">更多資訊</div>
        </div>
      </div>
    </div>
  </div>

  <img style="width: 100%; position: absolute; top: 0; left: 0; z-index: -1; filter: blur(10px); -webkit-filter: blur(10px); -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0)));" src="{{ $watch->videos()->orderBy('created_at', 'desc')->first()->cover }}">

  <div id="home-rows-wrapper" style="position: relative; margin-top: 100px">
    @foreach ($rows as $title => $videos)
      <h3>{{ $title }}</h3>
      <div class="home-rows-videos-wrapper" style="white-space: normal;">
        @foreach ($videos as $video)
          <a style="text-decoration: none;" href="{{ route('video.playlist') }}?list={{ $video->playlist_id }}">
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