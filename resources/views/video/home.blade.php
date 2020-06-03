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

		@if (Auth::check() && auth()->user()->subscribes()->first())
			<div class="row no-gutter load-more-container" style="padding-top: 19px;">
	          <h5 class="user-show-title" style="font-size: 1em; color: #555555; font-weight: normal; line-height: 0px">只有想不到，沒有找不到</h5>
	          <h3 class="user-show-title no-select" style="font-size: 2em; margin-top: 5px; margin-bottom: 10px">LaughSeeJapan <span style="font-size: 0.93em">推薦</span></h3>
	        </div>

	        <div class="subscribes-tab" style="border: none; margin-top: 4px; margin-bottom: 0px">
	        	<a id="default-tag" class="load-tag-videos active no-select" style="margin-right: 5px;">全部推薦</a>
	            @foreach (auth()->user()->recommendTags() as $tag)
	                <a class="load-tag-videos no-select" style="margin-right: 5px;">#{{ $tag }}</a>
	            @endforeach
	    	</div>

	        <div class="row no-gutter load-more-container" style="margin-top: 18px; padding-bottom: 5px;">
	            <div class="video-sidebar-wrapper" style="position: relative; overflow-y: hidden;">
	                <div id="sidebar-results"><!-- results appear here --></div>
	                <div style="text-align: center;" class="ajax-loading-default"><img style="width: 40px; height: auto; padding-top: 20px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
	                <div style="text-align: center;" class="ajax-loading"></div>
	            </div>
	        </div>

		@else
			@include('video.home-default')
		@endif
	</div>
</div>

@endsection