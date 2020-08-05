@extends('layouts.app')

@section('nav')
  @include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')

<div style="margin-top: 20px; margin-left: 45px; margin-right: 45px;">
	<div class="row analytics-row" style="text-align: center; border-top: 1px solid black; background-color: #f5f5f5; font-weight: bold; border-right: 1px solid black; border-left: 1px solid black">
		<div class="col-md-2" style="width: 20%"></div>
		<div class="col-md-2" style="width: 20%">Anime</div>
		<div class="col-md-2" style="width: 20%">Drama</div>
		<div class="col-md-2" style="width: 20%">Variety</div>
		<div class="col-md-2" style="width: 20%">Hentai</div>
	</div>

	@for ($i = 0; $i < 5; $i++)
		<div class="row analytics-row" style="text-align: center; border-right: 1px solid black; border-left: 1px solid black">
			<div class="col-md-2" style="width: 20%;">{{ Carbon\Carbon::parse('2020-08-01 00:00:00')->addDays($count - 1)->subdays($i)->toDateString() }}</div>
			<div class="col-md-2" style="width: 20%">{{ $totals['anime'][$count - 1 - $i] }}</div>
			<div class="col-md-2" style="width: 20%">{{ $totals['drama'][$count - 1 - $i] }}</div>
			<div class="col-md-2" style="width: 20%">{{ $totals['variety'][$count - 1 - $i] }}</div>
			<div class="col-md-2" style="width: 20%">{{ $totals['hentai'][$count - 1 - $i] }}</div>
		</div>
	@endfor
</div>

@endsection