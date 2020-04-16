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

		<div class="home-banner-wrapper" style="margin-top: 10px; margin: 0 auto 0 auto; padding-top: 10px;">
			<div style="background-color: white; text-align: left; position: relative;">
				<img src="https://i.imgur.com/X29HWB5.png">
				<div style="white-space: pre-wrap; text-align: right; position: absolute; bottom: 16px; right: 30px; font-size: 2.2em; font-weight: 300; color: gray; line-height: 47px">崁入你的原創內容
一鍵分享給全世界的觀眾</div>

				<div style="white-space: pre-wrap; text-align: left; position: absolute; top: 10px; right: 30px; font-size: 1.2em; font-weight: 400;line-height: 47px;"><span style="border: 1px solid #E5E5E5; padding: 5px 9px; border-top-left-radius: 2px; border-bottom-left-radius: 2px; color: gray">LaughSeeJapan</span><span style="border: 1px solid #E5E5E5; background-color:#E5E5E5; color: white; padding: 5px 9px; border-top-right-radius: 2px; border-bottom-right-radius: 2px;">娛見日本</span></div>
			</div>
		</div>

	    @if (count($subscribes) != 0)
	    	<div class="video-slider-title paravi-padding-setup">
	    		<a href="{{ route('video.subscribes') }}"><h4>最新訂閱內容<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
		    </div>
		    @include('video.single-video-slider', ['videos' => $subscribes])
	    @endif

	    <div class="video-slider-title paravi-padding-setup">
	    	<a href="{{ route('video.rank') }}"><h4>推薦影片<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
	    </div>
	    @include('video.single-video-slider', ['videos' => $selected])

	    <div class="video-slider-title paravi-padding-setup">
	    	<a href="{{ route('video.rank') }}"><h4>最夯發燒影片<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
	    </div>
	    @include('video.single-video-slider', ['videos' => $trendings])

	    <div class="video-slider-title paravi-padding-setup">
	    	<a href="{{ route('video.newest') }}"><h4>最新精彩內容<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
	    </div>
	    @include('video.single-video-slider', ['videos' => $newest])

	    <div class="video-slider-title paravi-padding-setup">
	    	<a href="{{ route('video.rank') }}"><h4>更多發燒影片<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
	    </div>
	    <div class="row no-gutter load-more-container">
	      <div class="video-sidebar-wrapper">
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