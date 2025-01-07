@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content')
<form id="hentai-form" action="{{ route('anime.search') }}" method="GET">
	<div class="flex-center-wrapper home-wrapper">
		<div class="flex-center-content flex-column">

			@include('nav.home-search')

			@include('nav.home-search-mobile')

			<div class="content-wrap home-content-wrap">
				@include('home.landing-section', ['title' => '最近流行', 'animes' => $最近流行])
				@include('home.landing-section', ['title' => '本季熱門', 'animes' => $本季熱門])
				@include('home.landing-section', ['title' => '最新上市', 'animes' => $最新上市])
				@include('home.landing-section', ['title' => '大家在看', 'animes' => $大家在看])
			</div>

			<div class="top-anime flex-column hidden-xs hidden-sm">
				<div class="title-link flex-row">
					<a href="">
						<h3>人氣排行</h3>
					</a>
					<a href="">顯示更多</a>
				</div>
				<div class="results">
					@foreach ($人氣排行 as $anime)
						<div class="results-wrap">
							<div class="rank">
								<span>#</span>{{ $anime->id }}
							</div>
							<div class="content">
								<div class="anime-title">
									<a href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->title_ro]) }}"><img
											src="{{ $anime->photo_cover }}" alt=""></a>
									<div class="title-wrap">
										<a
											href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->title_ro]) }}">{{ $anime->title_ro }}</a>
										<div class="genres">
											<a href="">冒險</a>
											<a href="">搞笑</a>
											<a href="">熱血</a>
											<a href="">歷史</a>
										</div>
									</div>
								</div>
								<div class="anime-info">
									<div class="overall-rating" style="font-size:25px;">☻</div>
									<div class="rating">
										<div>95%</div>
										<div style="font-size:13px">182733 用戶</div>
									</div>
									<div class="category">
										<div>季番</div>
										<div style="font-size:13px">21集</div>
									</div>
									<div class="ended-at">
										<div>秋番 2021</div>
										<div style="font-size:13px">播放完結</div>
									</div>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</form>

<br><br>

@include('layouts.nav-bottom')

@endsection


