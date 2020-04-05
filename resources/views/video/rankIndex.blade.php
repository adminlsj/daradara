@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['theme' => 'white', 'logoImage' => 'https://i.imgur.com/M8tqx5K.png'])
@endsection

@section('content')
<div style="background-color: #FEFEFE;">
	<div class="explore-slider-title paravi-padding-setup">
		@if (Request::path() == 'rank')
	    	<a href="{{ route('video.newest') }}"><h4>最夯發燒影片<span>最新內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
    	@elseif (Request::path() == 'newest')
	    	<a href="{{ route('video.rank') }}"><h4>最新精彩內容<span>發燒影片</span><i class="material-icons">arrow_forward_ios</i></h4></a>
    	@endif
    </div>
	<div class="row no-gutter load-more-container">
      <div class="video-sidebar-wrapper">
          <div id="sidebar-results"><!-- results appear here --></div>
          <div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 25px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
      </div>
    </div>
</div>
@endsection

@section('script')
	@parent
	<script src="{{ mix('js/loadMore.js') }}"></script>
@endsection