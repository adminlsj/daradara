@extends('layouts.app')

@section('head')
    @parent
    @include('video.videoHead')
@endsection

@section('nav')
	@include('layouts.nav-main', ['logoImage' => 'https://i.imgur.com/M8tqx5K.png', 'backgroundColor' => 'white', 'itemsColor' => "gray", 'menuBtnColor' => '#595959'])
@endsection

@section('content')
<div class="row mobile-container video-mobile-container">
	<div class="hidden-xs hidden-sm" style="margin-top: 15px;"></div>
	<div class="video-sidebar-wrapper">
		@include('video.singleShowPost')
		<div class="padding-setup" style="font-weight: 400; margin-top:-9px; margin-bottom: 10px; font-size: 1.2em;">相關影片</div>
		<div style="width: 100%; text-align: center; margin-bottom: 10px;">
			<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- Horizontal Banner Ads -->
			<ins class="adsbygoogle"
			     style="display:block"
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
@endsection