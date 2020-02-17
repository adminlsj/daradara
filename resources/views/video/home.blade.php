@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['logoImage' => 'https://i.imgur.com/M8tqx5K.png', 'backgroundColor' => 'white', 'itemsColor' => "gray", 'menuBtnColor' => '#595959'])
@endsection

@section('content')
<div class="row">
	<div class="col-lg-2 col-md-2 hidden-sm hidden-xs sidebar-menu">
		@include('video.sidebarMenu', ['theme' => 'white'])
	</div>
	<div class="col-md-10 col-md-offset-2">
		<div style="background-color: #F5F5F5;">
			<div class="padding-setup" style="overflow-x: hidden;">
				<div class="row banner" style="padding-top: 10px; padding-bottom: 10px;">
					<a href="{{ route('video.intro', ['variety', '月曜夜未央']) }}">
						<div class="col-md-12" style="position: relative; background-color: #040A1D">
							<img src="https://i.imgur.com/aUKNJ5x.png" alt="月曜夜未央">
							<div class="button">立即觀看</div>
						</div>
					</a>
				</div>
				<div class="row home-video-wrapper">
					@foreach ($videos as $video)
						@include('video.singleHomeVideo')
					@endforeach
				</div>

				<div class="row" style="padding-top:4px; padding-bottom: 4px;">
					<div class="col-md-12">
						<h4>
							綜藝推薦
							<a href="{{ route('video.rank') }}?g=variety" style="text-decoration: none; color: #323232;" class="pull-right">
								<i style="color:#323232; vertical-align:middle; font-size: 1.4em; margin-top: -3px; margin-right: -3px;" class="material-icons">bar_chart</i>
								排行榜
								<i style="color:darkgray; vertical-align:middle; font-size: 1em; margin-top: -3px;" class="material-icons">arrow_forward_ios</i>
							</a>
						</h4>
					</div>
				</div>
				<div class="row home-video-wrapper">
					@foreach ($variety as $video)
						@include('video.singleHomeVideo')
					@endforeach
				</div>

				<div class="row" style="padding-top:4px; padding-bottom: 4px;">
					<div class="col-md-12">
						<h4>
							日劇推薦
							<a href="{{ route('video.rank') }}?g=drama" style="text-decoration: none; color: #323232;" class="pull-right">
								<i style="color:#323232; vertical-align:middle; font-size: 1.4em; margin-top: -3px; margin-right: -3px;" class="material-icons">bar_chart</i>
								排行榜
								<i style="color:darkgray; vertical-align:middle; font-size: 1em; margin-top: -3px;" class="material-icons">arrow_forward_ios</i>
							</a>
						</h4>
					</div>
				</div>
				<div class="row home-video-wrapper">
					@foreach ($drama as $video)
						@include('video.singleHomeVideo')
					@endforeach
				</div>

				<div class="row" style="padding-top:4px; padding-bottom: 4px;">
					<div class="col-md-12">
						<h4>
							動漫推薦
							<a href="{{ route('video.rank') }}?g=anime" style="text-decoration: none; color: #323232;" class="pull-right">
								<i style="color:#323232; vertical-align:middle; font-size: 1.4em; margin-top: -3px; margin-right: -3px;" class="material-icons">bar_chart</i>
								排行榜
								<i style="color:darkgray; vertical-align:middle; font-size: 1em; margin-top: -3px;" class="material-icons">arrow_forward_ios</i>
							</a>
						</h4>
					</div>
				</div>
				<div class="row home-video-wrapper">
					@foreach ($anime as $video)
						@include('video.singleHomeVideo')
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
@endsection