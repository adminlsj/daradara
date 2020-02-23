@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['logoImage' => 'https://i.imgur.com/M8tqx5K.png', 'backgroundColor' => 'white', 'itemsColor' => "gray", 'menuBtnColor' => '#595959'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>
<div class="main-content" style="background-color: #F5F5F5;">
	<div style="padding-top: 10px;">
		<div class="row no-gutter padding-setup">
			@foreach ($subscribes as $subscribe)
				<a href="{{ route('video.intro', [$subscribe->watch()->genre, $subscribe->watch()->titleToUrl()]) }}" style="text-decoration: none;">
					<div class="col-xs-1" style="width: 60px; margin: 0px; padding: 0px; text-align: center; margin-right: 15px; margin-bottom: 10px">
						<img style="width: 100%; height: auto; border-radius: 50%;" src="{{ $subscribe->watch()->imgurS() }}" alt="{{ $subscribe->watch()->title }}">
						<div class="text-ellipsis" style="width: 100%; font-size: 0.8em; padding-top: 5px; color: dimgray;">{{ $subscribe->watch()->title }}</div>
					</div>
				</a>
			@endforeach
		</div>
		<hr style="margin: 0px 0px 16px 0px; border-color: #e5e5e5;">
		<div class="subscribes-tab padding-setup">
			<a href="{{ route('video.subscribes') }}?m=newest" class="{{ Request::is('*subscribes*') ? 'active' : '' }}" style="margin-right: 5px;">最新内容</a>
			<!-- <a href="#">儲存的影片</a>-->
		</div>
		<hr style="margin: 15px 0px 0px 0px; border-color: #e5e5e5;">
		@foreach ($videos as $video)
			<div style="margin-bottom: 30px;">
				<a href="{{ route('video.watch') }}?v={{ $video->id }}" style="text-decoration: none;">
					<img class="lazy" style="width: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurH() }}" data-srcset="{{ $video->imgurH() }}" alt="{{ $video->title }}">
				</a>

				<div class="padding-setup" style="margin-top: 10px">
					<a href="{{ route('video.intro', [$video->genre, $video->watch()->titleToUrl()]) }}" style="text-decoration: none;">
						<img style="width: 45px; height: auto; float: left; border-radius: 50%;" src="https://i.imgur.com/{{ $video->watch()->imgur }}s.jpg" alt="{{ $video->watch()->title }}">
					</a>
					<a href="{{ route('video.watch') }}?v={{ $video->id }}" style="text-decoration: none; color: black;">
						<div style="margin-left: 53px; font-size: 1.1em; line-height: 19px">{{ $video->title }}</div>
						<div style="margin-left: 53px; font-size: 0.85em; color: dimgray; margin-top: 3px;">{{ $video->watch()->title }} • 收看次數：{{ $video->views() }} • {{ Carbon\Carbon::parse($video->created_at)->diffForHumans() }}</div>
					</a>
				</div>
			</div>
		@endforeach
	</div>
</div>
@endsection

@section('script')
	@parent
	<script src="{{ mix('js/loadMore.js') }}"></script>
@endsection