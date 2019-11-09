@extends('layouts.app')

@section('content')
<div style="width:78%; margin: 0 auto;" class="mobile-container">
	<div class="row" style="padding-top: 30px">
		@foreach ($videos as $video)
			@include('video.singleHomeVideo')
		@endforeach
	</div>

	<div class="row">
		<div class="col-md-12" style="padding-left: 30px; padding-right: 30px; margin-bottom: 15px;">
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

	<div class="row">
		<div class="col-md-12" style="padding-left: 30px; padding-right: 30px; margin-bottom: 15px;">
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

	<div class="row">
		<div class="col-md-12" style="padding-left: 30px; padding-right: 30px; margin-bottom: 15px;">
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