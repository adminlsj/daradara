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
      @if ($video->outsource)
        <div style="background-color: black; background-image: url('https://i.imgur.com/zXoBhXA.gif'); background-position: center; background-repeat: no-repeat; background-size: 150px; position: relative; width: 100%; height: 0; padding-bottom: 56.25%;">
            <iframe src="{!! $video->sd !!}" style="border: 0; overflow: hidden; position: absolute; width: 100%; height: 100%; left: 0; top: 0;" allowfullscreen></iframe>
        </div>

      @else
        @if (strpos($video->sd, '.m3u8') !== false)
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

      @if ($video->comic_id)
        <a id="watch-comics-link-btn" href="{{ route('comic.showCover', ['comic' => $video->comic_id]) }}" target="_blank" class="no-select" style="background-color: crimson; border: none; border-radius: 5px; color: #d9d9d9; display: block; text-decoration: none; cursor: pointer;">
          <span style="vertical-align: middle; font-size: 18px; margin-top: -3px; margin-right: 5px; cursor: pointer;" class="material-icons">visibility</span>漫畫原作
        </a>
      @endif

      <div class="video-show-panel-width">
        <div style="margin-bottom: -6px;">
          <p style="font-size: 12px; color: #bdbdbd; font-weight: 500">{{ Carbon\Carbon::parse($video->created_at)->format('Y-m-d') }} <span style="font-weight: normal;">&nbsp;|&nbsp;</span> {{ $video->views() }}次點閱</p>
        </div>

        <h3 id="shareBtn-title" style="line-height: 30px; font-weight: bold; font-size: 1.5em; margin-top: 0px; color: white;">{{ $video->translations['JP'] }}</h3>

        <h5 id="caption" style="color: #bdbdbd; font-weight: 400; margin-top: 10px; line-height: 20px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;"><span style="color: white; font-weight: bold">{{ $video->title }}</span>&nbsp;&nbsp;{{ $video->caption }}</h5>

        <h5 id="show-more-caption" class="no-select" style="margin-bottom: 25px; color: #fff; font-weight: 400; font-size: 12px; cursor: pointer;">顯示完整資訊</h5>

        <h5 style="font-weight: 400; margin-bottom: 0px; margin-top: 0px;">
          @foreach ($tags as $tag)
              <div class="single-video-tag"><a href="/search?tags%5B%5D={{ $tag }}{{ $doujin ? '' : '&genre=H動漫' }}">{{ $tag }}</a></div>
          @endforeach
          <div class="single-video-tag" data-toggle="modal" data-target="{{ Auth::check() ? '#add-tags-modal' : '#signUpModal' }}" style="position: relative; cursor: pointer; "><a style="padding-left: 15px; padding-right: 15px;"><span class="material-icons" style="position: absolute; margin-left: auto; margin-right: auto; left: -3px; right: 0; text-align: center; margin-top: -4px; font-size: 22px; vertical-align: middle">add</span></a></div>
          <div class="single-video-tag" data-toggle="modal" data-target="{{ Auth::check() ? '#remove-tags-modal' : '#signUpModal' }}" style="position: relative; cursor: pointer; "><a style="padding-left: 15px; padding-right: 15px;"><span class="material-icons" style="position: absolute; margin-left: auto; margin-right: auto; left: -2px; right: 0; text-align: center; margin-top: -4px; font-size: 22px; vertical-align: middle">remove</span></a></div>
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

        @if ($video->qualities == null)
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
        <button id="comment-tablink" data-videoid="{{ $current->id }}" data-tabcontent="comment-tabcontent" class="tablinks">評論&nbsp;&nbsp;<span id="tab-comments-count" style="color: white; background-color: red; font-size: 12px; border-radius: 10px; padding: 1px 5px">{{ $comments_count }}</span></button>
      </div>

      <!-- Tab content -->
      <div id="related-tabcontent" class="tabcontent mobile-padding" style="margin-top: 85px">
        <div class="row {{ $doujin ? 'doujin-row' : '' }}" style="margin: 0px -2px;">
            @if ($doujin)
              @if ($is_mobile)
                <div style="margin-top: -20px;">
                  @foreach ($related as $video)
                    <span style="padding: 0 15px;" class="related-video-width-horizontal {{ $loop->iteration > 30 ? 'hidden-xs hidden-sm temp-hidden-related-video' : '' }}">
                      @include('video.card-mobile')
                    </span>
                  @endforeach
                </div>
              @else
                @foreach ($related as $video)
                  <span class="related-video-width-horizontal {{ $loop->iteration > 30 ? 'hidden-xs hidden-sm temp-hidden-related-video' : '' }}">
                    @include('video.card-desktop')
                  </span>
                @endforeach
              @endif

            @else
              @foreach ($related as $video)
                <div class="col-xs-2 hover-opacity-all related-video-width {{ $loop->iteration > 30 ? 'hidden-xs hidden-sm temp-hidden-related-video' : '' }}" style="padding: 0px 2px;">
                  <a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video->id }}">
                    <div class="home-rows-videos-div" style="position: relative; display: inline-block; margin-bottom:15px">
                      <img style="width: 100%" src="{{ $video->cover }}">
                      <div class="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 3px 3px; background: linear-gradient(to bottom, transparent 0%, black 120%);">{{ $video->title }}</div>
                      </div>
                  </a>
                </div>
              @endforeach
            @endif
        </div>
        <div class="load-more-related-btn related-watch-wrap hidden-md hidden-lg" style="font-weight: 400 !important; margin-top: 0px;">更多相關影片</div>
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

  <div id="bottom-ads" style="margin-top: 30px; margin-bottom: 0px; text-align: center;" class="hidden-xs hidden-sm">
    @include('layouts.exoclick', ['id' => '4372454', 'width' => '900', 'height' => '250'])
  </div>

  @include('video.userReportModal')
  @include('video.shareModal')
  @if (!Auth::check())
    @include('user.signUpModal')
    @include('user.loginModal')
  @else
    <script src="https://js.hcaptcha.com/1/api.js" async defer></script>
    @include('video.add-tags-modal')
    @include('video.remove-tags-modal')
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