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
  <div style="background-color: #F5F5F5; padding-top: 10px; {{ Request::is('drama') || Request::is('anime') ? 'margin-top: 27px;' : '' }}">
    <div style="padding-top: 10px"></div>

    <link rel="stylesheet" href="https://unpkg.com/swiper/css/swiper.min.css">
    <script src="https://unpkg.com/swiper/js/swiper.min.js"></script>

    <div style="padding: 0px 20px; padding-bottom: 10px">
      <h4>LaughSeeJapan熱門頻道</h4>
    </div>
    <div class="swiper-container">
      <div class="swiper-wrapper">
        @foreach ($selected as $watch)
          <div class="swiper-slide" style="border-radius: 10px; box-shadow: 1px 4px 6px rgba(0,0,0,0.1); width: 150px !important; background: #fff;">
            <a style="text-decoration: none; color: black" href="{{ route('video.intro', [$watch->genre, $watch->titleToUrl()]) }}">
              <img class="lazy" style="width: 100%; height: 100%; border-top-left-radius: 10px; border-top-right-radius: 10px;" src="{{ $watch->imgurDefault() }}" data-src="{{ $watch->imgurL() }}" data-srcset="{{ $watch->imgurL() }}" alt="{{ $watch->title }}">

              <div style="height: 47px; padding: 2px 15px;">
                <h4 style="line-height: 19px; font-size: 1em;overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; font-weight: 450;">{{ $watch->title }}</h4>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    </div>

    <div style="margin-top: 25px; padding: 0px 20px; padding-bottom: 10px">
      <h4>最新精彩內容</h4>
    </div>
    <div class="swiper-container">
      <div class="swiper-wrapper">
        @foreach ($newest as $video)
          @include('video.single-video-slider')
        @endforeach
      </div>
    </div>
    <div style="padding: 0px 20px; margin-top: -4px; text-align: center;" class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
      <a style="text-decoration: none; color: black; font-size: 1em;" href="{{ route('video.newest') }}?g=variety">
        <div style="border: 1px solid black; padding: 8px; border-radius: 7px; font-weight: 500">顯示更多</div>
      </a>
    </div>

    <div style="margin-top: 65px; padding: 0px 20px; padding-bottom: 10px">
      <h4>#明星嘉賓</h4>
    </div>
    <div class="swiper-container">
      <div class="swiper-wrapper">
        @foreach ($artist as $video)
          @include('video.single-video-slider')
        @endforeach
      </div>
    </div>
    <div style="padding: 0px 20px; margin-top: -4px; text-align: center;" class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
      <a style="text-decoration: none; color: black; font-size: 1em;" href="{{ route('video.search') }}?query=明星">
        <div style="border: 1px solid black; padding: 8px; border-radius: 7px; font-weight: 500">顯示更多</div>
      </a>
    </div>

    <div style="margin-top: 65px; padding: 0px 20px; padding-bottom: 10px">
      <h4>#整人企劃</h4>
    </div>
    <div class="swiper-container">
      <div class="swiper-wrapper">
        @foreach ($trick as $video)
          @include('video.single-video-slider')
        @endforeach
      </div>
    </div>
    <div style="padding: 0px 20px; margin-top: -4px; text-align: center;" class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
      <a style="text-decoration: none; color: black; font-size: 1em;" href="{{ route('video.search') }}?query=整人">
        <div style="border: 1px solid black; padding: 8px; border-radius: 7px; font-weight: 500">顯示更多</div>
      </a>
    </div>

    <!-- Initialize Swiper -->
    <script>
      var swiper = new Swiper('.swiper-container', {
        slidesPerView: 'auto',
        freeMode: true,
        spaceBetween: 10,
      });
    </script>

    <br><br><br>
  </div>
</div>
@endsection