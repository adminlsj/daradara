@extends('layouts.app')

@section('nav')
	@include('nav.home')
@endsection

@section('content')
<div class="nav-bottom-padding">
	<div class="hidden-xs" style="position: relative;">
		<div id="main-nav-home" style="z-index: 10000 !important; position: absolute;">
		  @include('nav.main-content')
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

		<img style="width: 100%; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0.3)));" src="{{ $random->imgur() }}" alt="{{ $random->title }}">
		<div id="home-banner-wrapper" style="position: absolute; left: 4%; color: white">
			<h3 style="font-weight: bold"><span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me</h3>
			<h1 style="margin: 0; font-weight: bold;">{{ $random->title }}</h1>
			<h4 class="hidden-xs">{{ str_replace(' [中文字幕]', '', $random->translations['JP']) }} • 中文字幕 • {{ $random->caption }}</h4>
			<a href="{{ route('video.watch') }}?v={{ $random->id }}" target="_blank" style="display: inline-block; padding: 10px 30px 6px 20px; margin-top: -8px; margin-bottom: -10px" class="hover-opacity-all home-banner-btn home-banner-play-btn play-btn"><span style="vertical-align: middle; font-size: 2em; margin-top: -4px; padding-right: 5px" class="material-icons">play_arrow</span>播放</a>
			&nbsp;
			<a href="{{ route('video.watch') }}?v={{ $random->id }}" class="hover-opacity-all home-banner-btn home-banner-info-btn"><span style="vertical-align: middle; font-size: 1.7em; margin-top: -2px; padding-right: 7px" class="material-icons">info</span>更多資訊</a>
		</div>
	</div>

	<div class="hidden-sm hidden-md hidden-lg" style="position: relative;">
		<div style="position: relative;">
			<img style="width: 100%;" src="https://i.imgur.com/MZfDigy.jpg">
			<img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-position: center 0px; object-fit: cover; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0)));" src="{{ $random->cover }}">
	    </div>
		<div style="position: absolute; left: 50%; -webkit-transform: translateX(-50%); transform: translateX(-50%); width: 96%; bottom: 14%; text-align: center; color: white">
			<h3 style="font-weight: bold; font-size: 20px;"><span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me</h3>
			<h1 style="font-size: 28px; font-weight: bold; margin: 0">{{ $random->title }}</h1>
			<h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; line-height: 16px; font-size: 12px; width: 92%; margin-left: 4%;">{{ str_replace(' [中文字幕]', '', $random->translations['JP']) }} • 中文字幕 • {{ $random->caption }}</h4>
			<div style="margin-top: 15px; width: 100%">
				<div style="display: inline-block; margin-top: 5px;">
					<a href="{{ route('video.watch') }}?v={{ $random->id }}" class="hover-opacity-all home-banner-btn home-banner-play-btn play-btn" target="_blank" style="cursor: pointer; font-size: 14px; border-radius: 3px; text-decoration: none; background-color: white; padding: 8px 22px 8px 12px; color: black;"><span style="vertical-align: middle; font-size: 2em; margin-top: -3px; padding-right: 3px" class="material-icons">play_arrow</span>播放</a>
				</div>
				<div style="display: inline-block; margin-top: 5px; padding-left: 2px;">
					<a href="{{ route('video.watch') }}?v={{ $random->id }}" class="hover-opacity-all home-banner-btn home-banner-info-btn" style="cursor: pointer; font-size: 14px; border-radius: 3px; text-decoration: none; background-color: gray; padding: 8px 21px 8px 17px; color: white; opacity: 0.8;"><span style="vertical-align: middle; font-size: 1.66em; margin-top: -3px; padding-right: 4px" class="material-icons">info</span>更多資訊</a>
				</div>
			</div>
		</div>
	</div>

	<div id="home-rows-wrapper" style="position: relative;">
		@include('layouts.card-wrapper', ['title' => '最新裏番', 'videos' => $最新裏番, 'link' => route('home.search').'?genre=裏番'])
		@include('layouts.card-wrapper-doujin', ['title' => '最新上市', 'videos' => $最新上市, 'link' => route('home.search').'?sort=最新上市'])
		@include('layouts.card-wrapper-doujin', ['title' => '最新上傳', 'videos' => $最新上傳, 'link' => route('home.search').'?sort=最新上傳'])
		@include('layouts.card-wrapper-doujin', ['title' => '中文字幕', 'videos' => $中文字幕, 'link' => route('home.search').'?tags%5B%5D=中文字幕'])
		@include('layouts.card-wrapper-doujin', ['title' => '他們在看', 'videos' => $他們在看, 'link' => route('home.search').'?sort=他們在看'])

		<div>
			@include('ads.home-banner-exoclick')
		</div>

		@include('layouts.card-wrapper', ['title' => '泡麵番', 'videos' => $泡麵番, 'link' => route('home.search').'?genre=泡麵番'])
		@include('layouts.card-wrapper-doujin', ['title' => 'Motion Anime', 'videos' => $Motion_Anime, 'link' => route('home.search').'?genre=Motion+Anime'])
		@include('layouts.card-wrapper-doujin', ['title' => '3D動畫', 'videos' => $SD動畫, 'link' => route('home.search').'?genre=3D動畫'])
		@include('layouts.card-wrapper-doujin', ['title' => '同人作品', 'videos' => $同人作品, 'link' => route('home.search').'?genre=同人作品'])
		@include('layouts.card-wrapper-doujin', ['title' => 'Cosplay', 'videos' => $Cosplay, 'link' => route('home.search').'?genre=Cosplay'])

		<div>
			@include('ads.home-banner-juicyads')
		</div>

		@include('layouts.card-wrapper', ['title' => '新番預告', 'videos' => $新番預告, 'link' => '/previews/'.Carbon\Carbon::now()->format('Ym')])
		<div class="artist-row-desktop-margin">
			@include('layouts.card-wrapper-artist', ['title' => '新加入作者', 'artists' => $新加入作者, 'link' => route('home.search').'?type=artist&sort=加入日期'])
		</div>
		@include('layouts.card-wrapper-doujin', ['title' => '本日排行', 'videos' => $本日排行, 'link' => route('home.search').'?sort=本日排行'])
		@include('layouts.card-wrapper-doujin', ['title' => '本月排行', 'videos' => $本月排行, 'link' => route('home.search').'?sort=本月排行'])
		@include('layouts.card-wrapper-tag', ['title' => '影片標籤', 'videos' => $影片標籤, 'link' => route('home.search')])
		
	</div>

	<div>
		@include('ads.home-banner-square')
	</div>

	<div style="background-color: #212121;">
		<div class="hentai-footer">
			<p>Hanime1.me 暗黑版 anime1.me 帶給你最新最全的無碼高清中文字幕Hentai成人H動漫。我們提供最優質的Hentai色情動漫裏番，並以最高畫質1080p呈現的Blu-ray rip。我們的18禁H漫網站適用於手機設備，並提供全網最優質的H動畫。最新最全的Hentai裏番資料庫，Hanime1.me hentai 讓你一個按鈕觀看所有Hentai成人動畫，包括最新的2020年Hentai成人動漫。在這裏，你可以找到最優質的中文字幕H動畫 24小時！免費享受hentai動漫，成人動畫，H動漫，並且更有中文字幕，不必再聽日語猜故事！這個網站是繼avbebe之後，亞洲最優質的色情工口H動漫，並且有許多Hentai分類，包括顏射、乳交、口交、熟女、學生妹、中出、百合、肛交，以及更多！</p>

			<p>Hentai是什麼？Hentai（変態 或 へんたい），Hentai 或 成人動漫的詞源來自日本，並指色情或成人動漫和動畫，特別是來自日本的18禁H動漫和成人動畫。</p>
		</div>
	</div>
</div>

@include('layouts.nav-bottom')

@endsection