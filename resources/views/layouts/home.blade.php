@extends('layouts.app')

@section('nav')
  @include('nav.main')
@endsection

@section('content')

<div style="position: relative;">
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