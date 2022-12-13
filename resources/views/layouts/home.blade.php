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

		<img style="width: 100%; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0.3)));" src="https://cdn.jsdelivr.net/gh/guaishushukanlifan/Project-H@latest/asset/thumbnail/KzhJhsth.jpg" alt="逆轉魔女裁判 ～要被痴女魔女審判了～">
		<div id="home-banner-wrapper" style="position: absolute; left: 4%; color: white">
			<h3 style="font-weight: bold"><span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me</h3>
			<h1 style="margin: 0; font-weight: bold;">逆轉魔女裁判</h1>
			<h4 class="hidden-xs">逆転魔女裁判 • 中文字幕 • 魔女艶間薫憑著美貌和巨乳成為學園的女王，而常常跟蹤她的少年，相羽榮被認為是「狩獵魔女教會的爪牙」，因此被拘束並展開淫亂變態的「逆轉魔女裁判」...</h4>
			<a href="{{ route('video.watch') }}?v=13804" target="_blank" style="display: inline-block; padding: 10px 30px 6px 20px; margin-top: -8px; margin-bottom: -10px" class="hover-opacity-all home-banner-btn home-banner-play-btn play-btn"><span style="vertical-align: middle; font-size: 2em; margin-top: -4px; padding-right: 5px" class="material-icons">play_arrow</span>播放</a>
			&nbsp;
			<a href="{{ route('video.watch') }}?v=13804" class="hover-opacity-all home-banner-btn home-banner-info-btn"><span style="vertical-align: middle; font-size: 1.7em; margin-top: -2px; padding-right: 7px" class="material-icons">info</span>更多資訊</a>
		</div>
	</div>

	<div class="hidden-sm hidden-md hidden-lg" style="position: relative;">
		<img style="width: 100%; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0)));" src="https://cdn.jsdelivr.net/gh/guaishushukanlifan/Project-H@latest/asset/cover/HhP30zt.jpg">
		<div style="position: absolute; left: 50%; -webkit-transform: translateX(-50%); transform: translateX(-50%); width: 96%; bottom: 14%; text-align: center; color: white">
			<h3 style="font-weight: bold; font-size: 20px;"><span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me</h3>
			<h1 style="font-size: 28px; font-weight: bold; margin: 0">傲嬌公主</h1>
			<h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; line-height: 16px; font-size: 12px; width: 92%; margin-left: 4%;">OVA ツンプリ • 中文字幕 • 從刺客手中保護了國王的主角，不僅被賞賜了爆乳女僕濃厚&積極的服侍，更擄獲了擁有極上肉體的金髮傲嬌公主的芳心，三人過著甜蜜的性福生活！</h4>
			<div style="margin-top: 15px; width: 100%">
				<div style="display: inline-block; margin-top: 5px;">
					<a href="{{ route('video.watch') }}?v=13772" class="hover-opacity-all home-banner-btn home-banner-play-btn play-btn" target="_blank" style="cursor: pointer; font-size: 14px; border-radius: 3px; text-decoration: none; background-color: white; padding: 8px 22px 8px 12px; color: black;"><span style="vertical-align: middle; font-size: 2em; margin-top: -3px; padding-right: 3px" class="material-icons">play_arrow</span>播放</a>
				</div>
				<div style="display: inline-block; margin-top: 5px; padding-left: 2px;">
					<a href="{{ route('video.watch') }}?v=13772" class="hover-opacity-all home-banner-btn home-banner-info-btn" style="cursor: pointer; font-size: 14px; border-radius: 3px; text-decoration: none; background-color: gray; padding: 8px 21px 8px 17px; color: white; opacity: 0.8;"><span style="vertical-align: middle; font-size: 1.66em; margin-top: -3px; padding-right: 4px" class="material-icons">info</span>更多資訊</a>
				</div>
			</div>
		</div>
	</div>

	<div id="home-rows-wrapper" style="position: relative;">
		<a style="text-decoration: none;" href="/">
			<h3 style="padding-bottom: 3px; font-size: 22px">最新裏番</h3>
		</a>
		<div style="position: relative;">
			@include('layouts.card-navigate-before')
			<div class="home-rows-videos-wrapper no-scrollbar-style" style="margin-left: -3px; margin-right: -3px;">
				@foreach ($newestHentai as $video)
					@include('layouts.card-desktop')
				@endforeach
			</div>
			@include('layouts.card-navigate-after')
		</div>

		<a style="text-decoration: none;" href="/">
			<h3 style="padding-bottom: 3px; font-size: 22px">最新上市</h3>
		</a>
		<div style="position: relative;">
			@include('layouts.card-navigate-before')
			<div class="home-rows-videos-wrapper no-scrollbar-style" style="margin-left: 0px; margin-right: -3px;">
				@foreach ($newestListing as $video)
					<div class="multiple-link-wrapper search-doujin-videos home-doujin-videos hidden-xs" style="display: inline-block; padding-right: 3px;">
						<a class="overlay" href="{{ route('video.watch') }}?v={{ $video->id }}"></a>
						@include('video.card-doujin-desktop')
					</div>
					<div class="multiple-link-wrapper search-doujin-videos home-doujin-videos hidden-sm hidden-md hidden-lg hidden-xl" style="display: inline-block; padding-right: 3px;">
						<a class="overlay" href="{{ route('video.watch') }}?v={{ $video->id }}"></a>
						@include('layouts.card-doujin-mobile')
					</div>
				@endforeach
			</div>
			@include('layouts.card-navigate-after')
		</div>
	</div>

	<div style="margin-bottom: 15px;">
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