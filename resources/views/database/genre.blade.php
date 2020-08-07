@extends('layouts.app')

@section('nav')
  @include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')

<div style="margin-top: 20px; margin-left: 45px; margin-right: 45px; padding-bottom: 20px;">

	<div style="margin-left: -15px; font-size: 20px; font-weight: bold; padding-bottom: 10px">{{ $genre }} videos ranking</div>

	<div class="row analytics-genre-row" style="text-align: center; border-top: 1px solid black; background-color: #f5f5f5; font-weight: bold; border-right: 1px solid black; border-left: 1px solid black">
		<div class="col-md-3"></div>
		<div class="col-md-2">{{ Carbon\Carbon::parse('2020-08-01 00:00:00')->addDays($count - 1)->toDateString() }}</div>
		<div class="col-md-2">{{ Carbon\Carbon::parse('2020-08-01 00:00:00')->addDays($count - 2)->toDateString() }}</div>
		<div class="col-md-2">{{ Carbon\Carbon::parse('2020-08-01 00:00:00')->addDays($count - 3)->toDateString() }}</div>
		<div class="col-md-2">{{ Carbon\Carbon::parse('2020-08-01 00:00:00')->addDays($count - 4)->toDateString() }}</div>
		<div class="col-md-2">{{ Carbon\Carbon::parse('2020-08-01 00:00:00')->addDays($count - 5)->toDateString() }}</div>
	</div>

	@foreach ($videos as $video)
		<div class="row analytics-genre-row" style="text-align: center; border-right: 1px solid black; border-left: 1px solid black">
			<div class="col-md-3" style="text-align:left;">{{ $video['title'] }}</div>
			<div class="col-md-2">{{ $video['data']['views']['increment'][$count - 1] }}</div>
			<div class="col-md-2">{{ $video['data']['views']['increment'][$count - 2] }}</div>
			<div class="col-md-2">{{ $video['data']['views']['increment'][$count - 3] }}</div>
			<div class="col-md-2">{{ $video['data']['views']['increment'][$count - 4] }}</div>
			<div class="col-md-2">{{ $video['data']['views']['increment'][$count - 5] }}</div>
		</div>
	@endforeach
</div>

@endsection