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