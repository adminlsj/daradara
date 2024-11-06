<div id="search-nav-desktop" style="margin-bottom: 35px; padding-top: 10px; padding-bottom: 6px; position: fixed; margin-top: 65px; z-index: 100000;" class="search-nav-wrapper hidden-xs">

	<div class="dropdown no-select" style="display: inline-block; padding: 0;">
		<button style="color: white; font-size: 38px; font-weight: 500 !important; display: inline-block; margin-right: 35px; background-color: transparent; outline: 0; border: 0; padding-left: 0px;" type="button" data-toggle="modal" data-target="#genre-modal">
			{{ !$genre || $genre == '全部' ? '動漫' : Request::get('genre')}}
			<!-- <i class="material-icons" style="vertical-align: middle; margin-top: -5px; margin-left: 0px;">arrow_drop_down</i> -->
		</button>
	</div>

	<div class="dropdown no-select" style="display: inline-block; padding: 0;">
		<button style="outline:0; color:white; margin-top: -18px;" class="btn btn-secondary dropdown-toggle search-nav-desktop" type="button" data-toggle="modal" data-target="#tags">
			標籤
			<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 16px; margin-right: -7px">arrow_drop_down</i>
		</button>
	</div>

	<div class="dropdown no-select" style="display: inline-block; padding: 0;">
		<button style="outline:0; color:white; margin-top: -18px;" class="btn btn-secondary dropdown-toggle search-nav-desktop" type="button" data-toggle="modal" data-target="#sort-modal">
			{{ $sort ? $sort : '排序方式'}}
			<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 16px; margin-right: -7px">arrow_drop_down</i>
		</button>
	</div>

	<div class="dropdown no-select" style="display: inline-block; padding: 0;">
		<button style="outline:0; color:white; margin-top: -18px;" class="btn btn-secondary dropdown-toggle search-nav-desktop" type="button" data-toggle="modal" data-target="#date-modal">
			發佈日期
			<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 16px; margin-right: -7px">arrow_drop_down</i>
		</button>
	</div>

	<div style="display: inline-block; position: relative;">
		<input id="query" name="query" type="text" value="{{ request('query') }}" placeholder="搜索" class="search-input-desktop">
		<div id="search-btn" class="search-btn" style="top:-12px; right: 1px; border-radius: 0px; background-color: rgba(255,255,255,.1); width: 34px;"><i style="margin-top: 4px; margin-left: 7px; color: rgba(255,255,255,0.5); font-size: 22px;" class="material-icons">search</i></div>
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