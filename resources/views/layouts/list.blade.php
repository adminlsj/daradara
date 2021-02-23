@extends('layouts.app')

@section('nav')
  @include('nav.main')
@endsection

@section('content')

<div class="nav-bottom-padding">
  <div id="home-rows-wrapper" class="list-rows-wrapper" style="position: relative;">
    <h3>我的播放清單</h3>
    <div class="home-rows-videos-wrapper" style="white-space: normal;">
      @foreach ($saves as $save)
        <a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $save->video->id }}">
          <div class="home-rows-videos-div" style="position: relative; display: inline-block; margin-bottom:50px">
            <img src="{{ $save->video->cover }}">
            <div class="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 3px 3px; background: linear-gradient(to bottom, transparent 0%, black 120%);">{{ $save->video->title }}</div>
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
</div>

@include('layouts.nav-bottom')

@endsection