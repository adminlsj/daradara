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
    <div id="player-div-wrapper" class="col-md-9 single-show-player fluid-player-desktop-styles" style="background-color: #141414; position: relative; overflow-y: hidden; overflow-x: hidden;">

      @if ($current->sd_sc)
        <div id="player-lang-wrapper" style="position: absolute; top: 10px; left: 10px; z-index: 1;" class="dropdown">
          <button style="outline:0; border-radius: 0px !important;" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ $lang == 'zh-CHS' ? '简体字幕' : '繁體字幕'}}
            <span class="material-icons">arrow_drop_down</span>
          </button>
          <div id="player-switch-lang" style="margin-top: 0px; border: none; border-radius: 0px !important; border-top: 2px solid rgba(0, 0, 0, 0.5);" data-lang="{{ $lang }}" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            {{ $lang == 'zh-CHS' ? '繁體字幕' : '简体字幕'}}
          </div>
        </div>
      @endif

      @if ($video->outsource)
        <div style="background-color: black; background-image: url('https://vdownload.hembed.com/image/icon/video_loading.gif?secure=LD6BYCdwElEd1mXbPLORmA==,4855473033'); background-position: center; background-repeat: no-repeat; background-size: 150px; position: relative; width: 100%; height: 0; padding-bottom: 56.25%;">
            <iframe src="{!! $sd !!}" style="border: 0; overflow: hidden; position: absolute; width: 100%; height: 100%; left: 0; top: 0;" allowfullscreen></iframe>
        </div>

      @else
        @if (strpos($sd, '.m3u8') !== false)
          @include('video.player-m3u8')
        @else
          @include('video.player-mp4')
        @endif

      @endif

      @if ($is_mobile)
        <div id="mobile-ad" class="hidden-md hidden-lg " style="text-align: center; padding-top: 0px; padding-bottom: 0px; background-color: black; position: relative; display: flex; justify-content: center; align-items: center;">
          <!-- @include('layouts.exoclick', ['id' => '5058654', 'width' => '300', 'height' => '100']) -->
          <iframe width="300px" height="100px" style="display:block" marginWidth="0" marginHeight="0" frameBorder="no" src="https://go.mnaspm.com/smartpop/4b9e24fdd7669cbb4a501582690f7e2a7bb675bd49f6151942870655dc621e12?userId=68266da2436a81581f441c04a73d1525467dff2da85808235979b437cff6f852"></iframe>
          <div id="close-mobile-ad-btn" style="position: absolute; top: 3px; right: 1px; cursor: pointer; border: 1px solid white;"><i style="vertical-align: middle; color: white;" class="material-icons">close</i></div>
        </div>
      @else
        <div style="margin-top: 7px; margin-bottom: 0px; text-align: center">
          @include('layouts.exoclick', ['id' => '4372406', 'width' => '728', 'height' => '90'])
        </div>
      @endif

      <h3 id="shareBtn-title" class="video-details-wrapper" style="font-weight: bold; margin-top: 10px; color: white;">{{ $video->translations['JP'] }}</h3>
      <div class="video-details-wrapper hidden-sm hidden-md hidden-lg hidden-xl" style="font-size: 12px; color: #aaa; font-weight: normal; margin-top: -5px; margin-bottom: 17px">觀看次數：{{ $video->views() }}次&nbsp;&nbsp;{{ Carbon\Carbon::parse($video->created_at)->format('Y-m-d') }}</div>

      <div class="video-details-wrapper desktop-inline-mobile-block" style="position: relative;">
        <div style="display: inline-block;">
          <a href="{{ route('home.search') }}?query={{ $artist->name }}&genre={{ $video->genre }}"><img id="video-user-avatar" src="{{ $artist->avatar_temp }}" alt="{{ $artist->name }}"></a>
          <div style="display: inline-block; vertical-align: middle; margin-left: 8px">
            <div>
              <a id="video-artist-name" style="color: white; text-decoration: none;" href="{{ route('home.search') }}?query={{ $artist->name }}&genre={{ $video->genre }}">
                {{ $artist->name }}
              </a>
              <a class="hidden-sm hidden-md hidden-lg hidden-xl" style="font-size: 12px; color: #aaa; font-weight: normal; margin-left: 8px;" href="{{ route('home.search') }}?genre={{ $video->genre }}">
                {{ $video->genre }}
              </a>
            </div>
            <div class="hidden-xs" style="font-size: 12px; color: #aaa; font-weight: normal">
              <a style="color: #aaa;" href="{{ route('home.search') }}?genre={{ $video->genre }}">
                {{ $video->genre }}
              </a>
            </div>
          </div>
        </div>

        <div id="video-subscribe-form-wrapper" style="display: inline-block;" class="no-select">
          @if (!Auth::check())
            <button class="no-select video-subscribe-btn no-button-style" data-toggle="modal" data-target="#signUpModal">
              訂閱
            </button>
          @else
            @include('video.subscribeBtn', ['user_id' => Auth::user()->id, 'artist_id' => $video->user_id])
          @endif
        </div>
      </div>

      <div class="video-buttons-wrapper desktop-inline-mobile-block hide-scrollbar" style="overflow-y: hidden;">

        @if ($video->comic_id)
          <a class="video-show-action-btn single-icon-outlier no-select" style="color: #e9e9e9; text-decoration: none;" href="{{ route('comic.showCover', ['comic' => $video->comic_id]) }}" target="_blank">
              <i id="video-comic-btn" class="material-icons-outlined">import_contacts</i>漫畫原作
          </a>
        @endif

        <div id="video-like-form-wrapper" class="video-show-action-btn no-select">
          @if (!Auth::check())
            <button id="video-like-btn" class="single-icon-wrapper no-button-style" data-toggle="modal" data-target="#signUpModal">
              <div class="single-icon no-select">
                <i class="material-icons-outlined">thumb_up</i>{{ $video->likes_count }}
              </div>
            </button>
          @else
            @include('video.likeBtn', ['user_id' => Auth::user()->id, 'video_id' => $video->id, 'likes_count' => $video->likes_count])
          @endif
        </div>

        <div id="video-save-form-wrapper" class="video-show-action-btn no-select">
          @if (!Auth::check())
            <div id="video-save-btn" data-toggle="modal" data-target="#signUpModal" style="text-decoration: none; color: inherit; text-align: center; cursor: pointer;" class="single-icon-wrapper">
              <div class="single-icon no-select">
                <i style="vertical-align: middle; margin-top: -3px; font-size: 24px; margin-right: 8px;" class="material-icons-outlined">playlist_add</i>儲存
              </div>
            </div>
          @else
            @include('video.saveBtn-new', ['save_icon' => $saved || $listed != '[]' ? 'playlist_add_check' : 'playlist_add', 'save_text' => $saved || $listed != '[]' ? '已儲存' : '儲存'])
          @endif
        </div>

        @if ($qualities != null || $downloads != null)
          <a href="{{ route('video.download') }}?v={{ $video->id }}" target="_blank" id="downloadBtn" class="single-icon-wrapper" style="text-decoration: none;">
            <div class="video-show-action-btn no-select single-icon-outlier">
              <i id="video-download-btn" class="material-icons">download</i>下載
            </div>
          </a>
        @else
          <a class="single-icon-wrapper" disabled="true" style="text-decoration: none;">
            <div class="video-show-action-btn no-select single-icon-outlier">
              <i id="video-download-btn" class="material-icons">download</i>無法下載
            </div>
          </a>
        @endif

        <div id="shareBtn" class="video-show-action-btn no-select {{ $video->comic_id ? 'hidden-sm hidden-md hidden-lg' : 'hidden-md' }} single-icon-outlier" data-toggle="modal" data-target="#shareModal">
          <i id="video-share-btn" class="material-icons">share</i>分享
        </div>

        <div class="video-show-action-btn no-select single-icon-outlier hidden-sm hidden-md hidden-lg hidden-xl" data-toggle="modal" data-target="#reportModal">
          <i id="video-report-btn" class="material-icons-outlined">flag</i>報錯
        </div>

        <div class="video-show-action-btn no-select hidden-xs" style="padding: 0 7px;" data-toggle="modal" data-target="#reportModal">
          <i class="material-icons" style="vertical-align: middle; margin-top: -3px">more_horiz</i>
        </div>
      </div>

      <br class="hidden-sm hidden-md hidden-lg"/><br class="hidden-sm hidden-md hidden-lg"/>

      <div class="video-details-wrapper">
        <div class="video-description-panel video-description-panel-hover no-select" style="cursor: pointer; color: white; padding: 10px 12px; border-radius: 15px; position: relative;">
          <div class="hidden-xs" style="margin-bottom: 5px">觀看次數：{{ $video->views() }}次&nbsp;&nbsp;{{ Carbon\Carbon::parse($video->created_at)->format('Y-m-d') }}</div>
          <div style="margin-bottom: 5px">{{ $video->title }}</div>
          <div class="video-caption-text caption-ellipsis" style="color: #b8babc; font-weight: normal;">{{ $video->caption }}</div>
        </div>
      </div>

      <div class="video-details-wrapper video-tags-wrapper" style="margin-bottom: -20px">
        @foreach ($tags as $tag)
          @if ($tag != $video->artist)
            <div class="single-video-tag" style="margin-bottom: 18px; font-weight: normal"><a style="border-radius: 15px;" href="/search?tags%5B%5D={{ $tag }}{{ $doujin ? '' : '&genre=裏番' }}">{{ $tag }}</a></div>
          @endif
        @endforeach

        <div class="single-video-tag" data-toggle="modal" data-target="{{ Auth::check() ? '#add-tags-modal' : '#signUpModal' }}" style="position: relative; cursor: pointer; margin-bottom: 16px; font-weight: normal"><a style="padding-left: 15px; padding-right: 15px; border-radius: 15px;"><span class="material-icons" style="position: absolute; margin-left: auto; margin-right: auto; left: -3px; right: 0; text-align: center; margin-top: -1px; font-size: 22px; vertical-align: middle">add</span></a></div>
        <div class="single-video-tag" data-toggle="modal" data-target="{{ Auth::check() ? '#remove-tags-modal' : '#signUpModal' }}" style="position: relative; cursor: pointer; margin-bottom: 16px; font-weight: normal"><a style="padding-left: 15px; padding-right: 15px; border-radius: 15px;"><span class="material-icons" style="position: absolute; margin-left: auto; margin-right: auto; left: -2px; right: 0; text-align: center; margin-top: -1px; font-size: 22px; vertical-align: middle">remove</span></a></div>
      </div>

      <div class="hidden-md hidden-lg" style="margin-top: 25px">
        @include('video.playlist-panel')
      </div>

      @if (!$is_mobile)
        <div class="hidden-md hidden-lg" style="text-align: left; padding-left: 5px; padding-top: 5px; margin-top: 15px; margin-bottom: -15px; padding-bottom: 0px; margin-left: 15px; margin-right: 15px; width: 310px; height: 282px; background-color: #3a3c3f; display: inline-block;">
          <div style="margin-bottom: 5px; color: white; font-size: 12px;">點點廣告，贊助我們（●´∀｀）ノ♡</div>
          @include('layouts.exoclick', ['id' => '5058646', 'width' => '300', 'height' => '250'])
        </div>

        <div class="hidden-xs hidden-md hidden-lg" style="text-align: left; padding-left: 5px; padding-top: 5px; margin-top: 15px; margin-bottom: -15px; padding-bottom: 0px; width: 310px; height: 282px; background-color: #3a3c3f; display: inline-block; vertical-align: top; margin-left: -5px;">
          <div style="margin-bottom: 5px; color: white; font-size: 12px;">點點廣告，贊助我們（●´∀｀）ノ♡</div>
          <!-- JuicyAds v3.1 -->
          <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
          <ins id="940485" data-width="300" data-height="262"></ins>
          <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':940485});</script>
          <!--JuicyAds END-->
        </div>
      @else
        @include('ads.watch-double-banners', ['mobile_watch' => '5058646'])
      @endif

      <div id="tablinks-wrapper" class="tab mobile-padding" style="margin-top: 30px; font-weight: bold;">
        <button id="defaultOpen" data-tabcontent="related-tabcontent" class="tablinks" style="margin-right: 10px;">相關影片</button>
        <button id="comment-tablink" data-foreignid="{{ $current->id }}" data-type="video" data-tabcontent="comment-tabcontent" class="tablinks comment-tablinks" style="margin-right: 10px;">評論&nbsp;&nbsp;<span id="tab-comments-count" style="color: white; background-color: red; font-size: 12px; border-radius: 10px; padding: 1px 5px">{{ $comments_count }}</span></button>
        <!-- <button id="commentP-tablink" data-foreignid="{{ $current->id }}" data-type="video" data-tabcontent="comment-tabcontent" class="tablinks comment-tablinks">嘴砲&nbsp;&nbsp;<span id="tab-commentsP-count" style="color: white; background-color: red; font-size: 12px; border-radius: 10px; padding: 1px 5px">{{ $commentsP_count }}</span></button> -->
      </div>

      <!-- Tab content -->
      <div id="related-tabcontent" class="tabcontent mobile-padding" style="margin-top: 85px">
        <div class="row {{ $doujin ? 'doujin-row' : '' }}" style="margin: {{ $doujin ? '0px -2px;' : '0px -5px;' }}">
            @if ($doujin)
              <!-- Erolabs advertisement -->
              <div style="padding: 5px 14px; margin-top: -5px;" class="hidden-sm hidden-md hidden-lg hidden-xl related-watch-wrap multiple-link-wrapper">
                <a class="overlay" href="https://www.tip-top.one/" target="_blank"></a>
                <div class="card-mobile-panel inner">
                  <div style="width: 150px; display: inline-block;">
                    <div style="position: relative; display: inline-block;">
                      <img style="width: 100%; height: 100%; border-radius: 5px;" src="https://vdownload.hembed.com/image/icon/card_doujin_background.jpg?secure=sJRJ4-aVOQw4IVZasq7YZw==,4853041705">
                      <img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 5px;" src="https://vdownload.hembed.com/image/icon/erolabs_640x360.jpg?secure=3Tp8Y9L0q8tQSsUZO2fEIw==,4868406408" alt="轉生到異世界當HGAME製作人">
                    </div>
                  </div>

                  <div style="display: inline-block; text-decoration: none; color: black; margin-top: -2px; margin-left: 8px; height: 50px; width: calc(100% - 168px); vertical-align: top;">
                    <div class="card-mobile-title" style="color: #e5e5e5;">轉生到異世界當HGAME製作人</div>

                    <div class="card-mobile-genre-wrapper" style="margin-top: 4px; margin-left: -2px">
                      <a href="https://www.tip-top.one/" target="_blank" style="font-size: 12px; color: dimgray; margin-left: 2px; display: inline-block;" class="card-mobile-user">Nijikon</a>
                    </div>

                    <div style="float: left; margin-top: -3px;">
                      <div class="card-mobile-duration" style="background: #2E2E2E; padding: 0px 4px; margin-right: 5px; color: #b8babc; line-height: 19px;">
                        贊助商
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @foreach ($related as $video)
                <div class="multiple-link-wrapper related-doujin-videos hidden-xs" style="display: inline-block; padding-right: 3px; white-space: normal; margin-bottom: 20px;">
                  <a class="overlay" href="{{ route('video.watch') }}?v={{ $video->id }}"></a>
                  @include('video.card-doujin-desktop')
                </div>
                <!-- Add to div style {{ $loop->first ? 'margin-top: -5px;' : ''}} -->
                <div style="padding: 5px 14px;" class="hidden-sm hidden-md hidden-lg hidden-xl related-watch-wrap multiple-link-wrapper {{ $loop->iteration > 30 ? 'hidden-xs hidden-sm temp-hidden-related-video' : '' }}">
                  <a class="overlay" href="{{ route('video.watch') }}?v={{ $video->id }}"></a>
                  @include('video.singleShowRelated', ['source' => $video])
                </div>
              @endforeach

            @else
              <!-- Erolabs advertisement -->
              <div class="hidden-md hidden-lg col-xs-2 related-video-width" style="padding: 0px 4px;">
                <a style="text-decoration: none;" href="https://l.erodatalabs.com/s/0kHIbk" target="_blank">
                  <div class="home-rows-videos-div related-video-margin-bottom" style="position: relative; display: inline-block;">
                    <img style="width: 100%; border-radius: 3px" src="https://vdownload.hembed.com/image/icon/erolabs_cherry_talezh_268x394.jpg?secure=qT5pWLseBnQrVizMXQJakg==,1736065417">
                  </div>
                </a>
              </div>
              @foreach ($related as $video)
                <div class="col-xs-2 related-video-width {{ $loop->iteration > 29 && $loop->iteration != 60 ? 'hidden-xs hidden-sm temp-hidden-related-video' : '' }} {{ $loop->iteration == 60 ? 'hidden-xs hidden-sm' : '' }}" style="padding: 0px 4px;">

                  <a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video->id }}">
                    <div class="home-rows-videos-div related-video-margin-bottom" style="position: relative; display: inline-block;">
                      <img style="width: 100%; border-radius: 3px" src="{{ $video->cover }}">
                      <div class="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 3px 3px; background: linear-gradient(to bottom, transparent 0%, black 120%); font-weight: normal;">{{ str_replace('[新番預告]', '', $video->title) }}</div>
                    </div>
                  </a>

                </div>
              @endforeach
            @endif
        </div>
        <div class="load-more-related-btn related-watch-wrap hidden-md hidden-lg" style="margin-left: -2px; margin-right: -2px; margin-top: 0px; {{ $doujin ? 'margin-top: 5px' : ''}}">更多相關影片</div>
      </div>

      <div id="comment-tabcontent" class="tabcontent" style="margin-top: 85px">
        <div id="comment-section-wrapper" class="video-show-comment-width">
          <div id="ajax-loading" style="text-align: center; padding-bottom: 1000px;">
            <img style="width: 40px;" src="https://vdownload.hembed.com/image/icon/loading.gif?secure=sZ6Qgx3HbAFf7be7yAIGVA==,4855472894"/>
          </div>
          <!-- Dynamically loaded comments -->
        </div>
      </div>

      @if (!$is_mobile)
        <div style="padding: 0 15px;">
          <div id="more-related-ad" class="hidden-md hidden-lg" style="text-align: left; padding-left: 5px; padding-top: 5px; margin-top: 8px; margin-bottom: 10px; padding-bottom: 0px; width: 310px; height: 282px; background-color: #3a3c3f; display: inline-block; vertical-align: top;">
            <div style="margin-bottom: 5px; color: white; font-size: 12px;">點點廣告，贊助我們（●´∀｀）ノ♡</div>
            <!-- JuicyAds v3.1 -->
            <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
            <ins id="940485" data-width="300" data-height="262"></ins>
            <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':940485});</script>
            <!--JuicyAds END-->
          </div>

          <div id="exoclick-banner-adjust" class="hidden-xs hidden-md hidden-lg" style="text-align: left; padding-left: 5px; padding-top: 5px; margin-top: 8px; margin-bottom: 10px; padding-bottom: 0px; width: 310px; height: 282px; background-color: #3a3c3f; margin-left: 10px; display: inline-block; vertical-align: top;">
            <div style="margin-bottom: 5px; color: white; font-size: 12px;">點點廣告，贊助我們（●´∀｀）ノ♡</div>
            @include('layouts.exoclick', ['id' => '5058646', 'width' => '300', 'height' => '250'])
          </div>
        </div>
      @else
        <div id="double-banners-adjust" style="margin-top: -8px;">
          @include('ads.watch-double-banners', ['mobile_watch' => '5058646'])
        </div>
        <div id="watch-footer">
          <div style="padding: 15px; margin-bottom: -70px; margin-top: 17px;">
            @include('layouts.footer')
          </div>
        </div>
      @endif

    </div>

    <div class="col-md-3 single-show-list">
      @if (!$is_mobile)
        <div class="hidden-xs hidden-sm" style="text-align: left; padding-left: 5px; padding-top: 5px; margin-top: 0px; margin-bottom: 15px; padding-bottom: 0px; width: 310px; height: 286px; background-color: #2E2E2E; border-radius: 10px">
          <div style="padding: 5px; color: white; font-size: 12px;">點點廣告，贊助我們（●´∀｀）ノ♡</div>
          <!-- Original Exoclick -->
          <!-- include('layouts.exoclick', ['id' => '5058646', 'width' => '300', 'height' => '250']) -->
          <!-- New Stripchat -->
          <iframe width="300px" height="250px" style="display:block" marginWidth="0" marginHeight="0" frameBorder="no" src="https://go.mnaspm.com/smartpop/90c1264ffb57b69c7a31ac6231b7301cff76092d71bdeccc32ecfd9bbb8d48be?userId=68266da2436a81581f441c04a73d1525467dff2da85808235979b437cff6f852"></iframe>
        </div>

        <div class="hidden-xs hidden-sm">
          @include('video.playlist-panel')
        </div>
      @endif

      <div id="myHeader" class="hidden-xs hidden-sm">
        @if (!$is_mobile)
          <div style="text-align: left; padding-left: 5px; padding-top: 5px; margin-top: 15px; margin-bottom: 10px; padding-bottom: 0px; width: 310px; height: 282px; background-color: #2E2E2E;">
            <div style="margin-bottom: 5px; color: white; font-size: 12px;">點點廣告，贊助我們（●´∀｀）ノ♡</div>
            @include('layouts.exoclick', ['id' => '5058646', 'width' => '300', 'height' => '250'])
          </div>

          <div style="text-align: left; padding-left: 5px; padding-top: 5px; margin-top: 15px; margin-bottom: 10px; padding-bottom: 0px; width: 310px; height: 282px; background-color: #2E2E2E;">
            <div style="margin-bottom: 5px; color: white; font-size: 12px;">點點廣告，贊助我們（●´∀｀）ノ♡</div>
            <!-- JuicyAds v3.1 -->
            <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
            <ins id="940485" data-width="300" data-height="262"></ins>
            <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':940485});</script>
            <!--JuicyAds END-->
          </div>
        @endif
      </div>
      
    </div>
  </div>

  @if (!$is_mobile)
    <div id="bottom-ads" style="margin-top: 30px; margin-bottom: 0px; text-align: center;" class="hidden-xs hidden-sm">
      @include('layouts.exoclick', ['id' => '5058640', 'width' => '900', 'height' => '250'])
    </div>
  @endif

  @include('video.userReportModal')
  @include('video.shareModal')
  @if (!Auth::check())
    @include('user.signUpModal')
    @include('user.loginModal')
  @else
    <script src="https://js.hcaptcha.com/1/api.js" async defer></script>
    @include('video.add-tags-modal')
    @include('video.remove-tags-modal')
    @include('video.playlist-modal')
  @endif
</div>

@if ($is_mobile)
  <script>
    var ratio = ($(window).width() / 2) / 300;
    if (ratio < 1) {
      var exoclick = $('.scaled-exoclick');
      var juicyads = $('.scaled-juicyads');
      exoclick.css('transform-origin', 'top right');
      exoclick.css('transform', 'scale(' + ratio + ')');
      juicyads.css('transform-origin', 'top left');
      juicyads.css('transform', 'scale(' + ratio + ')');

      var gap = 250 - 250 * ratio;
      $('#tablinks-wrapper').css('margin-top', (5 - gap) + 'px');
      $('.tabcontent').css('margin-top', '55px');
      $('#watch-footer').css('margin-top', (5 - gap) + 'px');
    }
  </script>
@endif

@endsection