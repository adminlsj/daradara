@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['theme' => 'white', 'logoImage' => 'https://i.imgur.com/M8tqx5K.png'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>
<div class="main-content" style="background-color: #F5F5F5;">
	<div style="padding-top: 10px;">
		<div id="subscribes-watch-wrapper" class="row no-gutter padding-setup" style="height: 90px; overflow-x: hidden; position: relative;">
			@foreach ($subscribes as $subscribe)
				<a href="{{ route('video.intro', [$subscribe->watch()->genre, $subscribe->watch()->titleToUrl()]) }}" style="text-decoration: none;">
					<div class="col-xs-1" style="width: 60px; margin: 0px; padding: 0px; text-align: center; margin-right: 15px; margin-bottom: 10px;">
						<img class="lazy" style="width: 100%; height: auto; border-radius: 50%;" src="{{ $subscribe->watch()->imgurDefaultCircleB() }}" data-src="{{ $subscribe->watch()->imgurB() }}" data-srcset="{{ $subscribe->watch()->imgurB() }}" alt="{{ $subscribe->watch()->title }}">
						<div class="text-ellipsis" style="width: 100%; font-size: 0.8em; padding-top: 5px; color: dimgray;">{{ $subscribe->watch()->title }}</div>
					</div>
				</a>
			@endforeach
			<div id="subscribe-show-all" class="no-select" style="height: 80px; vertical-align: middle; padding: 0px 15px; position: absolute; top: 0px; right: 0px; background-color: #F5F5F5; font-size: 1em; padding-top: 25px; color: #d84b6b; font-weight: 500; cursor: pointer">所有</div>
		</div>
		<hr style="margin: 0px 0px 16px 0px; border-color: #e5e5e5;">
		<div class="subscribes-tab padding-setup">
			<a href="{{ route('video.subscribes') }}?m=newest" class="{{ Request::is('*subscribes*') ? 'active' : '' }}" style="margin-right: 5px;">最新内容</a>
			<!-- <a href="#">儲存的影片</a>-->
		</div>
		<hr style="margin: 15px 0px 0px 0px; border-color: #e5e5e5;">
		<div class="video-sidebar-wrapper">
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