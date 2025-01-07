@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content')
<form id="hentai-form" action="{{ route('anime.search') }}" method="GET">
	<div class="flex-center-wrapper home-wrapper">
		<div class="flex-center-content flex-column">

			@include('nav.home-search')

			<div class="filters-wrap home-search-nav-mobile">
				<div class="filter search">
					<div class="bar" style="position: relative; width: calc(100vw - 95px); height: 42px;">
						<input id="text" name="text" type="text" style="padding-left: 35px;" value="{{ $text ? $text : '' }}" placeholder="搜尋 daradara">
						<input type="submit" style="display: none">
						<i class="fa fa-search" style="color: rgba(201,215,227); font-size: 1.3rem; height: 1.6rem; position: absolute; left: 12px; top: 14px"></i>
					</div>
				</div>

				<div class="filter format" style="position: relative;">
					<div onclick="extra_filter_toggle()" class="extra-filter-wrap no-select" style="background-color: transparent; height: 42px; width: 42px;" type="button" data-toggle="dropdown">
						<div id="home-filter-more-btn" style="height: 42px; width: 42px; margin-top: 0px;">
							<i class="material-icons">tune</i>
						</div>
					</div>
				</div>
			</div>

			<div class="content-wrap">
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
@endsection


