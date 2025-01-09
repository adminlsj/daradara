<div class="filters-wrap home-search-nav">
	<div class="filters">
		<div class="filter search">
			<h3>搜尋</h3>
			<div class="bar" style="position: relative;">
				<input id="text" name="text" type="text" style="padding-left: 35px;" value="{{ $text ? $text : '' }}">
				<input type="submit" style="display: none">
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
			<button style="outline:0; color: rgb(173,192,210); padding: 0px 14px 5px 14px;" class="bar btn btn-secondary dropdown-toggle close-extra-filter-dropdown-menu" type="button" data-toggle="dropdown">
				<div class="filter-value-text {{ $year ? 'active' : '' }}">{{ $year ? $year.' 年' : '全部' }}</div>
				<i class="material-icons home-search-arrow">keyboard_arrow_down</i>
			</button>
			<div id="search-year-dropdown" class="dropdown-menu home-option-wrapper">
				<input type="hidden" id="year" name="year" value="{{ $year }}">
				<div class="home-option year-option" data-input="year">全部</div>
				@for ($i = Carbon\Carbon::now()->year + 1; $i >= 1917; $i--)
			        <div class="home-option year-option" data-input="year">{{ $i }}</div>
			    @endfor
			</div>
		</div>

		<div class="filter season" style="position: relative;">
			<h3>播放季度</h3>
			<button style="outline:0; color: rgb(173,192,210); padding: 0px 14px 5px 14px;" class="bar btn btn-secondary dropdown-toggle close-extra-filter-dropdown-menu" type="button" data-toggle="dropdown">
				<div class="filter-value-text {{ $season ? 'active' : '' }}">{{ $season ? $season : '全部' }}</div>
				<i class="material-icons home-search-arrow">keyboard_arrow_down</i>
			</button>
			<div id="search-season-dropdown" class="dropdown-menu home-option-wrapper">
				<input type="hidden" id="season" name="season" value="{{ $season }}">
				@foreach (['全部', '1月冬番', '4月春番', '7月夏番', '10月秋番'] as $option)
					<div class="home-option season-option" data-input="season">{{ $option }}</div>
				@endforeach
			</div>
		</div>

		<div class="filter category" style="position: relative;">
			<h3>類型</h3>
			<button style="outline:0; color: rgb(173,192,210); padding: 0px 14px 5px 14px;" class="bar btn btn-secondary dropdown-toggle close-extra-filter-dropdown-menu" type="button" data-toggle="dropdown">
				<div class="filter-value-text {{ $category ? 'active' : '' }}">{{ $category ? $category : '全部' }}</div>
				<i class="material-icons home-search-arrow">keyboard_arrow_down</i>
			</button>
			<div id="search-category-dropdown" class="dropdown-menu home-option-wrapper">
				<input type="hidden" id="category" name="category" value="{{ $category }}">
				@foreach (['全部', 'TV', 'Movie', 'TV Special', 'Special', 'OVA', 'ONA', 'Music', 'PV', 'CM', 'Unknown'] as $category)
					<div class="home-option category-option" data-input="category">{{ $category }}</div>
				@endforeach
			</div>
		</div>
	</div>


	<div class="filter format" style="position: relative;">
		<div onclick="extra_filter_toggle()" class="extra-filter-wrap no-select" style="background-color: transparent;" type="button" data-toggle="dropdown">
			<div id="home-filter-more-btn">
				<i class="material-icons">tune</i>
			</div>
		</div>
		<div id="extra-filter-dropdown" class="extra-filter-dropdown-menu home-option-wrapper" style="overflow: visible;">

			<div>
				<div class="filter airing" style="position: relative; display: inline-block;">
					<h3>播放狀態</h3>
					<button class="bar btn btn-secondary dropdown-toggle extra-filter-btn" type="button" data-toggle="dropdown">
						<div class="filter-value-text {{ $airing_status ? 'active' : '' }}">{{ $airing_status ? $airing_status : '全部' }}</div>
						<i class="material-icons home-search-arrow">keyboard_arrow_down</i>
					</button>
					<div id="airing-status-dropdown" class="dropdown-menu home-option-wrapper" style="width: 180px">
						<input type="hidden" id="airing_status" name="airing_status" value="{{ $airing_status }}">
						@foreach (['全部', 'Currently Airing', 'Finished Airing', 'Not yet aired', 'Cancelled'] as $airing_status)
							<div class="home-option airing-status-option" data-input="airing_status">{{ $airing_status }}</div>
						@endforeach
					</div>
				</div>

				<div class="filter streaming" style="position: relative; display: inline-block; margin-left: 30px;">
					<h3>串流平台</h3>
					<button class="bar btn btn-secondary dropdown-toggle extra-filter-btn" type="button" data-toggle="dropdown">
						<div class="filter-value-text {{ $streaming_on ? 'active' : '' }}">{{ $streaming_on ? $streaming_on : '全部' }}</div>
						<i class="material-icons home-search-arrow">keyboard_arrow_down</i>
					</button>
					<div id="streaming-on-dropdown" class="dropdown-menu home-option-wrapper" style="width: 180px">
						<input type="hidden" id="streaming_on" name="streaming_on" value="{{ $streaming_on }}">
						<div class="home-option streaming-on-option">全部</div>
					</div>
				</div>
			</div>

			<div style="margin-top: 20px">
				<div class="filter country" style="position: relative; display: inline-block;">
					<h3>原產國家</h3>
					<button class="bar btn btn-secondary dropdown-toggle extra-filter-btn" type="button" data-toggle="dropdown">
						<div class="filter-value-text {{ $country ? 'active' : '' }}">{{ $country ? $country : '全部' }}</div>
						<i class="material-icons home-search-arrow">keyboard_arrow_down</i>
					</button>
					<div id="country-dropdown" class="dropdown-menu home-option-wrapper" style="width: 180px;">
						<input type="hidden" id="country" name="country" value="{{ $country }}">
						<div class="home-option country-option">全部</div>
					</div>
				</div>

				<div class="filter source" style="position: relative; display: inline-block; margin-left: 30px;">
					<h3>原作素材</h3>
					<button class="bar btn btn-secondary dropdown-toggle extra-filter-btn" type="button" data-toggle="dropdown">
						<div class="filter-value-text {{ $source ? 'active' : '' }}">{{ $source ? $source : '全部' }}</div>
						<i class="material-icons home-search-arrow">keyboard_arrow_down</i>
					</button>
					<div id="source-dropdown" class="dropdown-menu home-option-wrapper" style="width: 180px">
						<input type="hidden" id="source" name="source" value="{{ $source }}">
						<div class="home-option source-option">全部</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		function extra_filter_toggle() {
			document.getElementById("extra-filter-dropdown").classList.toggle("show");
		}
	</script>
</div>