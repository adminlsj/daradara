@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['theme' => 'white', 'logoImage' => 'https://i.imgur.com/M8tqx5K.png'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>
<div class="main-content">
	@include('layouts.nav-newest')
	<div style="background-color: #F5F5F5; margin-top: 33px; padding-top: 10px" class="video-sidebar-wrapper padding-setup">
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
@endsection

@section('script')
	@parent
	<script src="{{ mix('js/loadMore.js') }}"></script>
@endsection