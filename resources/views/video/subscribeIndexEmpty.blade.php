@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>
<div class="main-content" style="background-color: #F5F5F5;">
	<div>
		<div style="padding: 20px; padding-bottom: 0px; ">
			<i style="font-size: 80px; color: gray; float: left; margin-left: -5px;" class="material-icons">subscriptions</i>
			<div style="margin-left: 85px; margin-top: 3px; height: 76px">
				<div style="font-size: 1.2em">讓頻道訂閱信息更充實</div>
				<div style="color: gray; margin-top: 3px;">訂閱您喜愛的頻道，保證不會錯過最新內容。</div>
			</div>
		</div>
		<hr style="border-color: #F5F5F5; margin-bottom: 0px">
		<div class="subscribes-tab">
	    	<a id="default-tag" class="load-tag-videos active" style="margin-right: 5px;">全部推薦內容</a>
			<a class="load-tag-videos" style="margin-right: 5px;">#創意廣告</a>
			<a class="load-tag-videos" style="margin-right: 5px;">#搞笑影片</a>
			<a class="load-tag-videos" style="margin-right: 5px;">#動漫講評</a>
			<a class="load-tag-videos" style="margin-right: 5px;">#日劇講評</a>
			<a class="load-tag-videos" style="margin-right: 5px;">#電影講評</a>
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

@section('script')
	@parent
	<script src="{{ mix('js/loadMore.js') }}"></script>
@endsection