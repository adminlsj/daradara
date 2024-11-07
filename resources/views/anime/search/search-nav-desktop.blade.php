<div id="search-nav-desktop" style="margin-bottom: 35px; padding-top: 10px; padding-bottom: 6px; position: fixed; margin-top: 65px; z-index: 100000; overflow: block" class="search-nav-wrapper hidden-xs">

	<div class="dropdown no-select" style="display: inline-block; padding: 0;">
		<button style="color: white; font-size: 38px; font-weight: 500 !important; display: inline-block; margin-right: 35px; background-color: transparent; outline: 0; border: 0; padding-left: 0px;" type="button" data-toggle="modal" data-target="#genre-modal">
			動漫
			<!-- <i class="material-icons" style="vertical-align: middle; margin-top: -5px; margin-left: 0px;">arrow_drop_down</i> -->
		</button>
	</div>

	<div class="dropdown no-select" style="display: inline-block; padding: 0;">
		<button style="outline:0; color:white; margin-top: -18px;" class="btn btn-secondary dropdown-toggle search-nav-desktop" type="button" data-toggle="modal" data-target="#tags">
			標籤
			<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 16px; margin-right: -7px">arrow_drop_down</i>
		</button>
	</div>

	<div class="dropdown no-select" style="display: inline-block; padding: 0; position: relative; z-index: 100000 !important;">
		<button style="outline:0; color:white; margin-top: -18px;" class="btn btn-secondary dropdown-toggle search-nav-desktop" type="button" data-toggle="dropdown">
			{{ $year ? $year.' 年' : '年份' }}
			<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 16px; margin-right: -7px">arrow_drop_down</i>
		</button>
		<div id="search-year-dropdown" class="dropdown-menu" style="position: absolute; top: 18px; background-color: rgba(0,0,0,.9); border: 1px solid #282828; opacity: 1; min-width: 87px; height: 250px; padding: 5px 10px; overflow-y: scroll; border-radius: 0px;">
			<input type="hidden" id="year" name="year" value="{{ $year }}">
			@for ($i = Carbon\Carbon::now()->year + 1; $i >= 1917; $i--)
		        <div class="year-option">{{ $i }}</div>
		    @endfor
		</div>
	</div>

	<div class="dropdown no-select" style="display: inline-block; padding: 0; position: relative; z-index: 100000 !important;">
		<button style="outline:0; color:white; margin-top: -18px;" class="btn btn-secondary dropdown-toggle search-nav-desktop" type="button" data-toggle="dropdown">
			{{ $season ? $season : '季度' }}
			<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 16px; margin-right: -7px">arrow_drop_down</i>
		</button>
		<div id="search-season-dropdown" class="dropdown-menu" style="position: absolute; top: 18px; background-color: rgba(0,0,0,.9); border: 1px solid #282828; opacity: 1; min-width: 101px; height: 132px; padding: 5px 10px; overflow-y: scroll; border-radius: 0px;">
			<input type="hidden" id="season" name="season" value="{{ $season }}">
			<div class="season-option">1月冬番</div>
			<div class="season-option">4月春番</div>
			<div class="season-option">7月夏番</div>
			<div class="season-option">10月秋番</div>
		</div>
	</div>

	<div class="dropdown no-select" style="display: inline-block; padding: 0; position: relative; z-index: 100000 !important;">
		<button style="outline:0; color:white; margin-top: -18px;" class="btn btn-secondary dropdown-toggle search-nav-desktop" type="button" data-toggle="dropdown">
			{{ $category ? $category : '類型' }}
			<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 16px; margin-right: -7px">arrow_drop_down</i>
		</button>
		<div id="search-category-dropdown" class="dropdown-menu" style="position: absolute; top: 18px; background-color: rgba(0,0,0,.9); border: 1px solid #282828; opacity: 1; min-width: 96px; height: 250px; padding: 5px 10px; overflow-y: scroll; border-radius: 0px;">
			<input type="hidden" id="category" name="category" value="{{ $category }}">
			@foreach (['TV', 'Movie', 'TV Special', 'Special', 'OVA', 'ONA', 'Music', 'PV', 'CM', 'Unknown'] as $category)
				<div class="category-option">{{ $category }}</div>
			@endforeach
		</div>
	</div>

	<div class="dropdown no-select" style="display: inline-block; padding: 0; position: relative; z-index: 100000 !important;">
		<button style="outline:0; color:white; margin-top: -18px;" class="btn btn-secondary dropdown-toggle search-nav-desktop" type="button" data-toggle="dropdown">
			{{ $sort ? '依'.$sort.'排序' : '排序'}}
			<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 16px; margin-right: -7px">arrow_drop_down</i>
		</button>
		<div id="search-sort-dropdown" class="dropdown-menu" style="position: absolute; top: 18px; background-color: rgba(0,0,0,.9); border: 1px solid #282828; opacity: 1; min-width: 87px; height: 222px; padding: 5px 10px; overflow-y: scroll; border-radius: 0px;">
			<input type="hidden" id="sort" name="sort" value="{{ $sort }}">
			@foreach (['標題', '人氣', '評分', '流行', '讚好', '上傳日期', '上市日期'] as $sort)
				<div class="sort-option">{{ $sort }}</div>
			@endforeach
		</div>
	</div>

	<!-- <div class="dropdown no-select" style="display: inline-block; padding: 0;">
		<button style="outline:0; color:white; margin-top: -18px;" class="btn btn-secondary dropdown-toggle search-nav-desktop" type="button" data-toggle="modal" data-target="#date-modal">
			狀態
			<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 16px; margin-right: -7px">arrow_drop_down</i>
		</button>
	</div>

	<div class="dropdown no-select" style="display: inline-block; padding: 0;">
		<button style="outline:0; color:white; margin-top: -18px;" class="btn btn-secondary dropdown-toggle search-nav-desktop" type="button" data-toggle="modal" data-target="#date-modal">
			原作
			<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 16px; margin-right: -7px">arrow_drop_down</i>
		</button>
	</div> -->

	<div class="dropdown no-select" style="display: inline-block; padding: 0;">
		<button style="outline:0; color:white; margin-top: -18px;" class="btn btn-secondary dropdown-toggle search-nav-desktop" type="button" data-toggle="modal" data-target="#sort-modal">
			<i class="material-icons" style="vertical-align: middle; margin-left: 5px; margin-right: 5px; font-size: 20px; padding-bottom: 2px; margin-top: -2px;">tune</i>
		</button>
	</div>

	<div class="dropdown no-select search-nav-opacity hidden-md hidden-lg hidden-xl scrollable-search-type-button" style="display: inline-block; padding: 0; margin-left: 7px;">
		<button style="outline:0; color:white; padding: 5px 11px 5px 12px; background-color: rgba(0,0,0,.1); margin-top: -18px;" class="btn btn-secondary dropdown-toggle search-nav-desktop search-type-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<span class="search-type-input">搜尋作者</span>
			<img style="width: 15px; margin-top: -3px; margin-left: 12px" src="https://vdownload.hembed.com/image/icon/search_artist_icon.jpg?secure=qYBLGsqhJQrL4DsgOnOPkA==,4853050902">
		</button>
	</div>

	<div class="dropdown search-nav-opacity no-select hidden-xs hidden-sm" style="margin-top: 27px; float: right; margin-right: -8px;">
		<button style="outline:0; color:white; padding: 5px 16px 6px 16px; background-color: rgba(0,0,0,.1); margin-right: -4px; border-right-width: 0px;" class="btn btn-secondary dropdown-toggle search-nav-desktop search-type-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<img style="width: 15px; margin-top: -3px;" src="https://images2.imgbox.com/52/91/7tajapUw_o.png">
		</button>
		<button style="outline:0; color:white; padding: 5px 16px 6px 16px; background-color: rgba(0,0,0,.1);" class="btn btn-secondary dropdown-toggle search-nav-desktop search-type-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<img style="width: 15px; margin-top: -3px;" src="https://images2.imgbox.com/8b/a4/DICJd5Gg_o.png">
		</button>
	</div>
</div>