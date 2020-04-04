@extends('layouts.app')

@section('nav')
  @include('layouts.nav-main', ['theme' => 'white', 'logoImage' => 'https://i.imgur.com/M8tqx5K.png'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
  @include('video.sidebarMenu', ['theme' => 'white'])
</div>

<div class="main-content">
  @include('layouts.nav-index')
  <div style="background-color: #F5F5F5; padding-top: 20px; {{ Request::is('drama') || Request::is('anime') ? 'margin-top: 27px;' : '' }}">
    <div style="padding: 0px 20px; padding-bottom: 8px">
      <h4>LaughSeeJapan熱門頻道<a href="{{ route('video.varietyList') }}" style="float: right; text-decoration: none; color: black" class="hidden-md hidden-lg"><i style="vertical-align:middle; font-size: 1em; margin-top: -3.5px;" class="material-icons">arrow_forward_ios</i></a></h4>
    </div>
    @include('video.single-watch-slider')
    

    <div style="margin-top: 25px; padding: 0px 20px; padding-bottom: 9px">
      <h4>最夯發燒影片</h4>
    </div>
    @include('video.single-video-slider', ['videos' => $trendings])
    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 show-more-btn">
      <a href="{{ route('video.rank') }}">
        <div>顯示更多</div>
      </a>
    </div>

    <div style="margin-top: 70px; padding: 0px 20px; padding-bottom: 9px">
      <h4>最新精彩內容</h4>
    </div>
    @include('video.single-video-slider', ['videos' => $newest])
    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 show-more-btn">
      <a href="{{ route('video.newest') }}">
        <div>顯示更多</div>
      </a>
    </div>

    <div style="margin-top: 70px; padding: 0px 20px; padding-bottom: 9px">
      <h4>#明星嘉賓</h4>
    </div>
    @include('video.single-video-slider', ['videos' => $artist])
    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 show-more-btn">
      <a href="{{ route('video.search') }}?query=明星">
        <div>顯示更多</div>
      </a>
    </div>

    <div style="margin-top: 70px; padding: 0px 20px; padding-bottom: 9px">
      <h4>#整人企劃</h4>
    </div>
    @include('video.single-video-slider', ['videos' => $trick])
    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 show-more-btn">
      <a href="{{ route('video.search') }}?query=整人">
        <div>顯示更多</div>
      </a>
    </div>

    <div style="margin-top: 70px; padding: 0px 20px; padding-bottom: 9px">
      <h4>更多發燒影片</h4>
    </div>
    <div class="row no-gutter" style="padding: 0px 15px">
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