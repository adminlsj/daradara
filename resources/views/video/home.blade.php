@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
    @include('video.sidebarMenu', ['theme' => 'white'])
</div>

<div class="main-content">
	<div style="background-color: #F5F5F5;">

		@if (Auth::check() && Auth::user()->subscribes()->first())
			<div class="subscribes-tab">
		    	<a id="default-tag" class="load-tag-videos active" style="margin-right: 5px;">全部推薦內容</a>
				<a class="load-tag-videos" style="margin-right: 5px;">#日劇</a>
				<a class="load-tag-videos" style="margin-right: 5px;">#動漫</a>
				<a class="load-tag-videos" style="margin-right: 5px;">#綜藝</a>
				@foreach (Auth::user()->subscribes() as $subscribe)
					<a class="load-tag-videos" style="margin-right: 5px;">#{{ explode(' ', $subscribe->tag)[0] }}</a>
				@endforeach
			</div>
		@else
			<div class="home-banner-wrapper" style="padding-top: 10px;">
				<a href="/about">
					<div style="background-color: white; text-align: left; position: relative;">
						<img src="https://i.imgur.com/X29HWB5.png">
						<div id="home-banner-catchphrase">崁入你的原創內容
		一鍵分享給全世界的觀眾</div>

						<div id="home-banner-logo"><span id="english-logo">LaughSeeJapan</span><span id="chinese-logo">娛見日本</span></div>
					</div>
				</a>
			</div>

			<div class="subscribes-tab">
		    	<a id="default-tag" class="load-tag-videos active" style="margin-right: 5px;">全部推薦內容</a>
				<a class="load-tag-videos" style="margin-right: 5px;">#日本創意廣告</a>
				<a class="load-tag-videos" style="margin-right: 5px;">#日本人氣YouTuber</a>
				<a class="load-tag-videos" style="margin-right: 5px;">#動漫講評</a>
				<a class="load-tag-videos" style="margin-right: 5px;">#MAD·AMV</a>
				<a class="load-tag-videos" style="margin-right: 5px;">#日劇講評</a>
			</div>
		@endif

	    <div class="row no-gutter load-more-container">
	        <div class="video-sidebar-wrapper">
		        <div id="sidebar-results"><!-- results appear here --></div>
		        <div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 25px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
	        </div>
	    </div>
	</div>
</div>

@endsection