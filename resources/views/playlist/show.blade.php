@extends('layouts.app')

@section('head')
    @parent
		<title>{{ $title }}&nbsp;-&nbsp;H動漫/裏番/線上看&nbsp;-&nbsp;Hanime1.me</title>
		<meta name="title" content="{{ $title }} - H動漫/裏番/線上看 - Hanime1.me">
		<meta name="description" content="{{ $title }} - H動漫/裏番/線上看 - Hanime1.me">
@endsection

@section('nav')
  @include('nav.main')
@endsection

@section('content')

<div class="nav-bottom-padding home-content-wrapper">

  <div style="position: relative; margin-top: 0px; padding-top: 100px;">

    <div class="content-padding-new playlist-rows-top">
      <a class="home-rows-header" style="text-decoration: none;">
        <h5 id="playitems-count" data-count="{{ $count }}" style="color: #8e9194;">{{ $count }} 部影片</h5>
        <h3 style="font-weight: 700; color: #edeeef; margin-bottom: 20px;">{{ $title }}</h3>
      </a>

      @if ($editable)
	      <button class="no-select playlist-show-btn playlist-show-edit-btn" style="margin-right: 3px;">
	        <span id="playlist-show-edit-btn-icon" style="vertical-align: middle; font-size: 25px; margin-top: -5px; margin-right: 5px; cursor: pointer;" class="material-icons-outlined">edit_note</span><span id="playlist-show-edit-btn-text">編輯影片</span>
	      </button>

	    @else
	      <button class="no-select playlist-show-btn" style="opacity: 0.5; margin-right: 3px;">
	        <span style="vertical-align: middle; font-size: 18px; margin-top: -5px; margin-right: 5px; cursor: pointer;" class="material-icons">edit</span>儲存清單
	      </button>
	    @endif

      <button class="no-select playlist-show-btn" style="background-color: transparent; color: white; margin-left: 4px; margin-right: -1px; outline: 0;" data-toggle="modal" data-target="#shareModal">
        <span style="vertical-align: middle; font-size: 18px; margin-top: -3px; margin-right: 5px; cursor: pointer;" class="material-icons">share</span>分享
      </button>
    </div>

    <div id="home-rows-wrapper" style="position: relative; margin-top: 0px;">
    	<div class="home-rows-videos-wrapper" style="white-space: normal; margin-left: -2px; margin-right: -2px;">
				@foreach ($results as $save)
					@if ($save->video)
						@include('playlist.video-card-edit', ['video' => $save->video])
					@endif
				@endforeach
			</div>
    </div>

    <div class="{{ $doujin ? 'search-doujin-pagination-desktop-margin' : 'search-hentai-pagination-desktop-margin' }} search-pagination hidden-xs">{!! $results->appends(request()->query())->links() !!}</div>
		<div style="{{ $doujin ? 'margin-top: -26px;' : 'margin-top: -29px;' }}" class="search-pagination mobile-search-pagination hidden-sm hidden-md hidden-lg">{!! $results->appends(request()->query())->onEachSide(1)->links() !!}</div>

		@include('ads.search-banner-panel')

		<div class="hidden-sm hidden-md hidden-lg" style="text-align: center; margin-bottom: -40px; {{ $results->lastPage() == 1 ? 'margin-top: 32px' : 'margin-top: -12px' }}">
			<!-- JuicyAds v3.1 -->
			<script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
			<ins id="941419" data-width="300" data-height="112"></ins>
			<script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':941419});</script>
			<!--JuicyAds END-->
		</div>

		<div class="hidden-xs"><br><br><br></div>
    <div class="hidden-xs hidden-md hidden-lg"><br></div>
    <div class="hidden-sm hidden-md hidden-lg"><br><br></div>

  </div>

</div>

@include('video.shareModal')
@include('layouts.nav-bottom')

@endsection