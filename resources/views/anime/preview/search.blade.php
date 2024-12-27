<div class="filters-wrap">
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

		<div class="filter format" style="position: relative;">
			<h3>類型</h3>
			<button style="outline:0; color: rgb(173,192,210); padding: 0px 14px 5px 14px;" class="bar btn btn-secondary dropdown-toggle close-extra-filter-dropdown-menu" type="button" data-toggle="dropdown">
				<div class="filter-value-text {{ $category ? 'active' : '' }}">{{ $category ? $category : '全部' }}</div>
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

        <div class="filter format" style="position: relative;">
			<h3>聲優</h3>
			<button style="outline:0; color: rgb(173,192,210); padding: 0px 14px 5px 14px;" class="bar btn btn-secondary dropdown-toggle close-extra-filter-dropdown-menu" type="button" data-toggle="dropdown">
				<div class="filter-value-text {{ $category ? 'active' : '' }}">{{ $category ? $category : '全部' }}</div>
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


	<div class="filter format" style="position: relative;">
		<div onclick="extra_filter_toggle()" class="extra-filter-wrap no-select" style="background-color: transparent;" type="button" data-toggle="dropdown">
			<div id="home-filter-more-btn">
                <i class="fa fa-sort"></i>
			</div>
		</div>
		
	</div>

	<script>
		function extra_filter_toggle() {
			document.getElementById("extra-filter-dropdown").classList.toggle("show");
		}
	</script>
</div>