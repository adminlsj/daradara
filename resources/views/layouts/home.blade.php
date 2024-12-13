@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content')
<div class="flex-center-wrapper home-wrapper">
	<div class="flex-center-content flex-column" style="margin-top: 100px;">
		<div class="filters-wrap">
			<div class="filters">
				<div class="filter search">
					<h3>搜尋</h3>
					<div class="bar" style="position: relative;">
						<input type="search" style="padding-left: 35px;">
						<i class="fa fa-search" style="color: rgba(201,215,227); font-size: 1.3rem; height: 1.6rem; position: absolute; left: 12px; top: 12px"></i>
					</div>
				</div>
				<div class="filter genres">
					<h3>分類標籤</h3>
					<div class="bar">
						<input type="search" placeholder="輸入類別..."
							onclick="document.getElementById('option-genres').style.display='block'" id="genreInput">
						<div class="scroll-wrap" id="option-genres">
							<div class="option-group">
								<h3>分類</h3>
								@foreach (App\Anime::$genres as $genre)
									<option value="{{ $genre }}">{{ $genre }}</option>
								@endforeach
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

				<div class="filter year" style="position: relative;">
					<h3>播出年份</h3>
					<button style="outline:0; color: rgb(173,192,210); padding: 0px 14px 5px 14px;" class="bar btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
						<div style="margin-top: -1px; display: inline-block; float: left; font-weight: 500;">{{ $year ? $year.' 年' : '全部' }}</div>
						<i class="material-icons home-search-arrow">keyboard_arrow_down</i>
					</button>
					<div id="search-year-dropdown" class="dropdown-menu home-option-wrapper">
						<input type="hidden" id="year" name="year" value="{{ $year }}">
						<div class="home-option year-option">全部</div>
						@for ($i = Carbon\Carbon::now()->year + 1; $i >= 1917; $i--)
					        <div class="home-option year-option">{{ $i }}</div>
					    @endfor
					</div>
				</div>

				<div class="filter season" style="position: relative;">
					<h3>播放季度</h3>
					<button style="outline:0; color: rgb(173,192,210); padding: 0px 14px 5px 14px;" class="bar btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
						<div style="margin-top: -1px; display: inline-block; float: left; font-weight: 500;">{{ $season ? $season : '全部' }}</div>
						<i class="material-icons home-search-arrow">keyboard_arrow_down</i>
					</button>
					<div id="search-season-dropdown" class="dropdown-menu home-option-wrapper">
						<input type="hidden" id="season" name="season" value="{{ $season }}">
						<div class="home-option season-option">全部</div>
						<div class="home-option season-option">1月冬番</div>
						<div class="home-option season-option">4月春番</div>
						<div class="home-option season-option">7月夏番</div>
						<div class="home-option season-option">10月秋番</div>
					</div>
				</div>

				<div class="filter format" style="position: relative;">
					<h3>類型</h3>
					<button style="outline:0; color: rgb(173,192,210); padding: 0px 14px 5px 14px;" class="bar btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
						<div style="margin-top: -1px; display: inline-block; float: left; font-weight: 500;">{{ $category ? $category : '全部' }}</div>
						<i class="material-icons home-search-arrow">keyboard_arrow_down</i>
					</button>
					<div id="search-category-dropdown" class="dropdown-menu home-option-wrapper">
						<input type="hidden" id="category" name="category" value="{{ $category }}">
						<div class="home-option category-option">全部</div>
						@foreach (['TV', 'Movie', 'TV Special', 'Special', 'OVA', 'ONA', 'Music', 'PV', 'CM', 'Unknown'] as $category)
							<div class="home-option category-option">{{ $category }}</div>
						@endforeach
					</div>
				</div>
			</div>
			<div class="extra-filter-wrap" style="background-color: transparent;">
				<div id="home-filter-more-btn" onclick="document.getElementById('extra-filter-dropdown').style.display = 'flex';">
					<i class="material-icons">tune</i>
				</div>
			</div>
		</div>
		<div class="extra-filter-dropdown" id="extra-filter-dropdown">
			<form action="">
				<button type="button" style="float:right;"
					onclick="document.getElementById('extra-filter-dropdown').style.display = 'none';">X</button>
				<div class="filters">
					<div class="filters-wrap">
						<div class="filter airing-status">
							<h3>播放狀態</h3>
							<div class="bar">
								<input type="search" placeholder="輸入狀態..."
									onclick="document.getElementById('option-airing-status').style.display='block'"
									id="airingStatusInput">
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
									onclick="document.getElementById('option-country-origin').style.display='block'"
									id="countryOriginInput">
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
						<h3>最近流行<span class="title-link-expand pull-right">顯示更多</span></h3>
					</a>
				</div>
				<div class="media-wrap">
					@foreach ($最近流行 as $anime)
						@include('layouts.media-card')
					@endforeach
				</div>
			</div>
			<div class="landing-section">
				<div class="title-link">
					<a href="">
						<h3>本季熱門<span class="title-link-expand pull-right">顯示更多</span></h3>
					</a>
				</div>
				<div class="media-wrap">
					@foreach ($本季熱門 as $anime)
						@include('layouts.media-card')
					@endforeach
				</div>
			</div>
			<div class="landing-section">
				<div class="title-link">
					<a href="">
						<h3>經典作品<span class="title-link-expand pull-right">顯示更多</span></h3>
					</a>
				</div>
				<div class="media-wrap">
					@foreach ($最新上市 as $anime)
						@include('layouts.media-card')
					@endforeach
				</div>
			</div>
		</div>
		<div class="top-anime flex-column">
			<div class="title-link flex-row">
				<a href="">
					<h3>人氣排行</h3>
				</a>
				<a href="">顯示更多</a>
			</div>
			<div class="results">
				@foreach ($最新上傳 as $anime)
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
@endsection


