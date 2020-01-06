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
			    <div style="padding: 7px 0px;">
				  <a href="{{ route('video.watch') }}?v={{ $video->id }}" class="row no-gutter">
				    <div style="padding-left: 12px; padding-right: 4px; position: relative;" class="col-xs-6 col-sm-6 col-md-3">
				      <img class="lazy" style="width: 100%; height: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurM() }}" data-srcset="{{ $video->imgurM() }}" alt="{{ $video->title }}">
				      <span style="position: absolute; bottom:6px; right: 9px; background-color: rgba(0,0,0,0.8); color: white; padding: 1px 5px 1px 5px; opacity: 0.9; font-size: 0.85em; border-radius: 2px;">{{ $video->duration() }}</span>
				    </div>
				    <div style="padding-top: 1px; padding-right: 12px; padding-left: 4px;" class="col-xs-6 col-sm-6 col-md-9">
				      <h4 style="margin-top:0px; margin-bottom: 0px; line-height: 19px; font-size: 1.05em; color:white;">{{ $video->title() }}</h4>
				      <p style="color: gray; margin-top: 1px; margin-bottom: 0px; font-size: 0.85em; color:#e5e5e5">觀看次數：{{ $video->views() }}次</p>
				      <div class="hidden-sm hidden-xs" style="margin-top:5px; font-size: 0.95em; color: #cccccc; line-height: 19px; white-space: pre-wrap;">{{ $video->caption }}</div>
				    </div>
				  </a>
				</div>

		    	<a class="visible-sm visible-xs" style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video->id }}">
			    	<div class="padding-setup" style="font-size: 0.95em; color: #cccccc; line-height: 19px; white-space: pre-wrap;">{{ $video->caption }}</div>
			    </a>
		    	<br>
		    @endforeach
		</div>
	</div>
@endsection