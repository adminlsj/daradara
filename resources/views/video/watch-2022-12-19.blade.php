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
          @if ($video->has_torrent)
            <a href="{{ route('video.download') }}?v={{ $video->id }}&torrent=true" id="player-switch-torrent" style="text-decoration: none; border-radius: 0px !important;" class="dropdown-menu" aria-labelledby="dropdownMenuButton" target="_blank">
                外掛字幕
            </a>
          @endif
        </div>
      @endif

      @if ($video->outsource)
        <div style="background-color: black; background-image: url('https://i.imgur.com/zXoBhXA.gif'); background-position: center; background-repeat: no-repeat; background-size: 150px; position: relative; width: 100%; height: 0; padding-bottom: 56.25%;">
            <iframe src="{!! $sd !!}" style="border: 0; overflow: hidden; position: absolute; width: 100%; height: 100%; left: 0; top: 0;" allowfullscreen></iframe>
        </div>

      @else
        @if (strpos($sd, '.m3u8') !== false)
          @include('video.player-m3u8')
        @else
          @include('video.player-mp4')
        @endif

      @endif

      <div id="mobile-ad" class="hidden-md hidden-lg" style="text-align: center; padding-top: 5px; padding-bottom: 0px;background-color: black; position: relative;">
        @include('layouts.exoclick', ['id' => '4372430', 'width' => '300', 'height' => '100'])
        <div id="close-mobile-ad-btn" style="position: absolute; top: 5px; right: 1px; cursor: pointer; border: 1px solid white;"><i style="vertical-align: middle; color: white;" class="material-icons">close</i></div>
      </div>

      <div class="hidden-xs hidden-sm" style="margin-top: 7px; margin-bottom: 0px; text-align: center">
        @include('layouts.exoclick', ['id' => '4372406', 'width' => '728', 'height' => '90'])
      </div>

      <h3 id="shareBtn-title" class="video-details-wrapper" style="font-weight: bold; margin-top: 10px; color: white;">{{ $video->translations['JP'] }}</h3>
      <div class="video-details-wrapper hidden-sm hidden-md hidden-lg hidden-xl" style="font-size: 12px; color: #aaa; font-weight: normal; margin-top: -5px; margin-bottom: 17px">觀看次數：{{ $video->views() }}次&nbsp;&nbsp;{{ Carbon\Carbon::parse($video->created_at)->format('Y-m-d') }}</div>

      <div class="video-details-wrapper desktop-inline-mobile-block">
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

        <div class="no-select video-subscribe-btn hidden-md" data-toggle="modal" data-target="#subscribeModal">
          訂閱
        </div>

        <div id="subscribeModal" class="modal" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
                <h4 class="modal-title">訂閱作者</h4>
              </div>
              <div class="modal-body" style="padding-bottom: 20px; text-align: left;">
                <h4>追蹤喜歡的作者</h4>
                <p id="hentai-tags-text" style="color: darkgray;">訂閱功能即將全面開放！</p>
              </div>
              <hr style="border-color: #323434; margin: 0; margin-top: -10px;">
              <div class="modal-footer">
                <div data-dismiss="modal">返回</div>
                <button data-dismiss="modal" class="pull-right btn btn-primary">我知道了</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="video-buttons-wrapper desktop-inline-mobile-block hide-scrollbar" style="overflow-y: hidden;">

        @if ($video->comic_id)
          <a class="video-show-action-btn no-select" style="color: #e9e9e9; text-decoration: none; padding: 0 16px;" href="{{ route('comic.showCover', ['comic' => $video->comic_id]) }}" target="_blank">
              <i class="material-icons-outlined" style="vertical-align: middle; margin-top: -5px; font-size: 20px; margin-right: 10px;">import_contacts</i>漫畫原作
          </a>
        @endif

        <div id="video-like-form-wrapper" class="video-show-action-btn no-select">
          @if (!Auth::check())
            <button id="video-like-btn" class="single-icon-wrapper no-button-style" method="POST" data-toggle="modal" data-target="#signUpModal">
              <div class="single-icon no-select">
                <i class="material-icons{{ $liked ? '' : '-outlined'}}">thumb_up</i>{{ $video->likes_count }}
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
          <a class="single-icon-wrapper" title="無法下載" disabled="true">
            <div class="video-show-action-btn no-select single-icon-outlier">
              <i id="video-download-btn" class="material-icons">download</i>下載
            </div>
          </a>
        @endif

        <div id="shareBtn" class="video-show-action-btn no-select hidden-md single-icon-outlier" data-toggle="modal" data-target="#shareModal">
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

      <div class="video-details-wrapper" style="margin-top: 20px; margin-bottom: -20px">
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
          @include('layouts.exoclick', ['id' => '4372438', 'width' => '300', 'height' => '250'])
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
        @include('ads.watch-double-banners')
      @endif

      <div id="tablinks-wrapper" class="tab mobile-padding" style="margin-top: 30px; font-weight: bold;">
        <button id="defaultOpen" data-tabcontent="related-tabcontent" class="tablinks" style="margin-right: 10px;">相關影片</button>
        <button id="comment-tablink" data-foreignid="{{ $current->id }}" data-type="video" data-tabcontent="comment-tabcontent" class="tablinks">評論&nbsp;&nbsp;<span id="tab-comments-count" style="color: white; background-color: red; font-size: 12px; border-radius: 10px; padding: 1px 5px">{{ $comments_count }}</span></button>
      </div>

      <!-- Tab content -->
      <div id="related-tabcontent" class="tabcontent mobile-padding" style="margin-top: 85px">
        <div class="row {{ $doujin ? 'doujin-row' : '' }}" style="margin: {{ $doujin ? '0px -2px;' : '0px -5px;' }}">
            @if ($doujin)
              @foreach ($related as $video)
                <div class="multiple-link-wrapper related-doujin-videos hidden-xs" style="display: inline-block; padding-right: 3px; white-space: normal; margin-bottom: 20px;">
                  <a class="overlay" href="{{ route('video.watch') }}?v={{ $video->id }}"></a>
                  @include('video.card-doujin-desktop')
                </div>
                <div style="padding: 5px 14px; {{ $loop->first ? 'margin-top: -5px;' : ''}}" class="hidden-sm hidden-md hidden-lg hidden-xl related-watch-wrap multiple-link-wrapper {{ $loop->iteration > 30 ? 'hidden-xs hidden-sm temp-hidden-related-video' : '' }}">
                  <a class="overlay" href="{{ route('video.watch') }}?v={{ $video->id }}"></a>
                  @include('video.singleShowRelated', ['source' => 'video'])
                </div>
              @endforeach

            @else
              @foreach ($related as $video)
                <div class="col-xs-2 related-video-width {{ $loop->iteration > 30 ? 'hidden-xs hidden-sm temp-hidden-related-video' : '' }}" style="padding: 0px 4px;">

                  <a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video->id }}">
                    <div class="home-rows-videos-div" style="position: relative; display: inline-block; margin-bottom:15px;">
                      <img style="width: 100%; border-radius: 3px" src="{{ $video->cover }}">
                      <div class="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 3px 3px; background: linear-gradient(to bottom, transparent 0%, black 120%); font-weight: normal;">{{ str_replace('[新番預告]', '', $video->title) }}</div>
                    </div>
                  </a>

                </div>
              @endforeach
            @endif
        </div>
        <div class="load-more-related-btn related-watch-wrap hidden-md hidden-lg" style="margin-left: -2px; margin-right: -2px; font-weight: 400 !important; margin-top: 0px; {{ $doujin ? 'margin-top: 5px' : ''}}">更多相關影片</div>
      </div>

      <div id="comment-tabcontent" class="tabcontent" style="margin-top: 85px">
        <div id="comment-section-wrapper" class="video-show-comment-width">
          <div id="ajax-loading" style="text-align: center; padding-bottom: 1000px;">
            <img style="width: 40px;" src="https://i.imgur.com/wgOXAy6.gif"/>
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
            @include('layouts.exoclick', ['id' => '4372438', 'width' => '300', 'height' => '250'])
          </div>
        </div>
      @else
        <div id="double-banners-adjust" style="margin-top: -8px;">
          @include('ads.watch-double-banners')
        </div>
        <div id="watch-footer">
          <div style="background-color: #212121;">
            <div class="hentai-footer">
              <p>Hanime1.me 帶給你最新最全的無碼高清中文字幕Hentai成人動漫線上看。我們提供最優質的色情H動漫裏番，並以最高畫質720p / 1080p呈現。我們的18禁H動畫網站適用於手機設備，讓您免費線上看H動漫、H動畫、裏番，更有中文字幕，不必再聽日語猜故事！這個網站是繼avbebe之後，亞洲最優質的色情工口Hentai成人動漫，並且有許多Hentai分類，包括顏射、乳交、口交、熟女、學生妹、中出、百合、肛交，以及更多！</p>

              <p>Hentai是什麼？Hentai（変態 或 へんたい），Hentai 或 成人動漫的詞源來自日本，並指色情或成人動漫和動畫，特別是來自日本的18禁H動漫和成人動畫。</p>
            </div>
          </div>
          <div style="padding: 15px;">
            <h2 style="color: white; font-weight: bold; margin-top: 0px"><span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me</h2>
            <div style="display: inline-block"><a style="color: gray" href="/about">關於</a></div> - 
            <div style="display: inline-block"><a style="color: gray" href="/contact">廣告</a></div> - 
            <div style="display: inline-block"><a style="color: gray" href="/contact">聯絡</a></div> - 
            <div style="display: inline-block"><a style="color: gray" href="/terms">服務條款</a></div> - 
            <div style="display: inline-block"><a style="color: gray" href="/policies">社群規範</a></div> - 
            <div style="display: inline-block"><a style="color: gray" href="/copyright">版權申訴</a></div> - 
            <div style="display: inline-block"><a style="color: gray" href="/copyright">DMCA</a></div> - 
            <div style="display: inline-block"><a style="color: gray" href="/2257">2257</a></div> - 
            <div style="display: inline-block"><a style="color: gray" href="#">{{ gethostname() }}</a></div>
          </div>
        </div>
      @endif

    </div>

    <div class="col-md-3 single-show-list">
      <div class="hidden-xs hidden-sm" style="text-align: left; padding-left: 5px; padding-top: 5px; margin-top: 0px; margin-bottom: 15px; padding-bottom: 0px; width: 310px; height: 282px; background-color: #3a3c3f;">
        <div style="margin-bottom: 5px; color: white; font-size: 12px;">點點廣告，贊助我們（●´∀｀）ノ♡</div>
        @include('layouts.exoclick', ['id' => '4372438', 'width' => '300', 'height' => '250'])
      </div>

      <div class="hidden-xs hidden-sm">
        @include('video.playlist-panel')
      </div>

      <div id="myHeader" class="hidden-xs hidden-sm">
        <div style="text-align: left; padding-left: 5px; padding-top: 5px; margin-top: 15px; margin-bottom: 10px; padding-bottom: 0px; width: 310px; height: 282px; background-color: #3a3c3f;">
          <div style="margin-bottom: 5px; color: white; font-size: 12px;">點點廣告，贊助我們（●´∀｀）ノ♡</div>
          @include('layouts.exoclick', ['id' => '4372438', 'width' => '300', 'height' => '250'])
        </div>

        <div style="text-align: left; padding-left: 5px; padding-top: 5px; margin-top: 15px; margin-bottom: 10px; padding-bottom: 0px; width: 310px; height: 282px; background-color: #3a3c3f;">
          <div style="margin-bottom: 5px; color: white; font-size: 12px;">點點廣告，贊助我們（●´∀｀）ノ♡</div>
          <!-- JuicyAds v3.1 -->
          <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
          <ins id="940485" data-width="300" data-height="262"></ins>
          <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':940485});</script>
          <!--JuicyAds END-->
        </div>
      </div>
    </div>
  </div>

  @if (!$is_mobile)
    <div id="bottom-ads" style="margin-top: 30px; margin-bottom: 0px; text-align: center;" class="hidden-xs hidden-sm">
      @include('layouts.exoclick', ['id' => '4372454', 'width' => '900', 'height' => '250'])
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