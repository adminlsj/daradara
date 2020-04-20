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

		@if (Auth::check())
			<div class="paravi-padding-setup">
				<hr style="margin: 0px 0px 15px 0px; border-color: #e1e1e1; border-width: 2px">
				<div class="subscribes-tab">
					<a id="default-tag" class="load-tag-videos active" style="margin-right: 5px;">全部發燒影片</a>
					<a class="load-tag-videos" style="margin-right: 5px;">綜藝</a>
					<a class="load-tag-videos" style="margin-right: 5px;">日劇</a>
					<a class="load-tag-videos" style="margin-right: 5px;">動漫</a>
				</div>
				<hr style="margin: 15px 0px 15px 0px; border-color: #e1e1e1; border-width: 2px">
			</div>
		@else
			<div class="explore-slider-title paravi-padding-setup">
				@if (Request::path() == 'rank')
			    	<a href="{{ route('video.newest') }}"><h4>最夯發燒影片<span>最新內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
		    	@elseif (Request::path() == 'newest')
			    	<a href="{{ route('video.rank') }}"><h4>最新精彩內容<span>發燒影片</span><i class="material-icons">arrow_forward_ios</i></h4></a>
		    	@endif
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