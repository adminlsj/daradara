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

	    <div class="explore-slider-title paravi-padding-setup">
	    	<a href="{{ route('video.rank') }}"><h4>推薦內容<span>發燒影片</span><i class="material-icons">arrow_forward_ios</i></h4></a>
	    </div>

	    <div class="row no-gutter load-more-container">
	        <div class="video-sidebar-wrapper">
	        	@if (count($subscribes) != 0)
				    @foreach ($subscribes as $video)
				    	@include('video.singleLoadMoreSliderVideos')
				    @endforeach
			    @endif
	        	@foreach ($newest as $video)
			    	@include('video.singleLoadMoreSliderVideos')
			    @endforeach
		        <div id="sidebar-results"><!-- results appear here --></div>
		        <div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 25px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
	        </div>
	    </div>
	</div>
</div>

@endsection

@section('script')
  @parent
  <script src="{{ mix('js/loadMore.js') }}"></script>
@endsection