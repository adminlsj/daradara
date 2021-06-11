@extends('layouts.app')

@section('nav')
  @include('nav.main')
@endsection

@section('content')

<div class="nav-bottom-padding">

	<div class="hidden-xs" style="position: relative;">
		<img style="width: 100%; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0.3)));" src="{{ $banner->imgur() }}" alt="{{ $banner->title }}">
		<div id="home-banner-wrapper" style="position: absolute; left: 4%; color: white">
			<h3 style="font-weight: bold"><span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me</h3>
			<h1 style="margin: 0; font-weight: bold;">{{ $banner->title }}</h1>
			<h4 class="hidden-xs">{{ $banner->translations['JP'] }} • 中文字幕 • {{ $banner->caption }}</h4>
			<a href="{{ route('video.watch') }}?v={{ $banner->id }}" target="_blank" style="display: inline-block; padding: 10px 30px 6px 20px; margin-top: -8px; margin-bottom: -10px" class="hover-opacity-all home-banner-btn home-banner-play-btn play-btn"><span style="vertical-align: middle; font-size: 2em; margin-top: -4px; padding-right: 5px" class="material-icons">play_arrow</span>播放</a>
			&nbsp;
			<a href="{{ route('video.watch') }}?v={{ $banner->id }}" class="hover-opacity-all home-banner-btn home-banner-info-btn"><span style="vertical-align: middle; font-size: 1.7em; margin-top: -2px; padding-right: 7px" class="material-icons">info</span>更多資訊</a>
		</div>
	</div>

	<div class="hidden-sm hidden-md hidden-lg" style="position: relative;">
		<img style="width: 100%; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0)));" src="https://i.imgur.com/gLkXHvR.png">
		<div style="position: absolute; left: 50%; -webkit-transform: translateX(-50%); transform: translateX(-50%); width: 96%; bottom: 15%; text-align: center; color: white">
			<h3 style="font-weight: bold; font-size: 20px;"><span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me</h3>
			<h1 style="font-size: 30px; font-weight: bold; margin: 0">{{ $banner->title }}</h1>
			<h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; line-height: 16px; font-size: 12px; width: 92%; margin-left: 4%;">{{ $banner->translations['JP'] }} • 中文字幕 • {{ $banner->caption }}</h4>
			<div style="margin-top: 20px; width: 100%">
				<div style="display: inline-block; margin-top: 5px;">
					<a href="{{ route('video.watch') }}?v={{ $banner->id }}" class="hover-opacity-all home-banner-btn home-banner-play-btn play-btn" target="_blank" style="cursor: pointer; font-size: 14px; border-radius: 3px; text-decoration: none; background-color: white; padding: 8px 22px 8px 12px; color: black;"><span style="vertical-align: middle; font-size: 2em; margin-top: -3px; padding-right: 3px" class="material-icons">play_arrow</span>播放</a>
				</div>
				<div style="display: inline-block; margin-top: 5px; padding-left: 2px;">
					<a href="{{ route('video.watch') }}?v={{ $banner->id }}" class="hover-opacity-all home-banner-btn home-banner-info-btn" style="cursor: pointer; font-size: 14px; border-radius: 3px; text-decoration: none; background-color: gray; padding: 8px 21px 8px 17px; color: white; opacity: 0.8;"><span style="vertical-align: middle; font-size: 1.66em; margin-top: -3px; padding-right: 4px" class="material-icons">info</span>更多資訊</a>
				</div>
			</div>
		</div>
	</div>

	<div id="home-rows-wrapper" style="position: relative;">
		@foreach ($rows as $title => $data)
			<a style="text-decoration: none;" href="{{ $data['link'] }}">
				<h3>{{ $title }}<span style="vertical-align: middle; margin-top: -2px; margin-left: 2px" class="material-icons">chevron_right</span></h3>
			</a>
			<div style="position: relative;">
				<div class="hidden-xs hidden-sm no-select navigate-before-btn" style="background-color: rgba(0, 0, 0, .7); height: 100%; width: 4%; position: absolute; top: 0; left: 0; cursor: pointer; z-index: 1; display: none;">
					<span class="material-icons" style="font-size: 50px; color: white; margin: 0; position: absolute; top: 50%; left: 50%; -ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%);">navigate_before</span>
				</div>
				<div class="home-rows-videos-wrapper no-scrollbar-style" style="margin-left: -2px; margin-right: -2px;">
					@foreach ($data['videos'] as $video)
						<a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video->id }}">
							<div class="home-rows-videos-div" style="position: relative; display: inline-block;">
								<img src="{{ $video->cover }}">
						        <div class="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 3px 5px; background: linear-gradient(to bottom, transparent 0%, black 120%);">{{ $video->title }}</div>
					        </div>
						</a>
					@endforeach
				</div>
				<div class="hidden-xs hidden-sm no-select navigate-next-btn" style="background-color: rgba(0, 0, 0, .7); height: 100%; width: 4%; position: absolute; top: 0; right: 0; cursor: pointer; z-index: 1">
					<span class="material-icons" style="font-size: 50px; color: white; margin: 0; position: absolute; top: 50%; left: 50%; -ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%);">navigate_next</span>
				</div>
			</div>

			@if ($loop->iteration == 1)
				<div style="margin-bottom: -15px;">
					@include('layouts.exoclick-home')
				</div>
			@endif
			@if ($loop->iteration == 2)
				<div style="margin-bottom: -15px;">
					@include('layouts.juicyads-home')
				</div>
			@endif
		@endforeach
	</div>

	@include('layouts.exoclick')

	<div style="background-color: #212121;">
		<div class="hentai-footer">
			<p>Hanime1.me 暗黑版 anime1.me 帶給你最新最全的無碼高清中文字幕Hentai成人動漫。我們提供最優質的Hentai色情動漫裏番，並以最高畫質1080p呈現的Blu-ray rip。我們的18禁H漫網站適用於手機設備，並提供全網最優質的Hentai動畫。最新最全的Hentai裏番資料庫，Hanime1.me hentai 讓你一個按鈕觀看所有Hentai成人動畫，包括最新的2020年Hentai成人動漫。在這裏，你可以找到最優質的中文字幕H動畫 24小時！免費享受hentai動漫，成人動畫，H動漫，並且更有中文字幕，不必再聽日語猜故事！這個網站是繼avbebe之後，亞洲最優質的色情工口Hentai成人動漫，並且有許多Hentai分類，包括顏射、乳交、口交、熟女、學生妹、中出、百合、肛交，以及更多！</p>

			<p>Hentai是什麼？Hentai（変態 或 へんたい），Hentai 或 成人動漫的詞源來自日本，並指色情或成人動漫和動畫，特別是來自日本的18禁H動漫和成人動畫。</p>
		</div>
	</div>
</div>

@include('layouts.nav-bottom')
@if (!Auth::check())
  @include('user.signUpModal')
  @include('user.loginModal')
@endif

@endsection