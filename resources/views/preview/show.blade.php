@extends('layouts.app')

@section('head')
    @parent
    <meta property="og:url" content="/previews/{{ $previews->first()->uuid }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $year }}年{{ $month }}月里番/裏番新番列表 - Hanime1.me" />
    <meta property="og:description" content="{{ $year }}年{{ $month }}月H動漫成人卡通新番表，開播日期、內容介紹、製作公司一口氣公開！本列表目前共收錄了{{ $previews->count() }}套新作工口H動畫。" />
    <meta property="og:image" content="{{ $previews->first()->cover }}" />

    <title>{{ $year }}年{{ $month }}月里番/裏番新番列表&nbsp;-&nbsp;Hanime1.me</title>
    <meta name="title" content="{{ $year }}年{{ $month }}月里番/裏番新番列表 - Hanime1.me">
    <meta name="description" content="{{ $year }}年{{ $month }}月H動漫成人卡通新番表，開播日期、內容介紹、製作公司一口氣公開！本列表目前共收錄了{{ $previews->count() }}套新作工口H動畫。" />
    <meta property="og:image" content="{{ $previews->first()->cover }}">
@endsection

@section('nav')
  @include('nav.main')
@endsection

@section('content')
<div id="content-div" style="overflow-x: hidden; overflow-y: hidden;">
  <div class="row no-gutter video-show-width">
    <div id="player-div-wrapper" class="col-md-9 single-show-player fluid-player-desktop-styles">
      <img style="width: 100%" src="{{ $previews->first()->cover }}">
      <div class="hidden-md hidden-lg" style="margin-bottom: 40px;">
        @if ($prev)
          <div style="float: left; margin: 10px 0px 10px 15px;">
            <a style="text-decoration: none; color: #d9d9d9; font-weight: normal" href="/previews/{{ $prev->uuid }}">
              <span style="font-size: 12px; vertical-align: middle; margin-top: -2px; margin-right: -5px;" class="material-icons">arrow_back_ios</span>
              {{ substr($prev->uuid, 0, 4) }}年{{ ltrim(substr($prev->uuid, 4, 6), '0') }}月新番表
            </a>
          </div>
        @endif
        @if ($next)
          <div style="float: right; margin: 10px 15px 10px 0px;">
            <a style="text-decoration: none; color: #d9d9d9; font-weight: normal" href="/previews/{{ $next->uuid }}">
              {{ substr($next->uuid, 0, 4) }}年{{ ltrim(substr($next->uuid, 4, 6), '0') }}月新番表
              <span style="font-size: 12px; vertical-align: middle; margin-top: -2px; margin-left: -3px;" class="material-icons">arrow_forward_ios</span>
            </a>
          </div>
        @endif
      </div>
      <div class="preview-top-content">
        <h1 style="color: white; font-weight: bold">{{ $year }}年{{ $month }}月里番/裏番新番列表</h1>
        <p style="color: #d9d9d9; font-size: 18px; margin-bottom: 0px">{{ $year }}年{{ $month }}月H動漫成人卡通新番表，開播日期、內容介紹、製作公司一口氣公開！本列表目前共收錄了{{ $previews->count() }}套新作工口H動畫。</p>
      </div>
    </div>

    <div class="col-md-3 hidden-xs hidden-sm" style="width: 396px;">
      @if ($prev)
        <div style="margin-bottom: 15px; position: relative;">
          <a style="text-decoration: none;" href="/previews/{{ $prev->uuid }}">
            <img style="width: 100%" src="{{ $prev->cover }}">
            <div class="owl-home-rows-title" style="position: absolute; bottom:0; left:0; white-space: initial; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 10px; background: linear-gradient(to bottom, transparent 0%, black 120%); font-weight: bold; text-align: center; font-size: 24px">{{ substr($prev->uuid, 0, 4) }}年{{ ltrim(substr($prev->uuid, 4, 6), '0') }}月新番表</div>
          </a>
        </div>
      @endif

      @if ($next)
        <div>
          <a style="text-decoration: none;" href="/previews/{{ $next->uuid }}">
            <img style="width: 100%" src="{{ $next->cover }}">
            <div class="owl-home-rows-title" style="position: absolute; bottom:0; left:0; white-space: initial; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 10px; background: linear-gradient(to bottom, transparent 0%, black 120%); font-weight: bold; text-align: center; font-size: 24px">{{ substr($next->uuid, 0, 4) }}年{{ ltrim(substr($next->uuid, 4, 6), '0') }}月新番表</div>
          </a>
        </div>
      @endif
    </div>
  </div>

  <div class="content-padding home-rows-margin-top">
    <a class="home-rows-header" style="text-decoration: none;" href="/search?query=新番預告&genre=裏番">
      <h5 style="color: #8e9194; ">本月</h5>
      <h3 style="font-weight: 700; color: #edeeef; margin-bottom: 20px;">新番導覽</h3>
      @include('layouts.home-row-arrow')
    </a>
  </div>

  <div class="owl-home-row owl-carousel owl-theme">
    @foreach ($previews as $preview)
      <a class="cover-scroll-trigger" data-id="{{ $preview->video->id }}" style="text-decoration: none;">
        <div class="home-rows-videos-div" style="position: relative; display: inline-block;">
          <img src="{{ $preview->video->cover }}">
              <div class="owl-home-rows-title" style="position: absolute; bottom:0; left:0; white-space: initial; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 2px 3px; background: linear-gradient(to bottom, transparent 0%, black 120%); font-weight: bold">{{ str_replace('[新番預告]', '', $preview->video->title) }}</div>
          </div>
      </a>
    @endforeach
  </div>

  <div class="content-padding home-rows-margin-top">
    <a class="home-rows-header" style="text-decoration: none;" href="/search?query=新番預告&genre=裏番">
      <h5 style="color: #8e9194; ">介紹</h3>
      <h3 style="font-weight: 700; color: #edeeef; margin-bottom: 20px;">新番資訊</h3>
      @include('layouts.home-row-arrow')
    </a>
  </div>

  <div class="content-padding">
    @foreach ($previews as $preview)
      <div id="{{ $preview->video->id }}" class="row">
        <h4 class="hidden-sm hidden-md hidden-lg" style="margin: 0; background-color: #222222; color: white; padding: 10px 15px; font-weight: bold; line-height: 25px">{{ $preview->video->translations['JP'] }}</h4>
        <div class="col-md-12">
          <div class="preview-info-cover">
            <img style="width: 100%;" src="{{ $preview->video->cover }}">
            <div>{{ $month }}月{{ ltrim(Carbon\Carbon::parse($preview->created_at)->format('d'), '0') }}日</div>
          </div>
          <div class="preview-info-content">
            <h3 class="hidden-xs" style="margin: 0; background-color: #222222; color: white; padding: 10px 15px; font-weight: bold; line-height: 35px">{{ $preview->video->translations['JP'] }}</h3>
            <div class="preview-info-content-padding">

              @if ($preview->trailer)
                <div class="trailer-modal-trigger" style="margin-top: 15px;" data-toggle="modal" data-target="#trailerModal-{{ $preview->video->id }}">
                  <a id="watch-comics-link-btn" class="no-select" style="background-color: crimson; border: none; border-radius: 3px; color: #d9d9d9; display: block; text-decoration: none; cursor: pointer; margin-left: 0px; width: 115px">
                    <span style="vertical-align: middle; font-size: 20px; margin-top: -3px; margin-right: 3px; cursor: pointer;" class="material-icons-outlined">play_circle</span>預告映像
                  </a>
                </div>

                <div id="trailerModal-{{ $preview->video->id }}" class="modal preview-trailer-modal" role="dialog">
                  <div class="trailer-modal-wrapper">
                    <video style="width: 100%; height: 100%" id="player" controls crossorigin playsinline poster="{{ $preview->video->thumbH() }}">
                      <source src="{!! $preview->trailer !!}" type="video/mp4" size="720">
                    </video>
                  </div>
                </div>
              @endif

              <h4 style="color: white; margin-top: 15px; margin-bottom: 15px; font-weight: normal">{{ str_replace('[新番預告]', '', $preview->video->title) }}</h4>

              <h5 style="color: #bdbdbd; font-weight: normal;"><span class="hidden-xs">製作公司：</span><a style="color: #d9d9d9; text-decoration: underline;" href="{{ route('home.search') }}?genre=裏番&brands%5B%5D={{ $preview->video->artist }}">{{ $preview->video->artist }}</a></h5>

              <h5 style="color: #bdbdbd; margin-bottom: 15px; font-weight: normal;"><span class="hidden-xs">上市日期：</span>{{ Carbon\Carbon::parse($preview->created_at)->format('Y年m月d日') }} <span class="hidden-xs">{{ App\Preview::$weekMap[Carbon\Carbon::parse($preview->created_at)->dayOfWeek] }}</span><span class="hidden-sm hidden-md hidden-lg">上市</span></h5>

              <h5 class="caption hidden-xs" style="color: #bdbdbd; font-weight: 400; margin-top: 10px; line-height: 20px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">{{ $preview->video->caption }}</h5>
              <h5 class="show-more-caption no-select hidden-xs" style="margin-bottom: 25px; color: #fff; font-weight: 400; font-size: 12px; cursor: pointer;">顯示完整資訊</h5>

              <h5 class="hidden-xs" style="font-weight: 400; margin-bottom: 4px; margin-top: 0px;">
                @foreach (array_diff(array_keys($preview->video->tags_array), [$preview->video->artist, '新番預告']) as $tag)
                  <div class="single-video-tag"><a href="/search?tags%5B%5D={{ $tag }}&genre=裏番">{{ $tag }}</a></div>
                @endforeach
              </h5>

              <div class="hidden-xs">
                @foreach ($preview->images as $image)
                  <img style="object-fit: cover; width:120px; height:90px; margin-right: 4px; margin-bottom: 8px; cursor: pointer;" class="preview-image-modal-trigger" src="{{ $image }}" data-toggle="modal" data-target="#imagesModal-{{ $preview->video->id }}" data-image="#image-{{ $preview->video->id }}-{{ $loop->iteration }}">
                @endforeach
              </div>

              <div id="imagesModal-{{ $preview->video->id }}" class="modal preview-images-modal" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
                      <h4 class="modal-title">{{ str_replace('[新番預告]', '', $preview->video->title) }}</h4>
                    </div>
                    <div class="modal-body" style="padding: 0px">
                      @foreach ($preview->images as $image)
                        <img id="image-{{ $preview->video->id }}-{{ $loop->iteration }}" style="width: 100%; {{ $loop->last ? '' : 'margin-bottom: 15px' }}" src="{{ $image }}">
                      @endforeach
                    </div>
                    <hr style="border-color: #333333; margin: 0; margin-top: 0px;">
                    <div class="modal-footer" style="border-top: none; width: 100%; text-align: center; padding: 0;">
                      <div data-dismiss="modal">返回</div>
                      <button data-dismiss="modal" class="pull-right btn btn-primary">完成預覽圖片</button>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

      <div class="hidden-sm hidden-md hidden-lg">
        <h5 class="caption" style="color: #bdbdbd; font-weight: 400; margin-top: 10px; line-height: 20px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">{{ $preview->video->caption }}</h5>
        <h5 class="show-more-caption no-select" style="margin-bottom: 25px; color: #fff; font-weight: 400; font-size: 12px; cursor: pointer;">顯示完整資訊</h5>
        <h5 style="font-weight: 400; margin-bottom: 4px; margin-top: 0px;">
          @foreach (array_diff(array_keys($preview->video->tags_array), [$preview->video->artist, '新番預告']) as $tag)
            <div class="single-video-tag"><a href="/search?tags%5B%5D={{ $tag }}&genre=裏番">{{ $tag }}</a></div>
          @endforeach
        </h5>
        <div style="overflow-x: scroll !important; white-space: nowrap; margin-left: -15px; margin-right: -15px; padding-left: 15px;" class="hide-scrollbar">
          @foreach ($preview->images as $image)
            <img style="object-fit: cover; width:110px; height:80px; margin-right: {{ $loop->last ? '15px' : '4px' }}; margin-bottom: 8px; cursor: pointer;" class="preview-image-modal-trigger" src="{{ $image }}" data-toggle="modal" data-target="#imagesModal-{{ $preview->video->id }}" data-image="#image-{{ $preview->video->id }}-{{ $loop->iteration }}">
          @endforeach
        </div>
      </div>
      <br>
    @endforeach
  </div>

  <div class="row no-gutter video-show-width" style="margin-top: -80px;">
    <div id="tablinks-wrapper" class="tab mobile-padding" style="margin-top: 30px; font-weight: bold;">
      <button id="comment-tablink" data-foreignid="{{ $preview->uuid }}" data-type="preview" data-tabcontent="comment-tabcontent" class="tablinks comment-tablinks defaultOpen" style="margin-right: 10px;">評論&nbsp;&nbsp;<span id="tab-comments-count" style="color: white; background-color: red; font-size: 12px; border-radius: 10px; padding: 1px 5px">{{ $comments_count }}</span></button>
      <button data-tabcontent="related-tabcontent" class="tablinks">相關影片</button>
    </div>

    <!-- Tab content -->
    <div id="related-tabcontent" class="tabcontent mobile-padding" style="margin-top: 85px">
      <div class="row" style="margin: 0px -2px;">
        @foreach ($previews as $preview)
          <div class="col-xs-2 hover-opacity-all preview-video-width" style="padding: 0px 2px;">
            <a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $preview->video->id }}">
              <div class="home-rows-videos-div" style="position: relative; display: inline-block; margin-bottom:15px">
                <img style="width: 100%" src="{{ $preview->video->cover }}">
                <div class="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 2px 3px; background: linear-gradient(to bottom, transparent 0%, black 120%);">{{ $preview->video->title }}</div>
                </div>
            </a>
          </div>
        @endforeach
      </div>
    </div>

    <div id="comment-tabcontent" class="tabcontent" style="margin-top: 85px">
      <div id="comment-section-wrapper" class="video-show-comment-width">
        <div id="ajax-loading" style="text-align: center; padding-bottom: 1000px;">
          <img style="width: 40px;" src="https://i.imgur.com/wgOXAy6.gif"/>
        </div>
        <!-- Dynamically loaded comments -->
      </div>
    </div>
  </div>
