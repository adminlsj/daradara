@extends('layouts.app')

@section('nav')
	@include('jav.nav-home')
@endsection

@section('content')

<div class="nav-bottom-padding">
	<div class="hidden-xs" style="position: relative;">
		<div id="main-nav-home" style="z-index: 10000 !important; position: absolute;">
		  @include('jav.nav-main-content')
		</div>
		<script>
			var targetOffset = $("#main-nav-home").offset().top;
			var $window = $(window).scroll(function(){
			    if ( $window.scrollTop() > targetOffset ) {   
			      $("#main-nav-home").css({"position":"fixed", 'background-color':'#141414'});
			    } else {
			      $("#main-nav-home").css({"position":"absolute", 'background-color':'transparent'});
			    }
			});
		</script>

		<div style="position: relative;">
			<img style="width: 100%; height: 100vh; object-position: center 0px; object-fit: cover; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0.3)));" src="https://i.imgur.com/{{ $random->foreign_sd['thumbnail'] }}h.jpg" alt="{{ $random->title }}">
			<img style="width: 100%; height: 100vh; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0.3))); position: absolute; top: 0; left: 0; object-position: center 0px; object-fit: cover;" src="https://i.imgur.com/{{ $random->foreign_sd['thumbnail'] }}h.jpg" alt="{{ $random->title }}">
	    </div>
		<div id="home-banner-wrapper" style="position: absolute; left: 4%; bottom: 31%; color: white">
			<h3 style="font-weight: bold"><span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me</h3>
			<h1 style="margin: 0; font-weight: bold;">{{ $random->title }}</h1>
			<h4 class="hidden-xs">{{ str_replace(' [中文字幕]', '', $random->translations['JP']) }} • 中文字幕 • {{ $random->caption }}</h4>
			<a href="{{ route('jav.watch') }}?v={{ $random->id }}" target="_blank" style="display: inline-block; padding: 10px 30px 6px 20px; margin-top: -8px; margin-bottom: -10px" class="hover-opacity-all home-banner-btn home-banner-play-btn play-btn"><span style="vertical-align: middle; font-size: 2em; margin-top: -4px; padding-right: 5px" class="material-icons">play_arrow</span>播放</a>
			&nbsp;
			<a href="{{ route('jav.watch') }}?v={{ $random->id }}" class="hover-opacity-all home-banner-btn home-banner-info-btn"><span style="vertical-align: middle; font-size: 1.7em; margin-top: -2px; padding-right: 7px" class="material-icons">info</span>更多資訊</a>
		</div>
	</div>

	<div class="hidden-sm hidden-md hidden-lg" style="position: relative;">
		<div style="position: relative;">
			<img style="width: 100%;" src="https://cdn.jsdelivr.net/gh/jokogebai/jokogebai@v1.0.0/home_poster_background.jpg">
			<img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-position: center 0px; object-fit: cover; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0)));" src="{{ $random->cover }}">
	    </div>
		<div style="position: absolute; left: 50%; -webkit-transform: translateX(-50%); transform: translateX(-50%); width: 96%; bottom: 14%; text-align: center; color: white">
			<h3 style="font-weight: bold; font-size: 20px;"><span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me</h3>
			<h1 style="font-size: 28px; font-weight: bold; margin: 0; line-height: 35px; margin-top: -2px; margin-bottom: -2px">{{ $random->title }}</h1>
			<h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; line-height: 16px; font-size: 12px; width: 92%; margin-left: 4%;">{{ str_replace(' [中文字幕]', '', $random->translations['JP']) }} • 中文字幕 • {{ $random->caption }}</h4>
			<div style="margin-top: 15px; width: 100%">
				<div style="display: inline-block; margin-top: 5px;">
					<a href="{{ route('jav.watch') }}?v={{ $random->id }}" class="hover-opacity-all home-banner-btn home-banner-play-btn play-btn" target="_blank" style="cursor: pointer; font-size: 14px; border-radius: 3px; text-decoration: none; background-color: white; padding: 8px 22px 8px 12px; color: black;"><span style="vertical-align: middle; font-size: 2em; margin-top: -3px; padding-right: 3px" class="material-icons">play_arrow</span>播放</a>
				</div>
				<div style="display: inline-block; margin-top: 5px; padding-left: 2px;">
					<a href="{{ route('jav.watch') }}?v={{ $random->id }}" class="hover-opacity-all home-banner-btn home-banner-info-btn" style="cursor: pointer; font-size: 14px; border-radius: 3px; text-decoration: none; background-color: rgba(109, 109, 110, 0.7); padding: 8px 21px 8px 17px; color: white;"><span style="vertical-align: middle; font-size: 1.66em; margin-top: -3px; padding-right: 4px" class="material-icons">info</span>更多資訊</a>
				</div>
			</div>
		</div>
	</div>

	<div id="home-rows-wrapper" class="jav-home-rows-wrapper" style="position: relative;">
		@include('jav.card-wrapper-doujin', ['title' => '最新JAV', 'videos' => $最新JAV, 'link' => route('jav.search').'?genre=日本AV'])
		@include('jav.card-wrapper-doujin', ['title' => '最新上市', 'videos' => $最新上市, 'link' => route('jav.search').'?sort=最新上市'])
		@include('jav.card-wrapper-doujin', ['title' => '最新上傳', 'videos' => $最新上傳, 'link' => route('jav.search').'?sort=最新上傳'])
		@include('jav.card-wrapper-doujin', ['title' => '中文字幕', 'videos' => $中文字幕, 'link' => route('jav.search').'?tags%5B%5D=中文字幕'])
		@include('jav.card-wrapper-doujin', ['title' => '他們在看', 'videos' => $他們在看, 'link' => route('jav.search').'?sort=他們在看'])

		<div>
			@include('ads.home-banner-exoclick', ['desktop_home_1' => '5016100', 'tablet_home_1' => '5016102', 'mobile_home_1' => '5016106'])
		</div>

		@include('jav.card-wrapper-doujin', ['title' => '素人業餘', 'videos' => $素人業餘, 'link' => route('jav.search').'?genre=素人業餘'])
		@include('jav.card-wrapper-doujin', ['title' => '高清無碼', 'videos' => $高清無碼, 'link' => route('jav.search').'?genre=高清無碼'])
		@include('jav.card-wrapper-doujin', ['title' => 'AI解碼', 'videos' => $AI解碼, 'link' => route('jav.search').'?genre=AI解碼'])
		@include('jav.card-wrapper-doujin', ['title' => '國產AV', 'videos' => $國產AV, 'link' => route('jav.search').'?genre=國產AV'])
		@include('jav.card-wrapper-doujin', ['title' => '國產素人', 'videos' => $國產素人, 'link' => route('jav.search').'?genre=國產素人'])

		<div>
			@include('ads.home-banner-juicyads', ['tablet_home_2' => '5016110'])
		</div>

		<div class="artist-row-desktop-margin">
			@include('jav.card-wrapper-artist', ['title' => '新加入作者', 'artists' => $新加入作者, 'link' => route('jav.search').'?type=artist&sort=加入日期'])
		</div>
		@include('jav.card-wrapper-doujin', ['title' => '本日排行', 'videos' => $本日排行, 'link' => route('jav.search').'?sort=本日排行'])
		@include('jav.card-wrapper-doujin', ['title' => '本月排行', 'videos' => $本月排行, 'link' => route('jav.search').'?sort=本月排行'])
		@include('jav.card-wrapper-doujin', ['title' => '觀看次數', 'videos' => $觀看次數, 'link' => route('jav.search').'?sort=觀看次數'])
		@include('layouts.card-wrapper-tag', ['title' => '影片標籤', 'videos' => $影片標籤, 'link' => route('jav.search')])
		
	</div>

	<div>
		@include('ads.home-banner-square', ['desktop_home_3' => '5016114', 'tablet_home_3' => '5016116', 'mobile_home_3' => '5016118'])
	</div>
</div>

@include('layouts.footer')

@include('jav.nav-bottom')

@endsection