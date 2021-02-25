@extends('layouts.app')

@section('head')
    @parent
    @include('video.videoHead')
@endsection

@section('nav')
  @include('nav.main')
@endsection

@section('content')
<div id="content-div" class="video-show-mobile-background">
  <div class="row no-gutter video-show-width">
    <div class="col-md-9 single-show-player" style="background-color: #141414;">
      @if ($country_code == 'JP' && in_array($video->id, App\Video::$banned))
          <div style="background-color: black; position: relative; width: 100%; height: 0; padding-bottom: 56.25%; text-align: center;">
            <div style="font-size: 18px; color: white; margin: 0; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 100%">This video is no longer available. :(</div>
          </div>
      @else
        @if ($video->outsource)
          <div style="background-color: black; background-image: url('https://i.imgur.com/zXoBhXA.gif'); background-position: center; background-repeat: no-repeat; background-size: 150px; position: relative; width: 100%; height: 0; padding-bottom: 56.25%;">
              <iframe src="{!! $video->sd !!}" style="border: 0; overflow: hidden; position: absolute; width: 100%; height: 100%; left: 0; top: 0;" allowfullscreen></iframe>
          </div>

        @else
          <div style="position: relative;">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dplayer/dist/DPlayer.min.css">
            <div id="dplayer"></div>
            <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
            <script src="https://cdn.jsdelivr.net/npm/flv.js/dist/flv.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/dplayer/dist/DPlayer.min.js"></script>

            <script>
              const dp = new DPlayer({
                container: document.getElementById('dplayer'),
                autoplay: false,
                theme: '#FF0000',
                preload: 'auto',
                volume: 0.7,
                video: {
                  url: '{!! $video->sd !!}',
                  pic: '{{ $video->imgurH() }}',
                },
              });

              dp.on('play', function () {
                $('#video-play-image').hide();
              });
              dp.on('pause', function () {
                $('#video-play-image').show();
              });
            </script>

            <div id="video-play-image" style="margin: 0; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
              <img style="width: 100px; height: auto; cursor: pointer" src="https://i.imgur.com/brUASlm.png">
            </div>
          </div>
        @endif
      @endif

      <div class="video-show-panel-width">
        <div style="margin-bottom: -6px;">
          <p style="font-size: 12px; color: #bdbdbd; font-weight: 500">{{ Carbon\Carbon::parse($video->uploaded_at)->diffForHumans() }} <span style="font-weight: normal;">&nbsp;|&nbsp;</span> {{ $video->views() }} 次點閱</p>
        </div>

        <h3 id="shareBtn-title" style="line-height: 30px; font-weight: bold; font-size: 1.5em; margin-top: 0px; color: white;">{{ $video->title }}</h3>

        <div style="margin-top: 14px">
          <a style="text-decoration: none;">
            <img class="lazy" style="float:left; width: 20px; height: 20px; margin-top: 0px;" src="{{ $video->user->avatarCircleB() }}" data-src="{{ $video->user->avatar == null ? $video->user->avatarDefault() : $video->user->avatar->filename }}" data-srcset="{{ $video->user->avatar == null ? $video->user->avatarDefault() : $video->user->avatar->filename }}">
            <span style="color: #bdbdbd; font-weight: 500; padding-left: 7px;">{{ $video->user->name }}</span>
          </a>
        </div>

        <h5 style="color: #bdbdbd; font-weight: 400; margin-top: 18px; line-height: 20px; margin-bottom: 14px; white-space: pre-wrap; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">{{ $video->translations['JP'] }} • 中文字幕 • {{ $video->caption }}</h5>

        <h5 style="font-weight: 400; margin-bottom: 3px; margin-top: 0px;">
          @foreach ($video->tags() as $tag)
              <div class="single-video-tag"><a href="/search?query={{ $tag }}">{{ $tag }}</a></div>
          @endforeach
        </h5>

        <div id="video-like-form-wrapper" style="display: inline-block; position: absolute;" title="{{ $video->likes_count }} 個讚好">
          @include('video.like-btn-wrapper')
        </div>

        <div id="video-save-form-wrapper" style="display: inline-block; position: absolute;" title="儲存">
          @include('video.save-btn-wrapper')
        </div>

        <div style="position: absolute; cursor: pointer; display: inline-block; cursor: pointer;" id="shareBtn" class="single-icon-wrapper" data-toggle="modal" data-target="#shareModal" title="分享">
          <div class="single-icon no-select">
            <i class="material-icons noselect" style="font-size: 19px; padding-top: 8px; padding-left: 7px; color: white">share</i>
          </div>
        </div>

        <div style="position: absolute; cursor: pointer; display: inline-block; cursor: pointer;" id="reportBtn" class="single-icon-wrapper" data-toggle="modal" data-target="#reportModal" title="報錯">
          <div class="single-icon no-select">
            <i class="material-icons noselect" style="font-size: 21px; padding-top: 7px; padding-left: 7px; color: white">outlined_flag</i>
          </div>
        </div>

        <div id="complainBtn" style="position: absolute; margin-top: 10px; cursor: pointer;">
          <a style="color: #8c8c8c; font-size: 12px" href="/copyright">舉報</a>
        </div>
      </div>

      <div id="comment-section-wrapper" class="video-show-comment-width">
        <hr class="video-show-panel-separate-line" style=" margin-top: 10px; border-color: dimgray;">
        @include('video.comment-section-wrapper')
      </div>

      @include('layouts.exoclick-video-show')
    </div>

    <div class="col-md-3 single-show-list">
      <div style="text-align: center; margin-top: 0px">
        <script type="application/javascript">
            var ad_idzone = "4011926",
            ad_width = "300",
            ad_height = "250"
        </script>
        <script type="application/javascript" src="https://a.realsrv.com/ads.js"></script>
        <noscript>
            <iframe src="https://syndication.realsrv.com/ads-iframe-display.php?idzone=4011926&output=noscript&type=300x250" width="300" height="250" scrolling="no" marginwidth="0" marginheight="0" frameborder="0"></iframe>
        </noscript>
      </div>

      <h4 style="font-size: 15px; color: white; font-weight: bold">集數列表</h4>
      <div id="video-playlist-wrapper">
        <div style="text-align: left;">
          @foreach ($videos as $video)
            <div class="related-watch-wrap hover-opacity-all">
              @include('video.singleShowRelated', ['source' => 'video'])
            </div>
          @endforeach
        </div>
      </div>

      <h4 style="font-size: 15px; color: white; margin-top: 15px; font-weight: bold">相關影片</h4>
      <div id="video-playlist-wrapper">
        <div style="text-align: left;">
          @foreach ($related as $video)
            <div class="related-watch-wrap hover-opacity-all {{ $loop->iteration > 30 ? 'hidden-related-video' : '' }}">
              @include('video.singleShowRelated', ['source' => 'video'])
            </div>
          @endforeach
        </div>
      </div>

      <div class="load-more-related-btn related-watch-wrap" style="font-weight: 400 !important;">更多相關影片</div>
    </div>
  </div>

  @include('video.shareModal')
  @include('video.userReportModal')
  @if (!Auth::check())
    @include('user.signUpModal')
    @include('user.loginModal')
  @endif
@endsection