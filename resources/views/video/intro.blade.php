@extends('layouts.app')

@section('head')
    @parent
    <title>{{ $watch->title }} | 娛見日本 LaughSeeJapan</title>
    <meta name="title" content="{{ $watch->title }} | 娛見日本 LaughSeeJapan | 日本最強娛樂 | 綜藝 | 日劇 | 動漫">
    <meta name="description" content="{{ $watch->description }}">
@endsection

@section('nav')
	@include('layouts.nav-main', ['logoImage' => 'https://i.imgur.com/xSMGFWh.png', 'backgroundColor' => '#222222', 'itemsColor' => "white"])
@endsection

@section('content')
	<div style="background-image: url({{ $watch->imgurH() }}); background-size: 100%; background-repeat: no-repeat; background-position: 50%; filter: blur(30px); z-index: 0; opacity: 0.5;">
		<div class="padding-setup mobile-container">
			<div style="padding-top: 15px; padding-bottom: 10px;" class="row">
				@include('video.introTemp')
			</div>
		</div>
	</div>
	<div class="padding-setup mobile-container">
		<div class="row" style="padding-top: 15px; padding-bottom: 10px; position: absolute; top: 50px; width: inherit;">
			@include('video.introTemp')
		</div>
	</div>

	<br class="hidden-xs hidden-sm">
	<hr style="border:solid 1.5px #222222; margin-top: 0px">

	<div class="padding-setup mobile-container">
		<div class="row">
			<div class="padding-setup" style="font-weight: 400; margin-bottom: 10px; font-size: 1.2em; color: white; font-weight: bold;">播放列表</div>
		    @foreach ($videos as $video)
		    	@include('video.singleRelatedWatch')
		    	<a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video->id }}">
			    	<div class="padding-setup" style="font-size: 0.95em; color: #cccccc; line-height: 19px; white-space: pre-wrap;">{{ $video->caption }}</div>
			    </a>
		    	<br>
		    @endforeach
		</div>
	</div>
@endsection