@extends('layouts.app')

@section('head')
    @parent
    @include('video.videoHead')
@endsection

@section('nav')
  @include('nav.main')
@endsection

@section('content')
<div id="content-div">
	<div class="row no-gutter video-show-width" style="margin-top: 15px;">
		<div class="col-md-9 single-show-player" style="background-color: #141414;">
			<div style="color: white" class="mobile-padding">
				<img style="width: 192px; max-width: 40%; box-shadow: 3px 3px 10px black; float: left; margin-right: 15px;" src="{{ $video->cover }}">
				<div>
					<div style="margin-bottom: -6px;">
				        <p style="font-size: 12px; color: #bdbdbd; font-weight: 500">{{ Carbon\Carbon::parse($video->created_at)->format('Y-m-d') }} <span style="font-weight: normal;">&nbsp;|&nbsp;</span> {{ $video->views() }}次點閱</p>
			        </div>
			        <h3 style="line-height: 30px; font-weight: bold; font-size: 1.5em; margin-top: 0px; color: white; margin-bottom: 30px;">{{ $video->title }}</h3>
		        	<a style="padding: 15px 50px; border: 1px solid white; border-radius: 2px; color: white; font-size: 20px; font-weight: 400; text-decoration: none;" href="{{ $link }}" download="{{ $video->title }}" target="_blank">{{ strpos($video->tags, ' 1080p ') !== false ? '1080P' : '720P' }}</a>
		        </div>
			</div>
		</div>

		<div class="col-md-3 single-show-list">
			<div class="hidden-xs hidden-sm" style="text-align: left; padding-left: 5px; padding-top: 5px; margin-top: 0px; margin-bottom: 15px; padding-bottom: 0px; width: 310px; height: 282px; background-color: #3a3c3f;">
		        <div style="margin-bottom: 5px; color: white; font-size: 12px;">點點廣告，贊助我們（●´∀｀）ノ♡</div>
		        <script type="application/javascript">
		            var ad_idzone = "4011926",
		            ad_width = "300",
		            ad_height = "250"
		        </script>
		        <script type="application/javascript" src="https://a.realsrv.com/ads.js"></script>
		        <noscript>
		            <iframe src="https://syndication.realsrv.com/ads-iframe-display.php?idzone=4011926&output=noscript&type=300x250" width="300" height="250" scrolling="no" marginwidth="0" marginheight="0" frameborder="0"></iframe>
		        </noscript>
		    </div>
		</div>
	</div>

	<div class="hidden-xs hidden-sm" style="margin-top: 35px;">
		@include('layouts.exoclick')
	</div>

	<div class="hidden-md hidden-lg" style="text-align: left; padding-left: 5px; padding-top: 5px; margin-top: 15px; padding-bottom: 0px; margin-left: 15px; margin-right: 15px; margin-bottom: 15px; width: 310px; height: 282px; background-color: #3a3c3f;">
	    <div style="margin-bottom: 5px; color: white; font-size: 12px;">點點廣告，贊助我們（●´∀｀）ノ♡</div>
	    <script type="application/javascript">
	        var ad_idzone = "4011926",
	        ad_width = "300",
	        ad_height = "250"
	    </script>
	    <script type="application/javascript" src="https://a.realsrv.com/ads.js"></script>
	    <noscript>
	        <iframe src="https://syndication.realsrv.com/ads-iframe-display.php?idzone=4011926&output=noscript&type=300x250" width="300" height="250" scrolling="no" marginwidth="0" marginheight="0" frameborder="0"></iframe>
	    </noscript>
	</div>
</div>
@endsection