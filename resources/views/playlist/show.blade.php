@extends('layouts.app')

@section('nav')
  @include('nav.main')
@endsection

@section('content')

<div class="nav-bottom-padding home-content-wrapper">

  <div style="position: relative; margin-top: 0px; padding-top: 100px;">

    <div class="content-padding-new playlist-rows-top">
      <a class="home-rows-header" style="text-decoration: none;" href="{{ route('playlist.index') }}">
        <h5 style="color: #8e9194;">{{ $sub }}</h5>
        <h3 style="font-weight: 700; color: #edeeef; margin-bottom: 20px;">{{ $title }}</h3>
        @include('layouts.home-row-arrow')
      </a>

      @if ($editable)
	      <button class="no-select" style="background-color: crimson; border: 1px solid crimson; color: #d9d9d9; border-radius: 3px; padding: 9px 20px 9px 18px; opacity: 0.5; filter: alpha(opacity=50); margin-right: 1px; margin-bottom: 25px;">
	        <span style="vertical-align: middle; font-size: 18px; margin-top: -5px; margin-right: 5px; cursor: pointer;" class="material-icons">edit</span>編輯
	      </button>
	      <button class="no-select" style="background-color: #4d4d4d; border: 1px solid #4d4d4d; color: #d9d9d9; border-radius: 3px; padding: 9px 20px 9px 18px; opacity: 0.5; filter: alpha(opacity=50); margin-right: 1px; margin-bottom: 25px;">
	        <span style="vertical-align: middle; font-size: 18px; margin-top: -4px; margin-right: 5px; cursor: pointer;" class="material-icons">share</span>分享
	      </button>
	      <button class="no-select" style="background-color: transparent; border: 1px solid dimgray; color: #d9d9d9; border-radius: 3px; padding: 9px 20px 9px 18px; opacity: 0.5; filter: alpha(opacity=50); margin-right: 1px; margin-bottom: 25px;">
	        <span style="vertical-align: middle; font-size: 20px; margin-top: -5px; margin-right: 5px; cursor: pointer;" class="material-icons">delete_outline</span>刪除
	      </button>
      @endif
    </div>
    <div id="home-rows-wrapper" style="position: relative; margin-top: 0;">
    	<div class="home-rows-videos-wrapper" style="white-space: normal; margin-left: -2px; margin-right: -2px;">
			@foreach ($results as $save)
				@if ($save->video)
					@include('playlist.video-card', ['video' => $save->video])
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

@include('layouts.nav-bottom')

@endsection