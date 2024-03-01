@extends('layouts.app')

@section('nav')
  @include('nav.main')
@endsection

@section('content')

<div class="nav-bottom-padding home-content-wrapper">

  <div style="position: relative; margin-top: 0px;">

    <div class="hidden-md hidden-lg" style="text-align: center; margin-top: 72px; margin-bottom: -205px">
      <a href="{{ route('user.edit', Auth::user()) }}" style="text-decoration: none;">
        <img style="width: 70px; border-radius: 10px;" src="{{ $user->avatar_temp }}">
        <div style="font-size: 21px; font-weight: bolder; color: white; margin-top: 2px">{{ $user->name }}<img style="margin-top: -3px; margin-left: 7px; width: 15px;" src="https://vdownload.hembed.com/image/icon/arrow_down.png?secure=2CKFWyW8NLKoTjn7Szq8lw==,4855470564"></div>
      </a>
    </div>

    <div id="home-rows-wrapper" class="playlist-rows-wrapper" style="position: relative;">
      @include('playlist.card-wrapper', ['title' => '稍後觀看', 'videos' => $saves, 'link' => route('playlist.show').'?list=WL'])
      @include('playlist.card-wrapper', ['title' => '喜歡的影片', 'videos' => $likes, 'link' => route('playlist.show').'?list=LL'])
      @include('layouts.card-wrapper', ['title' => '訂閱內容', 'videos' => $subscribes, 'link' => route('playlist.show').'?list=LL'])
      @include('playlist.card-wrapper-artist', ['title' => '訂閱的作者', 'artists' => $artists, 'link' => route('playlist.show').'?list=LL'])

      <a style="text-decoration: none;">
        <h3>播放清單<span class="hidden-xs show-more-playlists-btn" style="cursor: pointer;"><span style="vertical-align: middle; margin-top: -8px; margin-left: 0px; font-size: 25px; margin-bottom: -5px;" class="material-icons">chevron_right</span></span></h3>
      </a>
      <div class="content-padding-new">
        <div class="row no-gutter" style="margin: 0 -5px;">
          @foreach ($playlists as $playlist)
            @if ($video = $playlist->reference_id ? $playlist->videos_ref->first() : $playlist->videos->first())
              <div class="hover-lighter card-mobile-panel single-playlist-wrapper col-xs-6 col-sm-4 col-md-2 col-lg-2 {{ $loop->iteration > 10 ? 'hidden temp-hidden-playlists' : '' }}">
                <a href="{{ route('playlist.show') }}?list={{ $playlist->reference_id ? $playlist->reference_id : $playlist->id }}" style="text-decoration: none;">
                  <div style="position: relative;">
                    <img style="width: 100%;" src="https://vdownload.hembed.com/image/icon/card_doujin_background.jpg?secure=sJRJ4-aVOQw4IVZasq7YZw==,4853041705">
                    <img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;" src="{{ $video->thumbL() }}">

                    <div style="position: absolute; top: 0; right: 0; height: 100%; background-color: rgba(0,0,0,0.8); width: 45%; text-align: center; color: white;">
                      <div style="position: relative; top: 50%; transform: translateY(-50%);">
                        <div style="margin-bottom: 12px; font-size: 16px; font-weight: bold;">{{ $playlist->reference_id ? $playlist->videos_ref_count : $playlist->videos_count }}</div>
                        <img style="height: 15px; width: auto; display: block; margin-left: auto; margin-right: auto;" src="https://vdownload.hembed.com/image/icon/playlist_cover.png?secure=ktsUJLHvpLX-SgpG1dXpHg==,4855472424">
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
                    <img style="width: 100%;" src="https://vdownload.hembed.com/image/icon/card_doujin_background.jpg?secure=sJRJ4-aVOQw4IVZasq7YZw==,4853041705">
                    <img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;" src="https://vdownload.hembed.com/image/icon/playlist_placeholder.jpg?secure=FlykN_6gYfRx7TTbr20AKQ==,4855472554">

                    <div style="position: absolute; top: 0; right: 0; height: 100%; background-color: rgba(0,0,0,0.8); width: 45%; text-align: center; color: white;">
                      <div style="position: relative; top: 50%; transform: translateY(-50%);">
                        <div style="margin-bottom: 12px; font-size: 16px; font-weight: bold;">0</div>
                        <img style="height: 15px; width: auto; display: block; margin-left: auto; margin-right: auto;" src="https://vdownload.hembed.com/image/icon/playlist_cover.png?secure=ktsUJLHvpLX-SgpG1dXpHg==,4855472424">
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
        <div class="load-more-related-btn related-watch-wrap show-more-playlists-btn hidden-sm hidden-md hidden-lg" style="font-weight: bold !important; margin-top: 0px; margin-bottom: 30px;">更多播放清單</div>
      </div>
    </div>

    @include('ads.search-banner-panel')

    <div class="hidden-sm hidden-md hidden-lg" style="text-align: center; margin-bottom: 25px; margin-top: 10px">
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

@endsection