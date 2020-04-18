@extends('layouts.app')

@section('head')
    @parent
    @include('video.videoHead')
@endsection

@section('nav')
	@include('layouts.nav-main', ['theme' => 'white', 'logoImage' => 'https://i.imgur.com/M8tqx5K.png'])
@endsection

@section('content')
	<div class="hidden-sm hidden-xs sidebar-menu">
	  @include('video.sidebarMenu', ['theme' => 'white'])
	</div>
	
	<div class="main-content">
		<div style="background-color:white;">
		<div class="video-sidebar-wrapper">
			<div class="row">
				<div class="col-md-8 single-show-player">
					@include('video.singleShowPost')
				</div>

				<div class="col-md-4 single-show-list">
					<br class="hidden-sm hidden-xs">

					<button style="font-weight: 500; margin-top: -20px; font-size: 1.2em; border: none; border-top: solid 4px #d84b6b; outline: none; cursor: pointer; padding: 14px 15px;">相關影片</button>

					<div class="hidden-xs hidden-sm" style="padding: 7px 15px;">
						<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<!-- Horizontal Banner Ads -->
						<ins class="adsbygoogle"
						     style="display:block;"
						     data-ad-client="ca-pub-4485968980278243"
						     data-ad-slot="8455082664"
						     data-ad-format="auto"
						     data-full-width-responsive="true"></ins>
						<script>
						     (adsbygoogle = window.adsbygoogle || []).push({});
						</script>
					</div>

				    @foreach ($videos as $video)
					    <div>
					    	@include('video.singleRelatedPost')
				    	</div>
				    @endforeach
				</div>
			</div>
		</div>
	</div>
@endsection