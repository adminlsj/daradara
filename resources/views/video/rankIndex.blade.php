@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['logoImage' => 'https://i.imgur.com/M8tqx5K.png', 'backgroundColor' => 'white', 'itemsColor' => "gray", 'menuBtnColor' => '#595959'])
@endsection

@section('content')
	<div class="row">
		<div class="col-lg-2 col-md-2 hidden-sm hidden-xs sidebar-menu">
			@include('video.sidebarMenu', ['theme' => 'white'])
		</div>
		<div class="col-md-10">
			@include('layouts.nav-rank')
			<div style="background-color: #F5F5F5; padding-top: 44px" class="video-sidebar-wrapper padding-setup">
				<div style="padding-top: 10px" class="hidden-xs hidden-sm"></div>
			    <div id="sidebar-results"><!-- results appear here --></div>
			    <div style="text-align: center" class="ajax-loading"><img src="https://s3.amazonaws.com/twobayjobs/system/loading.gif"/></div>
			</div>
		</div>
	</div>
@endsection

@section('script')
	@parent
	<script src="{{ mix('js/loadMore.js') }}"></script>
@endsection