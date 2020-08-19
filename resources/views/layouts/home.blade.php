@extends('layouts.app')

@section('nav')
  @include('nav.main')
@endsection

@section('content')

<div class="hidden-xs" style="position: relative;">
	<img style="width: 100%; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0.3)));" src="{{ $banner->imgur() }}">
	<div id="home-banner-wrapper" style="position: absolute; left: 4%; color: white">
		<h3 style="font-weight: bold"><span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me</h3>
		<h1 style="margin: 0">{{ explode('/', $banner->title)[0] }}</h1>
		<h4 class="hidden-xs">{{ $banner->watch->description }}</h4>
		<div>
			<a class="hover-opacity-all home-banner-btn home-banner-play-btn"><span style="vertical-align: middle; font-size: 2em; margin-top: -3px; padding-right: 5px" class="material-icons">play_arrow</span>播放</a>
			&nbsp;
			<a class="hover-opacity-all home-banner-btn home-banner-info-btn"><span style="vertical-align: middle; font-size: 1.7em; margin-top: -2px; padding-right: 7px" class="material-icons">info</span>更多資訊</a>
		</div>
	</div>
</div>

<div class="hidden-sm hidden-md hidden-lg" style="position: relative;">
	<img style="width: 100%; -webkit-mask-image:-webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0)));" src="{{ $banner->cover }}">
	<div style="position: absolute; left: 50%; -webkit-transform: translateX(-50%); transform: translateX(-50%); width: 96%; bottom: 20%; text-align: center; color: white">
		<h3 style="font-weight: bold; font-size: 20px;"><span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me</h3>
		<h1 style="font-size: 30px; font-weight: bold; margin: 0">{{ explode('/', $banner->title)[0] }}</h1>
		<h4 style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; line-height: 16px; font-size: 12px; width: 80%; margin-left: 10%;">{{ $banner->watch->description }}</h4>
		<div style="margin-top: 20px; width: 100%">
			<div style="width: 33%; float:left; display: inline-block;">
				<span class="material-icons">add</span>
				<div style="font-size: 12px; margin-top: -1px">播放清單</div>
			</div>
			<div style="width: 33%; float:left; display: inline-block; margin-top: 10px;">
				<a class="hover-opacity-all home-banner-btn home-banner-play-btn" style="cursor: pointer; font-size: 14px; border-radius: 3px; text-decoration: none; background-color: white; padding: 7px 22px 7px 12px; color: black;"><span style="vertical-align: middle; font-size: 2em; margin-top: -3px; padding-right: 3px" class="material-icons">play_arrow</span>播放</a>
			</div>
			<div style="width: 33%; float:left; display: inline-block;">
				<span class="material-icons">info</span>
				<div style="font-size: 12px; margin-top: -1px">更多資訊</div>
			</div>
		</div>
	</div>
</div>

<div id="home-rows-wrapper" style="position: relative;">
	@foreach ($rows as $title => $videos)
		<h3>{{ $title }}</h3>
		<div class="home-rows-videos-wrapper">
			@foreach ($videos as $video)
				<a style="text-decoration: none;" href="{{ route('video.playlist') }}?list={{ $video->playlist_id }}">
					<div style="position: relative; display: inline-block;">
						<img src="{{ $video->cover }}">
				        <div id="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 3px 3px; background: linear-gradient(to bottom, transparent 0%, black 120%);">{{ explode('/', $video->watch->title)[0] }}</div>
			        </div>
				</a>
			@endforeach
		</div>
	@endforeach
</div>

<div class="row" style="padding: 0 4%">
	<div class="col-md-3">
		<div>Audio and Subtitles</div>
		<div>Audio and Subtitles</div>
		<div>Audio and Subtitles</div>
	</div>
	<div class="col-md-3">
		<div>Audio and Subtitles</div>
		<div>Audio and Subtitles</div>
		<div>Audio and Subtitles</div>
	</div>
	<div class="col-md-3">
		<div>Audio and Subtitles</div>
		<div>Audio and Subtitles</div>
		<div>Audio and Subtitles</div>
	</div>
	<div class="col-md-3">
		<div>Audio and Subtitles</div>
		<div>Audio and Subtitles</div>
		<div>Audio and Subtitles</div>
	</div>
</div>

<div style="padding: 0 4%">
	<div>© 2020 娛見日本 LaughSeeJapan</div>
</div>

@endsection