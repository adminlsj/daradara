<div id="search-nav-wrapper" style="background-color: black; padding: 14px 10px 15px 10px; margin-top: 0px; margin-bottom: 5px; border: none;" class="hidden-sm hidden-md hidden-lg hidden-xl">

	<div style="color: white; display: inline-block; font-size: 17px; margin-right: 5px; font-weight: bold; cursor: pointer;" data-toggle="modal" data-target="#genre-modal">
		{{ !$genre || $genre == '全部' ? '全部類型' : Request::get('genre')}}
		<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: -5px;">arrow_drop_down</i>
	</div>

	<div style="color: #e5e5e5; display: inline-block; font-size: 14px; margin-right: 5px; font-weight: bold; cursor: pointer; {{ $type == 'artist' ? 'display:none' : '' }}" data-toggle="modal" data-target="#tags">
		標籤
		<i class="material-icons" style="vertical-align: middle; margin-top: -4px; margin-left: -5px;">arrow_drop_down</i>
	</div>

	<div style="color: #e5e5e5; display: inline-block; font-size: 14px; margin-right: 5px; font-weight: bold; cursor: pointer;" data-toggle="modal" data-target="#sort-modal">
		{{ $sort ? $sort : '排序方式'}}
		<i class="material-icons" style="vertical-align: middle; margin-top: -4px; margin-left: -5px;">arrow_drop_down</i>
	</div>

	<div style="color: #e5e5e5; display: inline-block; font-size: 14px; margin-right: 5px; font-weight: bold; cursor: pointer; {{ $type == 'artist' ? 'display:none' : '' }}" data-toggle="modal" data-target="#date-modal">
		發佈日期
		<i class="material-icons" style="vertical-align: middle; margin-top: -4px; margin-left: -5px;">arrow_drop_down</i>
	</div>

	<div style="color: #e5e5e5; display: inline-block; font-size: 14px; font-weight: bold; cursor: pointer;" class="search-type-button">
		@if ($type == 'artist')
			<span class="search-type-input">搜尋影片</span>
			<img style="width: 12px; margin-top: -3px; margin-left: 1px" src="https://i.imgur.com/qGFVxZb.png">
		@else
			<span class="search-type-input">搜尋作者</span>
			<img style="width: 11px; margin-top: -3px; margin-left: 2px" src="https://i.imgur.com/osVi2GM.png">
		@endif
	</div>
</div>

<!--

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