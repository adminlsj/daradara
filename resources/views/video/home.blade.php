@extends('layouts.app')

@section('content')
<div style="width:78%; margin: 0 auto;" class="mobile-container">
	<div class="row home-padding-container" style="padding-top: 24px;padding-bottom: 4px;">
		<div class="col-md-12">
			<h4>
				熱門推薦
				<a href="{{ route('video.trending') }}" style="text-decoration: none; color: #323232;" class="pull-right">
					<i style="color:#323232; vertical-align:middle; font-size: 1.4em; margin-top: -3px; margin-right: -3px;" class="material-icons">bar_chart</i>
					排行榜
					<i style="color:darkgray; vertical-align:middle; font-size: 1em; margin-top: -3px;" class="material-icons">arrow_forward_ios</i>
				</a>
			</h4>
		</div>
	</div>
	<div class="row">
		@foreach ($videos as $video)
			@include('video.singleHomeVideo')
		@endforeach
	</div>

	<div class="row home-padding-container" style="padding-top:4px; padding-bottom: 4px;">
		<div class="col-md-12">
			<h4>
				綜藝推薦
				<a href="{{ route('video.trending') }}?g=variety" style="text-decoration: none; color: #323232;" class="pull-right">
					<i style="color:#323232; vertical-align:middle; font-size: 1.4em; margin-top: -3px; margin-right: -3px;" class="material-icons">bar_chart</i>
					排行榜
					<i style="color:darkgray; vertical-align:middle; font-size: 1em; margin-top: -3px;" class="material-icons">arrow_forward_ios</i>
				</a>
			</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 home-image-container" style="margin-bottom: 15px;">
			<a href="{{ route('video.watch') }}?g=variety">
				<img style="padding:5px 10px; border:1px solid black; border-radius: 5px;" src="https://i.imgur.com/nTVGSmW.jpg" width="100%" height="100%">
			</a>
		</div>
	</div>
	<div class="row">
		@foreach ($variety as $video)
			@include('video.singleHomeVideo')
		@endforeach
	</div>

	<div class="row home-padding-container" style="padding-top:4px; padding-bottom: 4px;">
		<div class="col-md-12">
			<h4>
				日劇推薦
				<a href="{{ route('video.trending') }}?g=drama" style="text-decoration: none; color: #323232;" class="pull-right">
					<i style="color:#323232; vertical-align:middle; font-size: 1.4em; margin-top: -3px; margin-right: -3px;" class="material-icons">bar_chart</i>
					排行榜
					<i style="color:darkgray; vertical-align:middle; font-size: 1em; margin-top: -3px;" class="material-icons">arrow_forward_ios</i>
				</a>
			</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 home-image-container" style="margin-bottom: 15px;">
			<a href="{{ route('video.watch') }}?g=drama">
				<img style="padding:5px 10px; border:1px solid black; border-radius: 5px;" src="https://i.imgur.com/5FBHNqE.jpg" width="100%" height="100%">
			</a>
		</div>
	</div>
	<div class="row">
		@foreach ($drama as $video)
			@include('video.singleHomeVideo')
		@endforeach
	</div>

	<div class="row home-padding-container" style="padding-top:4px; padding-bottom: 4px;">
		<div class="col-md-12">
			<h4>
				動漫推薦
				<a href="{{ route('video.trending') }}?g=anime" style="text-decoration: none; color: #323232;" class="pull-right">
					<i style="color:#323232; vertical-align:middle; font-size: 1.4em; margin-top: -3px; margin-right: -3px;" class="material-icons">bar_chart</i>
					排行榜
					<i style="color:darkgray; vertical-align:middle; font-size: 1em; margin-top: -3px;" class="material-icons">arrow_forward_ios</i>
				</a>
			</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 home-image-container" style="margin-bottom: 15px;">
			<a href="{{ route('video.watch') }}?g=anime">
				<img style="padding:5px 10px; border:1px solid black; border-radius: 5px;" src="https://i.imgur.com/EjXT95P.jpg" width="100%" height="100%">
			</a>
		</div>
	</div>
	<div class="row">
		@foreach ($anime as $video)
			@include('video.singleHomeVideo')
		@endforeach
	</div>


</div>
@endsection