<div id="search-nav-wrapper">

	<div style="color: white; font-size: 35px; display: inline-block; margin-right: 35px; margin-top: 10px;">{{ Request::get('genre') ? Request::get('genre') : '全部類型'}}</div>

	<div class="search-nav no-select search-nav-desktop" data-toggle="modal" data-target="#tags" style="{{ $type == 'artist' ? 'display:none' : '' }}">
		標籤
		<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 16px; margin-right: -7px">arrow_drop_down</i>
	</div>

	<div class="dropdown no-select" style="display: inline-block; padding: 0;">
		<button style="outline:0; color:white;" class="btn btn-secondary dropdown-toggle search-nav-desktop" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			{{ $sort ? $sort : '排序方式'}}
			<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 16px; margin-right: -7px">arrow_drop_down</i>
		</button>
		<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="position: absolute; top: 18px; left: 0px; background: rgba(0, 0, 0, 0.9); padding: 5px 10px; min-width: 115px; height: {{ $type == 'artist' ? '131px' : '221px' }}; z-index: 1; border: 1px solid hsla(0,0%,100%,.2); border-radius: 0;">
			<input type="hidden" id="sort" name="sort" value="{{ $sort }}">

			@if ($type == 'artist')
				<a class="hentai-sort-options-wrapper"><div>字母順序</div></a>
				<a class="hentai-sort-options-wrapper"><div>影片數量</div></a>
				<a class="hentai-sort-options-wrapper"><div>加入日期</div></a>
				<a class="hentai-sort-options-wrapper"><div>更新日期</div></a>
			@else
				<a class="hentai-sort-options-wrapper"><div>最新上市</div></a>
				<a class="hentai-sort-options-wrapper"><div>最新上傳</div></a>
				<a class="hentai-sort-options-wrapper"><div>本日排行</div></a>
				<a class="hentai-sort-options-wrapper"><div>本週排行</div></a>
				<a class="hentai-sort-options-wrapper"><div>本月排行</div></a>
				<a class="hentai-sort-options-wrapper"><div>觀看次數</div></a>
				<a class="hentai-sort-options-wrapper"><div>他們在看</div></a>
			@endif
		</div>
	</div>

	<div class="search-nav no-select search-nav-desktop" data-toggle="modal" data-target="#date-modal" style="{{ $type == 'artist' ? 'display:none' : '' }}">
		發佈日期
		<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 16px; margin-right: -7px">arrow_drop_down</i>
	</div>

	<div style="display: inline-block; position: relative;">
		<input id="query" name="query" type="text" value="{{ request('query') }}" placeholder="搜索" style="color: white; font-size: 14px; display: inline-block; background-color: black; border: 1px solid hsla(0,0%,100%,.9); padding: 3px 44px 3px 10px; border-radius: 0px; margin-top: -17px; line-height: 24px; width: 250px; vertical-align: middle; outline: none;">
		<div id="search-btn" class="search-btn" style="top:-12px; right: 1px; border-radius: 0px; background-color: rgba(255,255,255,.1); width: 34px;"><i style="margin-top: 4px; margin-left: 7px; color: rgba(255,255,255,0.5); font-size: 22px;" class="material-icons">search</i></div>
	</div>

	<div class="dropdown no-select search-nav-opacity" style="margin-top: 34px; float: right; margin-right: -8px;">
		<button style="outline:0; color:white; padding: 5px 11px 6px 12px; background-color: rgba(0,0,0,.1);" class="btn btn-secondary dropdown-toggle search-nav-desktop search-type-button" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<input type="hidden" id="type" name="type" value="{{ $type }}">
			@if ($type == 'artist')
				<span id="search-type-input">搜索影片</span>
				<img style="width: 15px; margin-top: -3px; margin-left: 12px" src="https://i.imgur.com/qGFVxZb.png">
			@else
				<span id="search-type-input">搜索作者</span>
				<img style="width: 15px; margin-top: -3px; margin-left: 12px" src="https://i.imgur.com/osVi2GM.png">
			@endif
		</button>
	</div>
</div>