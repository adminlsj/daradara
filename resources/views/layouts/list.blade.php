@extends('layouts.app')

@section('nav')
  @include('nav.main')
@endsection

@section('content')

<div id="content-div">
  <div id="home-rows-wrapper" class="list-rows-wrapper" style="position: relative;">
    <h3>我的播放清單</h3>
    <div class="home-rows-videos-wrapper" style="white-space: normal;">
      @foreach ($videos as $video)
        <a style="text-decoration: none;" href="{{ route('video.info') }}?v={{ $video->id }}">
          <div id="home-rows-videos-div" style="position: relative; display: inline-block; margin-bottom:50px">
            <img src="{{ $video->cover }}">
            <div id="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 3px 3px; background: linear-gradient(to bottom, transparent 0%, black 120%);">{{ explode('/', $video->title)[0] }}</div>
            </div>
        </a>
      @endforeach
    </div>
    <div style="padding: 0 4%;">
      <form action="{{ route('logout') }}" method="POST">
        {{ csrf_field() }}
        <br class="hidden-sm hidden-md hidden-lg">
        <button style="height: 40px; width: 80px; background-color: dimgray !important; border-color: dimgray !important;" class="no-button-style btn-info" type="submit">登出</button>
        <br class="hidden-sm hidden-md hidden-lg">
        <br class="hidden-sm hidden-md hidden-lg">
        <br class="hidden-sm hidden-md hidden-lg">
      </form>
    </div>
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