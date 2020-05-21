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
			<div class="subscribes-tab">
		    	<a id="default-tag" class="load-tag-videos active" style="margin-right: 5px;">全部推薦內容</a>
				@foreach (auth()->user()->recommendTags() as $tag)
					<a class="load-tag-videos" style="margin-right: 5px;">#{{ $tag }}</a>
				@endforeach
			</div>
			<div class="row no-gutter load-more-container">
		        <div class="video-sidebar-wrapper" style="position: relative;">
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