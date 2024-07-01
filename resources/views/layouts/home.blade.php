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
			<button onclick="document.getElementById('extra-filter-dropdown').style.display = 'flex';"><i
					class="fa-thin fa-filter"></i></button>
		</div>
	</div>
	<div class="extra-filter-dropdown" id="extra-filter-dropdown">
		<form action="">
			<button type="button" style="float:right;" onclick="document.getElementById('extra-filter-dropdown').style.display = 'none';">X</button>
			<div class="filters">
				<div class="filters-wrap">
					<div class="filter airing-status">
						<h3>播放狀態</h3>
						<div class="bar">
							<input type="search" placeholder="輸入狀態..."
								onclick="document.getElementById('option-airing-status').style.display='block'">
							<div class="scroll-wrap" id="option-airing-status">
								<div class="option-group">
									<option value="播放中">播放中</option>
									<option value="完結">完結</option>
									<option value="製作中">製作中</option>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="filters-wrap">
					<div class="filter country-origin">
						<h3>國家</h3>
						<div class="bar">
							<input type="search" placeholder="輸入國家..."
								onclick="document.getElementById('option-country-origin').style.display='block'">
							<div class="scroll-wrap" id="option-country-origin">
								<div class="option-group">
									<option value="日本">日本</option>
									<option value="韓國">韓國</option>
									<option value="美國">美國</option>
									<option value="中國">中國</option>
									<option value="其他">其他</option>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="filters">
				<div class="filters-wrap range">
					<div class="filter">
						<h3>年份</h3>
						<div class="bar">
							<input type="range" min="1970" max="2025" value="2025">
						</div>
					</div>
					<div class="filter">
						<h3>集數</h3>
						<div class="bar">
							<input type="range" min="1" max="150" value="150">
						</div>
					</div>
					<div class="filter">
						<h3>時長</h3>
						<div class="bar">
							<input type="range" min="1" max="170" value="170">
						</div>
					</div>
				</div>
			</div>
			<div class="filters">
				<div class="filters-wrap checkbox">
					<div class="filter">
						<div class="bar">
							<input type="checkbox" id="doujin" name="doujin" value="doujin">
							<label for="doujin"> 同人</label><br>
						</div>
					</div>
					<div class="filter">
						<div class="bar">
							<input type="checkbox" id="showAnimeList" name="showAnimeList" value="showAnimeList">
							<label for="showAnimeList"> 顯示收藏動漫</label><br>
						</div>
					</div>
					<div class="filter">
						<div class="bar">
							<input type="checkbox" id="hideAnimeList" name="hideAnimeList" value="hideAnimeList">
							<label for="hideAnimeList"> 隱藏收藏動漫</label><br>
						</div>
					</div>
					<div class="filter">
						<div class="bar">
							<input type="checkbox" id="adult" name="adult" value="adult">
							<label for="adult"> 成人</label><br>
						</div>
					</div>
				</div>
			</div>
		</form>
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
		var optionAiringStatus = document.getElementById('option-airing-status');
		var optionCountryOrigin = document.getElementById('option-country-origin');

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
		else if (event.target === optionAiringStatus) {
			optionAiringStatus.style.display = 'block';
		}
		else if (event.target === optionCountryOrigin) {
			optionCountryOrigin.style.display = 'block';
		}

		optionGenres.style.display = 'none';
		optionYears.style.display = 'none';
		optionSeasons.style.display = 'none';
		optionFormats.style.display = 'none';
		optionAiringStatus.style.display = 'none';
		optionCountryOrigin.style.display = 'none';
	});  
</script>