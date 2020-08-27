@extends('layouts.app')

@section('nav')
  @include('nav.main')
@endsection

@section('content')

<div id="content-div">

	@include('video.playModal', ['video' => $banner])

	<div class="hidden-xs" style="position: relative;">
		<img class="lazy" style="width: 100%; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0.3)));" src="https://i.imgur.com/CJ5svNv.png" data-src="{{ $banner->imgur() }}" data-srcset="{{ $banner->imgur() }}" alt="{{ $banner->title }}">
		<div id="home-banner-wrapper" style="position: absolute; left: 4%; color: white">
			<h3 style="font-weight: bold"><span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me</h3>
			<h1 style="margin: 0">{{ $banner->title }}</h1>
			<h4 class="hidden-xs">{{ $banner->translations['JP'] }} • 中文字幕 • {{ $banner->caption }}</h4>
			<div style="display: inline-block; padding: 10px 30px 6px 20px; margin-top: -8px; margin-bottom: -10px" data-toggle="modal" data-target="#playModal" class="hover-opacity-all home-banner-btn home-banner-play-btn play-btn"><span style="vertical-align: middle; font-size: 2em; margin-top: -4px; padding-right: 5px" class="material-icons">play_arrow</span>播放</div>
			&nbsp;
			<a href="{{ route('video.watch') }}?v={{ $banner->id }}" class="hover-opacity-all home-banner-btn home-banner-info-btn"><span style="vertical-align: middle; font-size: 1.7em; margin-top: -2px; padding-right: 7px" class="material-icons">info</span>更多資訊</a>
		</div>
	</div>

	<div class="hidden-sm hidden-md hidden-lg" style="position: relative;">
		<img style="width: 100%; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0)));" src="https://i.imgur.com/OCatT3B.jpg">
		<div style="position: absolute; left: 50%; -webkit-transform: translateX(-50%); transform: translateX(-50%); width: 96%; bottom: 15%; text-align: center; color: white">
			<h3 style="font-weight: bold; font-size: 20px;"><span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me</h3>
			<h1 style="font-size: 30px; font-weight: bold; margin: 0">{{ $banner->translations['JP'] }}</h1>
			<h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; line-height: 16px; font-size: 12px; width: 80%; margin-left: 10%;">{{ $banner->title }} • 中文字幕 • {{ $banner->caption }}</h4>
			<div style="margin-top: 20px; width: 100%">
				<div style="width: 33%; float:left; display: inline-block;">
					@if (!Auth::check())
						<div data-toggle="modal" data-target="#signUpModal" class="video-save-form home-save-form">
				            @include('video.info-mobile-save-btn', ['video' => $banner])
				        </div>
			          @else
			            <form class="video-save-form home-save-form" action="{{ route('video.save') }}" method="POST">
			              {{ csrf_field() }}
			              <input name="save-user-id" type="hidden" value="{{ Auth::user()->id }}">
			              <input name="save-foreign-id" type="hidden" value="{{ $banner->id }}">
			              @include('video.info-mobile-save-btn', ['video' => $banner])
			            </form>
			          @endif
				</div>
				<div style="width: 33%; float:left; display: inline-block; margin-top: 10px;">
					<a class="hover-opacity-all home-banner-btn home-banner-play-btn play-btn" data-toggle="modal" data-target="#playModal" style="cursor: pointer; font-size: 14px; border-radius: 3px; text-decoration: none; background-color: white; padding: 8px 22px 8px 12px; color: black;"><span style="vertical-align: middle; font-size: 2em; margin-top: -3px; padding-right: 3px" class="material-icons">play_arrow</span>播放</a>
				</div>
				<a href="{{ route('video.watch') }}?v={{ $banner->id }}" style="width: 33%; float:left; display: inline-block; color: white; text-decoration: none;">
					<span class="material-icons">info</span>
					<div style="font-size: 12px; margin-top: 0px">更多資訊</div>
				</a>
			</div>
		</div>
	</div>

	<div id="home-rows-wrapper" style="position: relative;">
		@foreach ($rows as $title => $videos)
			<h3>{{ $title }}</h3>
			<div class="home-rows-videos-wrapper">
				@foreach ($videos as $video)
					<a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video->id }}">
						<div id="home-rows-videos-div" style="position: relative; display: inline-block;">
							<img src="{{ $video->cover }}">
					        <div id="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 3px 3px; background: linear-gradient(to bottom, transparent 0%, black 120%);">{{ $video->title }}</div>
				        </div>
					</a>
				@endforeach
			</div>
		@endforeach
	</div>

	<div class="hidden-xs" style="position: relative; padding: 0 4%; margin-top: 50px">
		<div style="margin-left: -15px; display: inline-block;">
			<a class="hidden-xs" href="/contact" style="padding: 0px 15px; color: dimgray">廣告</a>
			<a class="hidden-xs" href="/about" style="padding: 0px 15px; color: dimgray">Hanime1</a>
			<a href="/about" style="padding: 0px 15px; color: dimgray">關於</a>
			<a href="/contact" style="padding: 0px 15px; color: dimgray">聯絡</a>
		</div>

		<div style="float: right; margin-right: -15px; display: inline-block;">
			<a href="/terms" style="padding: 0px 15px; color: dimgray"><span class="hidden-xs">服務</span>條款</a>
			<a href="/policies" style="padding: 0px 15px; color: dimgray">社群<span class="hidden-xs">規範</span></a>
			<a href="/copyright" style="padding: 0px 15px; color: dimgray">版權<span class="hidden-xs">申訴</span></a>
		</div>

		<div style="margin-top: 10px; margin-bottom: 10px">
			<div style="display: inline-block; color: dimgray"><span class="hidden-xs">本網站已依台灣網站內容分級規定處理，</span>未滿十八歲者不得瀏覽</div>
			<img style="display: inline-block; margin-top: -2px; margin-left: 5px" height='13' src="https://i.imgur.com/aJ6decG.gif">
		</div>
	</div>
</div>

@include('layouts.nav-bottom')

@if (!Auth::check())
  @include('user.signUpModal')
  @include('user.loginModal')
@endif

@endsection