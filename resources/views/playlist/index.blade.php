@extends('layouts.app')

@section('nav')
  @include('nav.main')
@endsection

@section('content')

<div class="nav-bottom-padding home-content-wrapper">

  <div style="position: relative; margin-top: 0px; padding-top: 100px;">

    <div class="content-padding-new playlist-rows-top">
      <a class="home-rows-header" style="text-decoration: none;" href="{{ route('playlist.show') }}?list=WL">
        <h5 style="color: #8e9194;">儲存</h5>
        <h3 style="font-weight: 700; color: #edeeef; margin-bottom: 20px;">稍後觀看</h3>
        @include('layouts.home-row-arrow')
      </a>
    </div>
    <div class="owl-home-row owl-carousel owl-theme">
      @foreach ($saves as $save)
        @if ($save->video)
          <a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $save->video->id }}" class="hover-opacity">
            <div class="home-rows-videos-div" style="position: relative; display: inline-block; margin-bottom:50px;">
              <div style="position: relative;">
                <img src="{{ $save->video->cover }}">
                @if (strpos($save->video->cover, 'E6mSQA2') !== false)
                  <img style="position: absolute; top: 0; left: 0; height: 100%; object-fit: cover" src="{{ $save->video->thumbL() }}">
                @endif
              </div>
              <div class="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 2px 5px; background: linear-gradient(to bottom, transparent 0%, black 120%);">{{ $save->video->title }}</div>
            </div>
          </a>
        @endif
      @endforeach
    </div>

    <div class="content-padding-new playlist-rows" style="{{ $likes == '[]' ? 'margin-top: 0px;' : '' }}">
      <a class="home-rows-header" style="text-decoration: none;" href="{{ route('playlist.show') }}?list=LL">
        <h5 style="color: #8e9194;">讚好</h5>
        <h3 style="font-weight: 700; color: #edeeef; margin-bottom: 20px;">喜歡的影片</h3>
        @include('layouts.home-row-arrow')
      </a>
    </div>
    <div class="owl-home-row owl-carousel owl-theme">
      @foreach ($likes as $like)
        @if ($like->video)
          <a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $like->video->id }}" class="hover-opacity">
            <div class="home-rows-videos-div" style="position: relative; display: inline-block; margin-bottom:50px;">
              <div style="position: relative;">
                <img src="{{ $like->video->cover }}">
                @if (strpos($like->video->cover, 'E6mSQA2') !== false)
                  <img style="position: absolute; top: 0; left: 0; height: 100%; object-fit: cover" src="{{ $like->video->thumbL() }}">
                @endif
              </div>
              <div class="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 2px 5px; background: linear-gradient(to bottom, transparent 0%, black 120%);">{{ $like->video->title }}</div>
            </div>
          </a>
        @endif
      @endforeach
    </div>

    <div class="content-padding-new playlist-rows" style="{{ $playlists == '[]' ? 'margin-top: 0px;' : '' }}">
      <a class="home-rows-header" style="text-decoration: none;">
        <h5 style="color: #8e9194;">分類</h5>
        <h3 style="font-weight: 700; color: #edeeef; margin-bottom: 20px;">播放清單</h3>
        <span id="show-more-playlists-btn" style="cursor: pointer;">@include('layouts.home-row-arrow')</span>
      </a>
      <div class="row no-gutter" style="margin: 0 -5px;">
        @foreach ($playlists as $playlist)
          @if ($video = $playlist->reference_id ? $playlist->videos_ref->first() : $playlist->videos->first())
            <div class="hover-lighter card-mobile-panel single-playlist-wrapper col-xs-6 col-sm-4 col-md-2 col-lg-2 {{ $loop->iteration > 10 ? 'hidden temp-hidden-playlists' : '' }}">
              <a href="{{ route('playlist.show') }}?list={{ $playlist->reference_id ? $playlist->reference_id : $playlist->id }}" style="text-decoration: none;">
                <div style="position: relative;">
                  <img style="width: 100%;" src="https://cdn.jsdelivr.net/gh/guaishushukanlifan/Project-H@latest/asset/thumbnail/2jSdwcGl.jpg">
                  <img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;" src="{{ $video->thumbL() }}">

                  <div style="position: absolute; top: 0; right: 0; height: 100%; background-color: rgba(0,0,0,0.8); width: 45%; text-align: center; color: white;">
                    <div style="position: relative; top: 50%; transform: translateY(-50%);">
                      <div style="margin-bottom: 12px; font-size: 16px; font-weight: bold;">{{ $playlist->reference_id ? $playlist->videos_ref_count : $playlist->videos_count }}</div>
                      <img style="height: 15px; width: auto; display: block; margin-left: auto; margin-right: auto;" src="https://i.imgur.com/9Czw9s5.png">
                    </div>
                  </div>
                </div>
              </a>

              <div style="margin-top: 6px; padding: 0 8px;">
                <div style="text-decoration: none; color: black;">
                  <a href="{{ route('playlist.show') }}?list={{ $playlist->reference_id ? $playlist->reference_id : $playlist->id }}" style="text-decoration: none; font-size: inherit;">
                    <div class="card-mobile-title">{{ $playlist->playlist_ref ? $playlist->playlist_ref->title : $playlist->title }}</div>
                  </a>

                  <div class="card-mobile-genre-wrapper">
                    <span class="card-mobile-genre-new" style="color: rgba(242, 38, 19, 1); border-color: rgba(242, 38, 19, 0.30);">清單</span>
                    <div style="font-size: 12px; color: dimgray; margin-left: 2px; display: inline-block;" class="card-mobile-user">{{ $playlist->user_ref ? $playlist->user_ref->name : $playlist->user->name }}</div>
                  </div>
                </div>
              </div>
            </div>

          @else

            <div class="hover-lighter card-mobile-panel single-playlist-wrapper col-xs-6 col-sm-4 col-md-2 col-lg-2 {{ $loop->iteration > 10 ? 'hidden temp-hidden-playlists' : '' }}">
              <a href="{{ route('playlist.show') }}?list={{ $playlist->reference_id ? $playlist->reference_id : $playlist->id }}" style="text-decoration: none;">
                <div style="position: relative;">
                  <img style="width: 100%;" src="https://cdn.jsdelivr.net/gh/guaishushukanlifan/Project-H@latest/asset/thumbnail/2jSdwcGl.jpg">
                  <img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;" src="https://i.imgur.com/qLIoSzml.png">

                  <div style="position: absolute; top: 0; right: 0; height: 100%; background-color: rgba(0,0,0,0.8); width: 45%; text-align: center; color: white;">
                    <div style="position: relative; top: 50%; transform: translateY(-50%);">
                      <div style="margin-bottom: 12px; font-size: 16px; font-weight: bold;">0</div>
                      <img style="height: 15px; width: auto; display: block; margin-left: auto; margin-right: auto;" src="https://i.imgur.com/9Czw9s5.png">
                    </div>
                  </div>
                </div>
              </a>

              <div style="margin-top: 6px; padding: 0 8px;">
                <div style="text-decoration: none; color: black;">
                  <a href="{{ route('playlist.show') }}?list={{ $playlist->reference_id ? $playlist->reference_id : $playlist->id }}" style="text-decoration: none; font-size: inherit;">
                    <div class="card-mobile-title">{{ $playlist->title }}</div>
                  </a>

                  <div class="card-mobile-genre-wrapper">
                    <span class="card-mobile-genre-new" style="color: rgba(242, 38, 19, 1); border-color: rgba(242, 38, 19, 0.30);">清單</span>
                    <div style="font-size: 12px; color: dimgray; margin-left: 2px; display: inline-block;" class="card-mobile-user">{{ $playlist->reference_user_id ? $playlist->user_ref->name : $playlist->user->name }}</div>
                  </div>
                </div>
              </div>
            </div>

          @endif
        @endforeach
      </div>
    </div>

    @include('ads.search-banner-panel')

    <div class="hidden-sm hidden-md hidden-lg" style="text-align: center; margin-bottom: 10px; margin-top: 10px">
      <!-- JuicyAds v3.1 -->
      <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
      <ins id="941419" data-width="300" data-height="112"></ins>
      <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':941419});</script>
      <!--JuicyAds END-->
    </div>

    <div class="hidden-xs"><br><br><br></div>
    <div class="hidden-xs hidden-md hidden-lg"><br></div>

  </div>

</div>

@include('layouts.nav-bottom')

<script>
  var padding = $(window).width() * 0.04;
  var mobile_padding = 10;
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
              stagePadding: padding,
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

  $('.owl-home-uncover-last-row').owlCarousel({
      loop: false,
      margin: 10,
      responsive:{
          0:{
              items:2
          },
          768:{
              items:3
          },
          992:{
              items:4
          },
          1200:{
            items:5
          }
      }
  })
</script>

@endsection