@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['logoImage' => 'https://i.imgur.com/M8tqx5K.png', 'backgroundColor' => 'white', 'itemsColor' => "gray"])
@endsection

@section('content')
<div class="padding-setup mobile-container">
	<div class="row" style="padding-top: 6px; padding-bottom: 4px">
		<div class="col-md-12">
			<h4>
				熱門推薦
				<a href="{{ route('video.rank') }}" style="text-decoration: none; color: #323232;" class="pull-right">
					<i style="color:#323232; vertical-align:middle; font-size: 1.4em; margin-top: -3px; margin-right: -3px;" class="material-icons">bar_chart</i>
					排行榜
					<i style="color:darkgray; vertical-align:middle; font-size: 1em; margin-top: -3px;" class="material-icons">arrow_forward_ios</i>
				</a>
			</h4>
		</div>
	</div>
	<div style="padding-left: 7.5px; padding-right: 7.5px;" class="row">
		@foreach ($videos as $video)
			@include('video.singleHomeVideo', ['lazy' => false])
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
	<div style="padding-left: 7.5px; padding-right: 7.5px;" class="row">
		@foreach ($variety as $video)
			@include('video.singleHomeVideo', ['lazy' => true])
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
	<div style="padding-left: 7.5px; padding-right: 7.5px;" class="row">
		@foreach ($drama as $video)
			@include('video.singleHomeVideo', ['lazy' => true])
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
	<div style="padding-left: 7.5px; padding-right: 7.5px;" class="row">
		@foreach ($anime as $video)
			@include('video.singleHomeVideo', ['lazy' => true])
		@endforeach
	</div>


</div>
@endsection