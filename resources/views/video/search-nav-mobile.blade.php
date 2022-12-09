<div id="search-nav-wrapper" style="background-color: black; padding: 14px 10px 15px 10px; margin-top: 0px; border: none;" class="hidden-sm hidden-md hidden-lg hidden-xl">

	<div style="color: white; display: inline-block; font-size: 18px; margin-right: 5px; font-weight: bold;">
		全部類型
		<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: -5px;">arrow_drop_down</i>
	</div>

	<div style="color: #e5e5e5; display: inline-block; font-size: 15px; margin-right: 5px; font-weight: bold;">
		標籤
		<i class="material-icons" style="vertical-align: middle; margin-top: -5px; margin-left: -5px;">arrow_drop_down</i>
	</div>

	<div style="color: #e5e5e5; display: inline-block; font-size: 15px; margin-right: 5px; font-weight: bold;">
		排序方式
		<i class="material-icons" style="vertical-align: middle; margin-top: -5px; margin-left: -5px;">arrow_drop_down</i>
	</div>

	<div style="color: #e5e5e5; display: inline-block; font-size: 15px; margin-right: 5px; font-weight: bold;">
		發布日期
		<i class="material-icons" style="vertical-align: middle; margin-top: -5px; margin-left: -5px;">arrow_drop_down</i>
	</div>
</div>

<!-- <div id="search-nav-wrapper" style="background-color: blue; line-height: 50px; padding: 0px" class="hidden-sm hidden-md hidden-lg hidden-xl">

	<div class="dropdown no-select" style="display: inline-block; padding: 0;">
		<button style="color: white; font-size: 20px; display: inline-block; margin-right: 10px; background-color: transparent; outline: 0; border: 0;" class="btn btn-secondary dropdown-toggle search-nav-desktop" type="button" data-toggle="modal" data-target="#genre-modal">
			{{ !$genre || $genre == '全部' ? '全部類型' : Request::get('genre')}}
			<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 4px; margin-right: -7px">arrow_drop_down</i>
		</button>
	</div>

	<div class="dropdown no-select" style="display: inline-block; padding: 0; {{ $type == 'artist' ? 'display:none' : '' }}">
		<button style="color: white; font-size: 14px; display: inline-block; margin-right: 10px; background-color: transparent; outline: 0; border: 0;" class="btn btn-secondary dropdown-toggle search-nav-desktop" type="button" data-toggle="modal" data-target="#tags">
			標籤
			<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 4px; margin-right: -7px">arrow_drop_down</i>
		</button>
	</div>

	<div class="dropdown no-select" style="display: inline-block; padding: 0;">
		<button style="color: white; font-size: 14px; display: inline-block; margin-right: 10px; background-color: transparent; outline: 0; border: 0;" class="btn btn-secondary dropdown-toggle search-nav-desktop" type="button" data-toggle="modal" data-target="#sort-modal">
			{{ $sort ? $sort : '排序方式'}}
			<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 4px; margin-right: -7px">arrow_drop_down</i>
		</button>
	</div>

	<div class="dropdown no-select" style="display: inline-block; padding: 0; {{ $type == 'artist' ? 'display:none' : '' }}">
		<button style="outline:0; color:white;" class="btn btn-secondary dropdown-toggle search-nav-desktop" type="button" data-toggle="modal" data-target="#date-modal">
			發佈日期
			<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 16px; margin-right: -7px">arrow_drop_down</i>
		</button>
	</div>

	<input type="hidden" id="type" name="type" value="{{ $type }}">

	<div class="dropdown no-select search-nav-opacity hidden-md hidden-lg hidden-xl" style="display: inline-block; padding: 0; margin-left: 7px;">
		<button style="outline:0; color:white; padding: 5px 11px 6px 12px; background-color: rgba(0,0,0,.1);" class="btn btn-secondary dropdown-toggle search-nav-desktop search-type-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			@if ($type == 'artist')
				<span class="search-type-input">搜索影片</span>
				<img style="width: 15px; margin-top: -3px; margin-left: 12px" src="https://i.imgur.com/qGFVxZb.png">
			@else
				<span class="search-type-input">搜索作者</span>
				<img style="width: 15px; margin-top: -3px; margin-left: 12px" src="https://i.imgur.com/osVi2GM.png">
			@endif
		</button>
	</div>

	<div class="dropdown no-select search-nav-opacity hidden-xs hidden-sm" style="margin-top: 22px; float: right; margin-right: -8px;">
		<button style="outline:0; color:white; padding: 5px 11px 6px 12px; background-color: rgba(0,0,0,.1);" class="btn btn-secondary dropdown-toggle search-nav-desktop search-type-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			@if ($type == 'artist')
				<span class="search-type-input">搜索影片</span>
				<img style="width: 15px; margin-top: -3px; margin-left: 12px" src="https://i.imgur.com/qGFVxZb.png">
			@else
				<span class="search-type-input">搜索作者</span>
				<img style="width: 15px; margin-top: -3px; margin-left: 12px" src="https://i.imgur.com/osVi2GM.png">
			@endif
		</button>
	</div>
</div> -->