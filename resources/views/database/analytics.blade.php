@extends('layouts.app')

@section('nav')
  @include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')

<div style="margin-top: 20px; margin-left: 45px; margin-right: 45px;">
	<div class="row analytics-row" style="text-align: center; border-top: 1px solid black; background-color: #f5f5f5; font-weight: bold; border-right: 1px solid black; border-left: 1px solid black">
		<div class="col-md-2"></div>
		<div class="col-md-2"><a href="{{ route('database.genre', ['genre' => 'anime']) }}">Anime</a></div>
		<div class="col-md-2"><a href="{{ route('database.genre', ['genre' => 'drama']) }}">Drama</a></div>
		<div class="col-md-2"><a href="{{ route('database.genre', ['genre' => 'variety']) }}">Variety</a></div>
		<div class="col-md-2"><a href="{{ route('database.genre', ['genre' => 'hentai']) }}">Hentai</a></div>
		<div class="col-md-2"><a href="{{ route('database.genre', ['genre' => 'others']) }}">Others</a></div>
		<div class="col-md-2">Total</div>
	</div>

	<div class="row analytics-row" style="text-align: center; border-right: 1px solid black; border-left: 1px solid black">
		<div class="col-md-2">{{ Carbon\Carbon::parse('2020-08-01 00:00:00')->addDays($count)->toDateString() }}</div>
		<div class="col-md-2">{{ $anime = $videos['anime']->sum('views') - array_sum(array_column($ptotals['anime'], $count - 1)) }}</div>
		<div class="col-md-2">{{ $variety = $videos['variety']->sum('views') - array_sum(array_column($ptotals['variety'], $count - 1)) }}</div>
		<div class="col-md-2">{{ $drama = $videos['drama']->sum('views') - array_sum(array_column($ptotals['drama'], $count - 1)) }}</div>
		<div class="col-md-2">{{ $hentai = $videos['hentai']->sum('views') - array_sum(array_column($ptotals['hentai'], $count - 1)) }}</div>
		<div class="col-md-2">{{ $others = $videos['others']->sum('views') - array_sum(array_column($ptotals['others'], $count - 1)) }}</div>
		<div class="col-md-2" style="font-weight: bold">{{ $anime + $variety + $drama + $hentai + $others }}</div>
	</div>

	@for ($i = 0; $i < 5; $i++)
		<div class="row analytics-row" style="text-align: center; border-right: 1px solid black; border-left: 1px solid black">
			<div class="col-md-2">{{ Carbon\Carbon::parse('2020-08-01 00:00:00')->addDays($count - 1)->subdays($i)->toDateString() }}</div>
			<div class="col-md-2">{{ $anime = $totals['anime'][$count - 1 - $i] }}</div>
			<div class="col-md-2">{{ $drama = $totals['drama'][$count - 1 - $i] }}</div>
			<div class="col-md-2">{{ $variety = $totals['variety'][$count - 1 - $i] }}</div>
			<div class="col-md-2">{{ $hentai = $totals['hentai'][$count - 1 - $i] }}</div>
			<div class="col-md-2">{{ $others = $totals['others'][$count - 1 - $i] }}</div>
			<div class="col-md-2" style="font-weight: bold">{{ $anime + $variety + $drama + $hentai + $others }}</div>
		</div>
	@endfor
</div>

@endsection