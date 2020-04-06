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

		<div class="hidden-xs hidden-sm" style="padding-top: 10px; padding-bottom: 10px">
			<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- Home Desktop Ads -->
			<ins class="adsbygoogle"
			     style="display:block; border: 1px solid black"
			     data-ad-client="ca-pub-4485968980278243"
			     data-ad-slot="4478704168"
			     data-ad-format="auto"
			     data-full-width-responsive="true"></ins>
			<script>
			     (adsbygoogle = window.adsbygoogle || []).push({});
			</script>
		</div>

		<div class="video-slider-title paravi-padding-setup hidden-xs hidden-sm" style="margin: 0 auto 0 auto; padding-top: 10px">
	    	<a href="{{ route('video.rank') }}"><h4>探索LaughSeeJapan</h4></a>
	    </div>
		<div class="paravi-padding-setup row hidden-xs hidden-sm" style="margin: 0 auto 0 auto; padding-top: 3px; padding-bottom: 15px;">
			<div style="margin: 0px -10px;">
			    @include('layouts.single-horizontal-genre-card', ['genre' => '綜藝節目', 'imgur' => 'iXyOfUs', 'link' => route('video.variety')])
			    @include('layouts.single-horizontal-genre-card', ['genre' => '電視劇', 'imgur' => 'aALP7mY', 'link' => route('video.drama')])
			    @include('layouts.single-horizontal-genre-card', ['genre' => '動漫卡通', 'imgur' => 'VHxhxcI', 'link' => route('video.anime')])
		    </div>
		</div>

		<div class="paravi-padding-setup row hidden-md hidden-lg" style="margin: 0 auto 0 auto; padding-top: 30px; padding-bottom: 20px;">
			<div style="margin: 0px -5px;">
			    @include('layouts.single-genre-card', ['genre' => '綜藝節目', 'imgur' => 'iXyOfUs', 'link' => route('video.variety')])
			    @include('layouts.single-genre-card', ['genre' => '電視劇', 'imgur' => 'aALP7mY', 'link' => route('video.drama')])
			    @include('layouts.single-genre-card', ['genre' => '動漫卡通', 'imgur' => 'VHxhxcI', 'link' => route('video.anime')])
		    </div>
		</div>

	    @if (count($subscribes) != 0)
	    	<div class="video-slider-title paravi-padding-setup">
	    		<a href="{{ route('video.subscribes') }}"><h4>最新訂閱內容<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
		    </div>
		    @include('video.single-video-slider', ['videos' => $subscribes])
	    @endif

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