</div>

<div style="margin-bottom: 15px;">
  @include('ads.home-banner-square', ['desktop_home_3' => '5058640', 'tablet_home_3' => '5058646', 'mobile_home_3' => '5058646'])
</div>

<script>
  var padding = $(window).width() * 0.04;
  var mobile_padding = 15;
  $('.owl-home-row').owlCarousel({
      loop:false,
      dots:false,
      responsive:{
          0:{
              items:3,
              margin:4,
              stagePadding: mobile_padding,
          },
          768:{
              items:4,
              margin:10,
              stagePadding: mobile_padding,
          },
          992:{
              items:6,
              margin:10,
              stagePadding: padding,
          },
          1200:{
            items:7,
            margin:10,
            stagePadding: padding,
          }
      }
  })

  $(".cover-scroll-trigger").click(function() {
    var aim = $(this).data('id');
    var width = $(window).width();
    if (width <= 767.9) {
      $('html,body').animate({ scrollTop: $("#" + aim).offset().top - 48}, 'slow');
    } else if (width > 767.9 && width <= 991) {
      $('html,body').animate({ scrollTop: $("#" + aim).offset().top - 50}, 'slow');
    } else {
      $('html,body').animate({ scrollTop: $("#" + aim).offset().top - 65}, 'slow');
    }
  });
</script>

@if (!Auth::check())
  @include('user.signUpModal')
  @include('user.loginModal')
@endif

@endsection