@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>
<div class="main-content" style="background-color: #F5F5F5;">
	<div>
		<div style="padding: 20px; padding-bottom: 0px; ">
			<i style="font-size: 80px; color: gray; float: left; margin-left: -5px;" class="material-icons">subscriptions</i>
			<div style="margin-left: 85px; margin-top: 3px; height: 76px">
				<div style="font-size: 1.2em">讓頻道訂閱信息更充實</div>
				<div style="color: gray; margin-top: 3px;">訂閱您喜愛的頻道，保證不會錯過最新內容。</div>
			</div>
		</div>
		<hr style="border-color: #e9e9e9; margin-bottom: 0px">
		<div style="margin: 0 auto 0 auto; padding-top: 10px; padding-bottom: 10px;">
	      <div class="video-slider-title paravi-padding-setup">
	        <a href="{{ route('video.varietyList') }}"><h4>LaughSeeJapan綜藝頻道<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
	      </div>
	      @include('video.single-watch-slider')
	    </div>

	    <div class="video-slider-title paravi-padding-setup">
	    	<a href="{{ route('video.rank') }}"><h4>最夯發燒影片<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
	    </div>
	    @include('video.single-video-slider', ['videos' => $trendings])

	    <div class="video-slider-title paravi-padding-setup">
	    	<a href="{{ route('video.newest') }}"><h4>最新精彩內容<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
	    </div>
	    @include('video.single-video-slider', ['videos' => $newest])

	    <div class="video-slider-title paravi-padding-setup">
	    	<a href="{{ route('video.variety') }}"><h4>綜藝推薦<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
	    </div>
	    @include('video.single-video-slider', ['videos' => $variety])

	    <div class="video-slider-title paravi-padding-setup">
	    	<a href="{{ route('video.drama') }}"><h4>日劇推薦<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
	    </div>
	    @include('video.single-video-slider', ['videos' => $drama])

	    <div class="video-slider-title paravi-padding-setup">
	    	<a href="{{ route('video.anime') }}"><h4>動漫推薦<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
	    </div>
	    @include('video.single-video-slider', ['videos' => $anime])

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