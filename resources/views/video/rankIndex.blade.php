@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['theme' => 'white', 'logoImage' => 'https://i.imgur.com/M8tqx5K.png'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>
<div class="main-content">
	<div style="background-color: #F5F5F5; padding-top: 20px;">
		
		<div style="padding: 0px 20px; padding-bottom: 8px">
	      <h4>LaughSeeJapan{{ Request::path() == 'newest' ? '最新' : '熱門' }}頻道</h4>
	    </div>
	    @include('video.single-watch-slider')

		<div style="margin-top: 25px; padding: 0px 20px;">
			@if (Request::path() == 'rank')
				<h4><a style="text-decoration: none; color: inherit;" href="{{ route('video.rank') }}">發燒影片</a><span style="color: #595959; font-weight: 300">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a style="color: #595959; font-weight: 300" href="{{ route('video.newest') }}">最新內容</a></h4>
			@elseif (Request::path() == 'newest')
				<h4><a style="text-decoration: none; color: inherit;" href="{{ route('video.newest') }}">最新內容</a><span style="color: #595959; font-weight: 300">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a style="color: #595959; font-weight: 300" href="{{ route('video.rank') }}">發燒影片</a></h4>
			@endif
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