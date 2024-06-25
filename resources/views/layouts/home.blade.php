@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content')
<div class="page-content">
	<div class="filters-wrap">

	</div>
	<div class="content-wrap">
		<div class="landing-section">
			<div class="title-link">
				<a href="">
					<h3>最近更新</h3>
				</a>
				<a href="">顯示更多</a>
			</div>
			<div class="media-wrap">
				@foreach ($animes as $anime)
					<div class="media-card">
						<a href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->title_ro]) }}">
							<img src="{{ $anime->photo_cover }}" alt="">
						</a>
						<a href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->title_ro]) }}">{{ $anime->title_ro }}
						</a>
					</div>
				@endforeach
			</div>
		</div>
		<div class="landing-section">
			<div class="title-link">
				<a href="">
					<h3>本季流行</h3>
				</a>
				<a href="">顯示更多</a>
			</div>
			<div class="media-wrap">
				@foreach ($animes as $anime)
					<div class="media-card">
						<a href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->title_ro]) }}">
							<img src="{{ $anime->photo_cover }}" alt="">
						</a>
						<a href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->title_ro]) }}">{{ $anime->title_ro }}
						</a>
					</div>
				@endforeach
			</div>
		</div>
		<div class="landing-section">
			<div class="title-link">
				<a href="">
					<h3>經典作品</h3>
				</a>
				<a href="">顯示更多</a>
			</div>
			<div class="media-wrap">
				@foreach ($animes as $anime)
					<div class="media-card">
						<a href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->title_ro]) }}">
							<img src="{{ $anime->photo_cover }}" alt="">
						</a>
						<a href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->title_ro]) }}">{{ $anime->title_ro }}
						</a>
					</div>
				@endforeach
			</div>
		</div>
	</div>
	<div class="top-anime">
		<div class="title-link">
			<a href="">
				<h3>人氣排行</h3>
			</a>
			<a href="">顯示更多</a>
		</div>
		<div class="results">
			@foreach ($animes as $anime)
				<div class="results-wrap">
					<div class="rank">
						<span>#</span>{{ $anime->id }}
					</div>
					<div class="content">
						<div class="anime-title">
							<a href=""><img src="{{ $anime->photo_cover }}" alt=""></a>
							<div class="title-wrap">
								<a href="">{{ $anime->title_ro }}</a>
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

<!--
		<div class="row">
			@foreach ($animes as $anime)
				<div class="col-md-2">
					<a href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->title_ro]) }}">
						<div style="position: relative;">
							<img style="width: 100%; margin-top: 0;" src="https://images2.imgbox.com/0c/85/A2O2FiGg_o.jpg">
							<img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; margin-top: 0;" src="{{ $anime->photo_cover }}">
					    </div>
						<div style="height: 40px">{{ $anime->title_ro }}</div>
					</a>
					<br>
				</div>
			@endforeach
		</div>
		
		<div class="search-pagination mobile-search-pagination">{{ $animes->links() }}</div>
				-->

@endsection