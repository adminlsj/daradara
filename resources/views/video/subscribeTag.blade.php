@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['theme' => 'white', 'logoImage' => 'https://i.imgur.com/M8tqx5K.png'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>
<div class="main-content" style="background-color: #F5F5F5;">
	<div>
		<div class="row no-gutter padding-setup" style="padding-top: 10px; padding-bottom: 15px; background-color: #e9e9e9">
		    <div class="col-xs-6 col-sm-6 col-md-3">
				<img style="width: 50px; height: auto; float: left; border-radius: 50%; margin-top: 5px" src="https://i.imgur.com/{{ $videos->first()->imgur }}s.jpg" alt="{{ $tag }}">
		    	<div style="margin-left: 58px"><h4>#{{ $tag }}</h4></div>
		    	<div style="margin-left: 58px; margin-top: -5px; margin-bottom: -5px;"><p style="color: #595959; font-size: 0.9em"><span id="subscribes-count">{{ App\Subscribe::where('tag', $tag)->count() }}</span> 位訂閱者</p></div>
		    </div>
		    <div class="col-xs-6 col-sm-6 col-md-7">
		    	@include('video.tag-subscribe-wrapper')
		    </div>
		</div>
		<hr style="margin: 0px 0px 0px 0px; border-color: #e5e5e5;">
		<div class="video-sidebar-wrapper padding-desktop-only">
		    <div id="sidebar-results"><!-- results appear here --></div>
		    <div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 25px; padding-bottom: 70px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
		</div>
	</div>
</div>
@endsection

@section('script')
	@parent
	<script src="{{ mix('js/loadMore.js') }}"></script>
@endsection