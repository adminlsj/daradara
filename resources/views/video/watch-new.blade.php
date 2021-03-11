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
  <div class="row no-gutter video-show-width">
    <div id="player-div-wrapper" class="col-md-9 single-show-player fluid-player-desktop-styles" style="background-color: #141414;">
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
          <link rel="stylesheet" href="https://cdn.fluidplayer.com/v2/current/fluidplayer.min.css" type="text/css">
          <script src="https://cdn.fluidplayer.com/v2/current/fluidplayer.min.js"></script>

          <div style="position: relative;">
            <div style="margin-bottom: -5px;">
              <video id="my-video">
                  <source src="{!! $video->sd !!}" type='{{ strpos($video->sd, '.m3u8') !== false ? 'application/x-mpegURL' : 'video/mp4'}}'>
              </video>
            </div>
            <div id="video-play-image" style="margin: 0; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80px; height: 80px; text-align: center; background-color: transparent; cursor: pointer;">
            </div>
          </div>

          <script type="application/javascript">
              var fluidplayer = fluidPlayer(
                  "my-video",
                  {
                      layoutControls: {
                        "primaryColor": 'red',
                        "allowTheatre": false,
                        "fillToContainer": true,
                        "playButtonShowing": true,
                        "playPauseAnimation": true,
                        "playbackRateEnabled": true,
                        "posterImage": "{{ $video->imgurH() }}",
                        "controlBar": {
                            "autoHide": true,
                            "autoHideTimeout": 2,
                            "animated": true
                        }
                      },
                      vastOptions: {
                          "adList": [{
                              "roll": "preRoll",
                              "vastTag": "https://syndication.realsrv.com/splash.php?idzone=4208068",
                              "timer": 5
                          }]
                      }
                  }
              );
              fluidplayer.on('play', function () {
                $('#video-play-image').hide();
              });
          </script>

        @endif
      @endif

      <div id="mobile-ad" class="hidden-md hidden-lg" style="text-align: center; padding-top: 5px; background-color: black; position: relative;">
        <script type="application/javascript">
            var ad_idzone = "4206424",
            ad_width = "300",
            ad_height = "100";
        </script>
        <script type="application/javascript" src="https://a.realsrv.com/ads.js"></script>
        <noscript>
            <iframe src="https://syndication.realsrv.com/ads-iframe-display.php?idzone=4206424&output=noscript" width="300" height="100" scrolling="no" marginwidth="0" marginheight="0" frameborder="0"></iframe>
        </noscript>
        <div id="close-mobile-ad-btn" style="position: absolute; top: 5px; right: 1px; cursor: pointer; border: 1px solid white;"><i style="vertical-align: middle; color: white;" class="material-icons">close</i></div>
      </div>

      <div class="hidden-xs hidden-sm" style="margin-top: 7px; margin-bottom: -5px; text-align: center">
        <script type="application/javascript">
            var ad_idzone = "4205380",
            ad_width = "728",
            ad_height = "90";
        </script>
        <script type="application/javascript" src="https://a.realsrv.com/ads.js"></script>
        <noscript>
            <iframe src="https://syndication.realsrv.com/ads-iframe-display.php?idzone=4205380&output=noscript" width="728" height="90" scrolling="no" marginwidth="0" marginheight="0" frameborder="0"></iframe>
        </noscript>
      </div>

      <div class="video-show-panel-width">
        <div style="margin-bottom: -6px;">
          <p style="font-size: 12px; color: #bdbdbd; font-weight: 500">{{ Carbon\Carbon::parse($video->created_at)->format('Y-m-d') }} <span style="font-weight: normal;">&nbsp;|&nbsp;</span> {{ $video->views() }}次點閱</p>
        </div>

        <h3 id="shareBtn-title" style="line-height: 30px; font-weight: bold; font-size: 1.5em; margin-top: 0px; color: white;">{{ $video->title }}</h3>

        <h5 style="color: #bdbdbd; font-weight: 400; margin-top: 10px; line-height: 20px; margin-bottom: 15px; white-space: pre-wrap; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;"><span style="font-weight: bold">{{ $video->translations['JP'] }} [中文字幕]</span></h5>

        <h5 style="font-weight: 400; margin-bottom: 3px; margin-top: 0px;">
          @foreach ($video->tags() as $tag)
              <div class="single-video-tag"><a href="/search?tags%5B%5D={{ $tag }}">{{ $tag }}</a></div>
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

        @if ($video->foreign_sd == null || (!array_key_exists('spankbang', $video->foreign_sd) && !array_key_exists('youjizz', $video->foreign_sd) && strpos($video->sd, 'motherless') === false))
          <a style="position: absolute; cursor: pointer; display: inline-block;" id="downloadBtn" class="single-icon-wrapper" title="無法下載">
            <div class="single-icon no-select" style="background-color: inherit !important">
              <i class="material-icons noselect" style="font-size: 23px; padding-top: 7px; padding-left: 6px; color: dimgray">download</i>
            </div>
          </a>
        @else
          <a href="{{ route('video.download') }}?v={{ $video->id }}" target="_blank" style="position: absolute; cursor: pointer; display: inline-block; cursor: pointer;" id="downloadBtn" class="single-icon-wrapper" title="下載">
            <div class="single-icon no-select">
              <i class="material-icons noselect" style="font-size: 23px; padding-top: 7px; padding-left: 6px; color: white">download</i>
            </div>
          </a>
        @endif

        <div style="position: absolute; cursor: pointer; display: inline-block; cursor: pointer;" id="reportBtn" class="single-icon-wrapper" data-toggle="modal" data-target="#reportModal" title="報錯">
          <div class="single-icon no-select">
            <i class="material-icons noselect" style="font-size: 21px; padding-top: 7px; padding-left: 7px; color: white">outlined_flag</i>
          </div>
        </div>

        <div id="complainBtn" style="position: absolute; margin-top: 10px; cursor: pointer;">
          <a style="color: #8c8c8c; font-size: 12px" href="/copyright">舉報</a>
        </div>
      </div>

      <div class="hidden-md hidden-lg" style="margin-top: 25px">
        @include('video.playlist-panel')
      </div>

      <div class="hidden-md hidden-lg" style="text-align: left; padding-left: 5px; padding-top: 5px; margin-top: 15px; margin-bottom: -15px; padding-bottom: 0px; margin-left: 15px; margin-right: 15px; width: 310px; height: 282px; background-color: #3a3c3f;">
        <div style="margin-bottom: 5px; color: white; font-size: 12px;">點點廣告，贊助我們（●´∀｀）ノ♡</div>
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

      <div class="tab mobile-padding" style="margin-top: 30px; font-weight: bold;">
        <button id="defaultOpen" style="margin-right: 10px;" class="tablinks" onclick="openCity(event, 'London')">相關影片</button>
        <button class="tablinks" onclick="openCity(event, 'Paris')">評論&nbsp;&nbsp;<span style="color: white; background-color: red; font-size: 12px; border-radius: 10px; padding: 1px 5px">{{ $comments->count() }}</span></button>
      </div>

      <!-- Tab content -->
      <div id="London" class="tabcontent mobile-padding" style="margin-top: 85px">
        <div class="row" style="margin: 0px -2px;">
          @foreach ($related as $video)
            <div class="col-xs-2 hover-opacity-all related-video-width {{ $loop->iteration > 30 ? 'hidden-xs hidden-sm' : '' }}" style="padding: 0px 2px;">
              <a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video->id }}">
                <div class="home-rows-videos-div" style="position: relative; display: inline-block; margin-bottom:15px">
                  <img style="width: 100%" src="{{ $video->cover }}">
                  <div class="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 3px 3px; background: linear-gradient(to bottom, transparent 0%, black 120%);">{{ $video->title }}</div>
                  </div>
              </a>
            </div>
          @endforeach
        </div>
        <div class="load-more-related-btn related-watch-wrap hidden-md hidden-lg" style="font-weight: 400 !important; margin-top: 0px;">更多相關影片</div>

        <div id="more-related-ad" class="hidden-md hidden-lg" style="text-align: left; padding-left: 5px; padding-top: 5px; margin-top: 15px; margin-bottom: 10px; padding-bottom: 0px; width: 310px; height: 282px; background-color: #3a3c3f;">
          <div style="margin-bottom: 5px; color: white; font-size: 12px;">點點廣告，贊助我們（●´∀｀）ノ♡</div>
          <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
          <ins id="906454" data-width="300" data-height="262"></ins>
          <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':906454});</script>
        </div>
      </div>

      <div id="Paris" class="tabcontent" style="margin-top: 85px">
        <div id="comment-section-wrapper" class="video-show-comment-width">
          @include('video.comment-section-wrapper')
        </div>

        <div id="more-related-ad" class="hidden-md hidden-lg" style="text-align: left; padding-left: 5px; padding-top: 5px; margin-top: 0px; margin-bottom: 10px; padding-bottom: 0px; width: 310px; height: 282px; background-color: #3a3c3f; margin-left: 15px; margin-right: 15px;">
          <div style="margin-bottom: 5px; color: white; font-size: 12px;">點點廣告，贊助我們（●´∀｀）ノ♡</div>
          <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
          <ins id="906454" data-width="300" data-height="262"></ins>
          <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':906454});</script>
        </div>
      </div>

      <script>
        document.getElementById("defaultOpen").click();
        function openCity(evt, cityName) {
          // Declare all variables
          var i, tabcontent, tablinks;

          // Get all elements with class="tabcontent" and hide them
          tabcontent = document.getElementsByClassName("tabcontent");
          for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
          }

          // Get all elements with class="tablinks" and remove the class "active"
          tablinks = document.getElementsByClassName("tablinks");
          for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
          }

          // Show the current tab, and add an "active" class to the button that opened the tab
          document.getElementById(cityName).style.display = "block";
          evt.currentTarget.className += " active";
        }
      </script>
    </div>

    <div class="col-md-3 single-show-list">
      <div class="hidden-xs hidden-sm" style="text-align: left; padding-left: 5px; padding-top: 5px; margin-top: 0px; margin-bottom: 15px; padding-bottom: 0px; width: 310px; height: 282px; background-color: #3a3c3f;">
        <div style="margin-bottom: 5px; color: white; font-size: 12px;">點點廣告，贊助我們（●´∀｀）ノ♡</div>
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

      <div class="hidden-xs hidden-sm">
        @include('video.playlist-panel')
      </div>

      <div id="myHeader" class="hidden-xs hidden-sm">
        <div style="text-align: left; padding-left: 5px; padding-top: 5px; margin-top: 15px; margin-bottom: 10px; padding-bottom: 0px; width: 310px; height: 282px; background-color: #3a3c3f;">
          <div style="margin-bottom: 5px; color: white; font-size: 12px;">點點廣告，贊助我們（●´∀｀）ノ♡</div>
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

        <div style="text-align: left; padding-left: 5px; padding-top: 5px; margin-top: 15px; margin-bottom: 10px; padding-bottom: 0px; width: 310px; height: 282px; background-color: #3a3c3f;">
          <div style="margin-bottom: 5px; color: white; font-size: 12px;">點點廣告，贊助我們（●´∀｀）ノ♡</div>
          <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
          <ins id="906454" data-width="300" data-height="262"></ins>
          <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':906454});</script>
        </div>
      </div>
    </div>
  </div>

  <div id="bottom-ads" style="margin-top: 30px; margin-bottom: -10px;" class="hidden-xs hidden-sm">
    @include('layouts.exoclick')
  </div>

  @include('video.shareModal')
  @include('video.userReportModal')
  @if (!Auth::check())
    @include('user.signUpModal')
    @include('user.loginModal')
  @endif
@endsection