@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content')
<div class="page-content">
	<div class="filters-wrap">
		<div class="filters">
			<div class="filter search">
				<h3>搜尋</h3>
				<div class="bar">
					<input type="search" placeholder="輸入關鍵字...">
				</div>
			</div>
			<div class="filter genres">
				<h3>類別</h3>
				<div class="bar">
					<input type="search" placeholder="輸入類別..."
						onclick="document.getElementById('option-genres').style.display='block'">
					<div class="scroll-wrap" id="option-genres">
						<div class="option-group">
							<h3>類別</h3>
							<option value="動作">動作</option>
							<option value="戀愛">戀愛</option>
							<option value="搞笑">搞笑</option>
						</div>
						<div class="option-group">
							<h3>標籤</h3>
							<option value="動作">動作</option>
							<option value="戀愛">戀愛</option>
							<option value="搞笑">搞笑</option>
							<option value="幻想">幻想</option>
						</div>
					</div>
				</div>
			</div>
			<div class="filter year">
				<h3>年份</h3>
				<div class="bar">
					<input type="search" placeholder="輸入年份..."
						onclick="document.getElementById('option-years').style.display='block'">
					<div class="scroll-wrap" id="option-years">
						<div class="option-group">
							<option value="2025">2025</option>
							<option value="2024">2024</option>
							<option value="2023">2023</option>
						</div>
					</div>
				</div>
			</div>
			<div class="filter season">
				<h3>季節</h3>
				<div class="bar">
					<input type="search" placeholder="輸入季節..."
						onclick="document.getElementById('option-seasons').style.display='block'">
					<div class="scroll-wrap" id="option-seasons">
						<div class="option-group">
							<option value="春季">春季</option>
							<option value="夏季">夏季</option>
							<option value="秋季">秋季</option>
							<option value="冬季">冬季</option>
						</div>
					</div>
				</div>
			</div>
			<div class="filter format">
				<h3>動畫類別</h3>
				<div class="bar">
					<input type="search" placeholder="輸入類別..."
						onclick="document.getElementById('option-formats').style.display='block'">
					<div class="scroll-wrap" id="option-formats">
						<div class="option-group">
							<option value="季番">季番</option>
							<option value="電影">電影</option>
							<option value="OVA">OVA</option>
							<option value="特別篇">特別篇</option>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="extra-filter-wrap">
			<button><i class="fa-thin fa-filter"></i></button>
		</div>
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
				@foreach ($最近更新 as $anime)
					<div class="media-card">
						<a href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->title_ro]) }}">
							<img src="{{ $anime->photo_cover }}" alt="">
						</a>
						<div class="button-wrap">
							<div class="button-list">
								<button>+</button>
							</div>
						</div>
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
				@foreach ($本季流行 as $anime)
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
@endsection

<script>
	window.addEventListener('mouseup', function (event) {
		var optionGenres = document.getElementById('option-genres');
		var optionYears = document.getElementById('option-years');
		var optionSeasons = document.getElementById('option-seasons');
		var optionFormats = document.getElementById('option-formats');

		if (event.target === optionGenres) {
			optionGenres.style.display = 'block';
		}
		else if (event.target === optionYears) {
			optionYears.style.display = 'block';
		}
		else if (event.target === optionSeasons) {
			optionSeasons.style.display = 'block';
		}
		else if (event.target === optionFormats) {
			optionFormats.style.display = 'block';
		}
		optionGenres.style.display = 'none';
		optionYears.style.display = 'none';
		optionSeasons.style.display = 'none';
		optionFormats.style.display = 'none';
	});  
</script>