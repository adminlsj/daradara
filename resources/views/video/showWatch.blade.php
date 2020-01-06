@extends('layouts.app')

@section('head')
    @parent
    @include('video.videoHead')
@endsection

@section('nav')
	@include('layouts.nav-main', ['logoImage' => 'https://i.imgur.com/xSMGFWh.png', 'backgroundColor' => '#222222', 'itemsColor' => "white"])
@endsection

@section('content')
<div style="background-color:#414141; color: white;" class="row mobile-container video-mobile-container">
	<div class="hidden-xs hidden-sm" style="margin-top: 15px;"></div>
	<div class="video-sidebar-wrapper">
		@include('video.singleShowWatch')
		<div class="padding-setup" style="font-weight: 400; margin-top:-9px; margin-bottom: 10px; font-size: 1.2em;">即將播放</div>
		
		<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<ins class="adsbygoogle"
		     style="display:block"
		     data-ad-format="fluid"
		     data-ad-layout-key="-ej+7w+2t-jk+og"
		     data-ad-client="ca-pub-4485968980278243"
		     data-ad-slot="1056756521"></ins>
		<script>
		     (adsbygoogle = window.adsbygoogle || []).push({});
		</script>

	    @foreach ($videos as $video)
		    <div style="{{ $video->id == $current->id ? 'background-color: #7A7A7A' : '' }}">
		    	@include('video.singleRelatedWatch')
	    	</div>
	    @endforeach
	</div>
</div>
@endsection