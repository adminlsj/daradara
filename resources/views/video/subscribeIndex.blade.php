@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['logoImage' => 'https://i.imgur.com/M8tqx5K.png', 'backgroundColor' => 'white', 'itemsColor' => "gray", 'menuBtnColor' => '#595959'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>
<div class="main-content">
	<div style="background-color: #F5F5F5; padding-top: 10px;" class="padding-setup">
		<div class="row no-gutter">
			@foreach ($subscribes as $subscribe)
				<a href="{{ route('video.intro', [$subscribe->watch()->genre, $subscribe->watch()->titleToUrl()]) }}" style="text-decoration: none;">
					<div class="col-xs-1" style="width: 60px; margin: 0px; padding: 0px; text-align: center; margin-right: 15px;">
						<img style="width: 100%; height: auto; border-radius: 50%;" src="{{ $subscribe->watch()->imgurS() }}" alt="{{ $subscribe->watch()->title }}">
						<div class="text-ellipsis" style="width: 100%; font-size: 0.8em; padding-top: 5px; color: gray;">{{ $subscribe->watch()->title }}</div>
					</div>
				</a>
			@endforeach
		</div>
		<hr style="margin-left: -20px; margin-right: -20px; margin-top: 10px; margin-bottom: 20px; border-color: #e5e5e5;">
		<div class="subscribes-tab">
			<a style="margin-right: 5px;">最新内容</a>
			<a>儲存的影片</a>
		</div>
		<hr style="margin-left: -20px; margin-right: -20px; margin-top: 20px; border-color: #e5e5e5;">
	</div>
</div>
@endsection

@section('script')
	@parent
	<script src="{{ mix('js/loadMore.js') }}"></script>
@endsection