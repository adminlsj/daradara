<div id="search-nav-wrapper" style="margin-top: 10px; margin-bottom: 47px" class="hidden-xs">

	<div class="dropdown no-select" style="display: inline-block; padding: 0;">
		<button style="color: white; font-size: 32px; display: inline-block; margin-right: 20px; background-color: transparent; outline: 0; border: 0;" type="button" data-toggle="modal" data-target="#genre-modal">
			{{ !$genre || $genre == '全部' ? '全部類型' : Request::get('genre')}}
			<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 0px;">arrow_drop_down</i>
		</button>
	</div>

	<div class="dropdown no-select" style="display: inline-block; padding: 0; {{ $type == 'artist' ? 'display:none' : '' }}">
		<button style="outline:0; color:white;" class="btn btn-secondary dropdown-toggle search-nav-desktop" type="button" data-toggle="modal" data-target="#tags">
			標籤
			<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 16px; margin-right: -7px">arrow_drop_down</i>
		</button>
	</div>

	<div class="dropdown no-select" style="display: inline-block; padding: 0;">
		<button style="outline:0; color:white;" class="btn btn-secondary dropdown-toggle search-nav-desktop" type="button" data-toggle="modal" data-target="#sort-modal">
			{{ $sort ? $sort : '排序方式'}}
			<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 16px; margin-right: -7px">arrow_drop_down</i>
		</button>
	</div>

	<div class="dropdown no-select" style="display: inline-block; padding: 0; {{ $type == 'artist' ? 'display:none' : '' }}">
		<button style="outline:0; color:white;" class="btn btn-secondary dropdown-toggle search-nav-desktop" type="button" data-toggle="modal" data-target="#date-modal">
			發佈日期
			<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 16px; margin-right: -7px">arrow_drop_down</i>
		</button>
	</div>

	<div style="display: inline-block; position: relative;">
		<input id="query" name="query" type="text" value="{{ request('query') }}" placeholder="搜索" class="search-input-desktop">
		<div id="search-btn" class="search-btn" style="top:-12px; right: 1px; border-radius: 0px; background-color: rgba(255,255,255,.1); width: 34px;"><i style="margin-top: 4px; margin-left: 7px; color: rgba(255,255,255,0.5); font-size: 22px;" class="material-icons">search</i></div>
	</div>

	<input type="hidden" id="type" name="type" value="{{ $type }}">

	<div class="dropdown no-select search-nav-opacity hidden-md hidden-lg hidden-xl" style="display: inline-block; padding: 0; margin-left: 7px;">
		<button style="outline:0; color:white; padding: 5px 11px 6px 12px; background-color: rgba(0,0,0,.1);" class="btn btn-secondary dropdown-toggle search-nav-desktop search-type-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			@if ($type == 'artist')
				<span class="search-type-input">搜尋影片</span>
				<img style="width: 15px; margin-top: -3px; margin-left: 12px" src="https://i.imgur.com/qGFVxZb.png">
			@else
				<span class="search-type-input">搜尋作者</span>
				<img style="width: 15px; margin-top: -3px; margin-left: 12px" src="https://i.imgur.com/osVi2GM.png">
			@endif
		</button>
	</div>

	<div class="dropdown no-select search-nav-opacity hidden-xs hidden-sm" style="margin-top: 22px; float: right; margin-right: -8px;">
		<button style="outline:0; color:white; padding: 5px 11px 6px 12px; background-color: rgba(0,0,0,.1);" class="btn btn-secondary dropdown-toggle search-nav-desktop search-type-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			@if ($type == 'artist')
				<span class="search-type-input">搜尋影片</span>
				<img style="width: 15px; margin-top: -3px; margin-left: 12px" src="https://i.imgur.com/qGFVxZb.png">
			@else
				<span class="search-type-input">搜尋作者</span>
				<img style="width: 15px; margin-top: -3px; margin-left: 12px" src="https://i.imgur.com/osVi2GM.png">
			@endif
		</button>
	</div>
</div>