@extends('layouts.app')

@section('nav')
	@include('nav.home-mobile')
@endsection

@section('content')
<div class="hidden-xs hidden-sm" style="background-color: #222222; color: #A3A3A3; width: 100%; height: 57px; line-height: 57px; padding: 0 4%; font-weight: 400; font-size: 14px; text-align: center; overflow-x: hidden;">
	<a href="https://discord.gg/WWYc9m9CUQ" style="color: #5865F2; text-decoration: underline; padding: 10px;" target="_blank">Discord</a>
	<a href="https://theporndude.com/zh" style="color: #FF9700; text-decoration: underline; padding: 10px;" target="_blank">PornDude</a>
	<a href="https://qingse.one" style="color: #A3A3A3; text-decoration: underline; padding: 10px;" target="_blank">情色網站大全</a>
	<a href="https://141jj.com/" style="color: #A3A3A3; text-decoration: underline; padding: 10px;" target="_blank">141JJ 導航</a>
	<a href="http://www.pornbest.org/" style="color: #A3A3A3; text-decoration: underline; padding: 10px;" target="_blank">PornBest  免費中文視頻</a>
	<a href="https://www.17dm.net/" style="color: #A3A3A3; text-decoration: underline; padding: 10px;" target="_blank">妖氣動漫導航</a>
    <a href="https://share.acgnx.net/" style="color: #A3A3A3; text-decoration: underline; padding: 10px;" target="_blank">末日動漫資源庫</a>
    <a href="https://moeli-desu.com/" style="color: #A3A3A3; text-decoration: underline; padding: 10px;" target="_blank">夢璃</a>
	<a href="https://www.sshs.pw/" style="color: #A3A3A3; text-decoration: underline; padding: 10px;" target="_blank">紳士會所</a>
</div>

<div class="nav-bottom-padding home-content-wrapper">
	<div class="hidden-xs" style="position: relative;">
		<div id="main-nav-home" class="main-nav-home-desktop" style="z-index: 10000 !important; position: absolute;">
		  @include('nav.main-content')
		</div>
		<script>
			var targetOffset = $(".main-nav-home-desktop").offset().top;
			var $window = $(window).scroll(function(){
			    if ( $window.scrollTop() > targetOffset ) {   
			      $(".main-nav-home-desktop").css({"position":"fixed", 'background-color':'#141414'});
			      $("#user-modal-panel").css({"position":"absolute", 'top':'30px'});
			    } else {
			      $(".main-nav-home-desktop").css({"position":"absolute", 'background-color':'transparent'});
			      $("#user-modal-panel").css({"position":"absolute", 'top':'87px'});
			    }
			});
		</script>
	</div>

	<div style="position: relative; margin-top: 0px; padding-top: 100px;">

		<div class="content-padding-new home-rows-top">
			<a class="home-rows-header" style="text-decoration: none;" href="/">
				<h5 style="color: #8e9194;">404錯誤</h5>
				<h3 style="font-weight: 700; color: #edeeef; margin-bottom: 20px;">找不到該頁面</h3>
				@include('layouts.home-row-arrow')
			</a>
		</div>

	</div>

	<div style="margin-bottom: 15px;">
		<div class="hidden-xs hidden-sm" style="margin-top: 50px; margin-bottom: 50px; padding-top: 5px; padding-bottom: 40px; text-align: center;">
			@include('layouts.exoclick', ['id' => '5007146', 'width' => '900', 'height' => '250'])
		</div>

		<div class="hidden-md hidden-lg" style="text-align: center; padding-top: 35px; padding-bottom: 50px;">
			@include('layouts.exoclick', ['id' => '5007148', 'width' => '300', 'height' => '250'])

			<span class="hidden-xs" style="vertical-align: top; margin-top: 5px;">
				<!-- JuicyAds v3.1 -->
				<script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
				<ins id="940480" data-width="300" data-height="262"></ins>
				<script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':940480});</script>
				<!--JuicyAds END-->
			</span>
		</div>
	</div>

	<div style="background-color: #212121;">
		<div class="hentai-footer">
			<p>Hanime1.me 暗黑版 anime1.me 帶給你最新最全的無碼高清中文字幕Hentai成人H動漫。我們提供最優質的Hentai色情動漫裏番，並以最高畫質1080p呈現的Blu-ray rip。我們的18禁H漫網站適用於手機設備，並提供全網最優質的Hentai動畫。最新最全的Hentai裏番資料庫，Hanime1.me hentai 讓你一個按鈕觀看所有Hentai成人動畫，包括最新的2022年Hentai成人動漫。在這裏，你可以找到最優質的中文字幕H動畫 24小時！免費享受里番，成人動畫，H動漫，並且更有中文字幕，不必再聽日語猜故事！這個網站是繼avbebe之後，亞洲最優質的色情工口H動漫線上看網站，並且有許多Hentai分類，包括顏射、乳交、口交、熟女、學生妹、中出、百合、肛交，以及更多！</p>

			<p>Hentai是什麼？Hentai（変態 或 へんたい），Hentai 或 成人動漫的詞源來自日本，並指色情或成人動漫和動畫，特別是來自日本的18禁H動漫和成人動畫。</p>
		</div>
	</div>
</div>

@include('layouts.nav-bottom')

@endsection