@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['theme' => 'white', 'logoImage' => 'https://i.imgur.com/M8tqx5K.png'])
@endsection

@section('content')
<div class="hidden-xs hidden-sm hidden-md sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>
<div class="main-content">
	@include('layouts.nav-newest')

	<div style="background-color: #F5F5F5;" class="rank-index-padding-top">
		<div id='home-first-title' style="padding: 0px 20px; padding-bottom: 8px">
	      <h4>LaughSeeJapan最新頻道<a href="{{ route('video.varietyList') }}" style="float: right; text-decoration: none; color: black"><i style="vertical-align:middle; font-size: 1em; margin-top: -3.5px;" class="material-icons">arrow_forward_ios</i></a></h4>
	    </div>
	    <div id="custom-scroll-slider">
		    @foreach ($selected as $watch)
	          <div style="border-radius: 10px; box-shadow: 1px 4px 6px rgba(0,0,0,0.1); width: 150px !important; background: #fff; display: inline-block; vertical-align: text-top;">
	            <a style="text-decoration: none; color: black" href="{{ route('video.intro', [$watch->genre, $watch->titleToUrl()]) }}">
	              <img class="lazy" style="width: 100%; height: 100%; border-top-left-radius: 10px; border-top-right-radius: 10px;" src="{{ $watch->imgurDefault() }}" data-src="{{ $watch->imgurL() }}" data-srcset="{{ $watch->imgurL() }}" alt="{{ $watch->title }}">

	              <div style="height: 47px; padding: 2px 15px;">
	                <h4 style="line-height: 19px; font-size: 1em;overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; font-weight: 450; white-space: initial">{{ $watch->title }}</h4>
	              </div>
	            </a>
	          </div>
	        @endforeach
	    </div>

		<div style="margin-top: 14px; padding: 0px 20px;" class="video-sidebar-wrapper">
			@switch(Request::get('g'))
			    @case('variety')
			        <h4>綜藝最新內容</h4>
			        @break
			    @case('drama')
			        <h4>日劇最新內容</h4>
			        @break
			    @case('anime')
			        <h4>動漫最新內容</h4>
			        @break
			    @default
			        <h4>最新精彩內容</h4>
			@endswitch
			<div style="padding-top: 9px"></div>
		    <div id="sidebar-results"><!-- results appear here --></div>
		    <div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 15px; padding-bottom: 30px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
		</div>
	</div>
</div>
@endsection

@section('script')
	@parent
	<script src="{{ mix('js/loadMore.js') }}"></script>
@endsection