@extends('layouts.app')

@section('nav')
  @include('layouts.nav-main', ['theme' => 'white', 'logoImage' => 'https://i.imgur.com/M8tqx5K.png'])
@endsection

@section('content')

<div style="background-color: #FEFEFE;">
  <div style="margin: 30px auto 25px auto;">
    <div class="video-slider-title paravi-padding-setup">
      <a href="{{ route('video.varietyList') }}"><h4>LaughSeeJapan綜藝頻道<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
    </div>
    @include('video.single-watch-slider')
  </div>
  
  <div class="video-slider-title paravi-padding-setup">
    <a href="{{ route('video.rank') }}"><h4>最夯發燒影片<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
  </div>
  @include('video.single-video-slider', ['videos' => $trendings])

  <div class="video-slider-title paravi-padding-setup">
    <a href="{{ route('video.newest') }}"><h4>最新精彩內容<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
  </div>
  @include('video.single-video-slider', ['videos' => $newest])

  <div class="video-slider-title paravi-padding-setup">
    <a href="{{ route('video.subscribeTag') }}?query=明星"><h4>#明星嘉賓<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
  </div>
  @include('video.single-video-slider', ['videos' => $artist])

  <div class="video-slider-title paravi-padding-setup">
    <a href="{{ route('video.subscribeTag') }}?query=整人"><h4>#整人企劃<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
  </div>
  @include('video.single-video-slider', ['videos' => $trick])

  <div class="video-slider-title paravi-padding-setup">
    <a href="{{ route('video.subscribeTag') }}?query=真人秀"><h4>#真人秀<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
  </div>
  @include('video.single-video-slider', ['videos' => $reality])

  <div class="video-slider-title paravi-padding-setup">
    <a href="{{ route('video.rank') }}"><h4>更多發燒影片<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
  </div>
  <div class="row no-gutter load-more-container">
    <div class="video-sidebar-wrapper">
        <div id="sidebar-results"><!-- results appear here --></div>
        <div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 25px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
    </div>
  </div>
</div>

@endsection

@section('script')
  @parent
  <script src="{{ mix('js/loadMore.js') }}"></script>
@endsection