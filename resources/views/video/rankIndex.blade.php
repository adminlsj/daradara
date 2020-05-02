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

		<div class="subscribes-tab">
			@if (Request::path() == 'rank')
		    	<a id="default-tag" class="load-tag-videos active" style="margin-right: 5px;">全部發燒影片</a>
	    	@elseif (Request::path() == 'newest')
		    	<a id="default-tag" class="load-tag-videos active" style="margin-right: 5px;">全部最新內容</a>
	    	@endif

	    	@if (Auth::check() && auth()->user()->tags != '')
				@foreach (Auth::user()->tags() as $tag)
					<a class="load-tag-videos" style="margin-right: 5px;">#{{ $tag }}</a>
				@endforeach
			@else
				<a class="load-tag-videos" style="margin-right: 5px;">#日本人氣YouTuber</a>
				<a class="load-tag-videos" style="margin-right: 5px;">#日本創意廣告</a>
				<a class="load-tag-videos" style="margin-right: 5px;">#動漫講評</a>
				<a class="load-tag-videos" style="margin-right: 5px;">#MAD·AMV</a>
				<a class="load-tag-videos" style="margin-right: 5px;">#日劇講評</a>
			@endif
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