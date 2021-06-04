<div id="search-nav-wrapper">

	<div id="genre-modal-trigger" class="search-nav no-select {{ Request::get('genre') ? 'active' : '' }}" data-toggle="modal" data-target="#genre-modal">
		<span class="hidden-xs">{{ Request::get('genre') ? Request::get('genre') : '類型'}}</span>
		<div class="hidden-sm hidden-md hidden-lg"><span style="vertical-align: middle;" class="material-icons">dashboard</span></div>
	</div>

	<div class="search-nav no-select {{ Request::get('tags') ? 'active' : '' }}" data-toggle="modal" data-target="#tags">
		<span class="hidden-xs">標籤</span>
		<div class="hidden-sm hidden-md hidden-lg"><span style="vertical-align: middle;" class="material-icons">loyalty</span></div>
	</div>

	<div id="sort-modal-trigger" class="search-nav no-select {{ Request::get('sort') ? 'active' : '' }}" data-toggle="modal" data-target="#sort-modal">
		<span class="hidden-xs">{{ Request::get('sort') ? Request::get('sort') : '排序方式'}}</span>
		<div class="hidden-sm hidden-md hidden-lg"><span style="vertical-align: middle;" class="material-icons">sort</span></div>
	</div>

	<div class="search-nav no-select {{ Request::get('brands') ? 'active' : '' }}" data-toggle="modal" data-target="#brands">
		<span class="hidden-xs">品牌</span>
		<div class="hidden-sm hidden-md hidden-lg"><span style="vertical-align: middle;" class="material-icons">business</span></div>
	</div>

	<div id="date-modal-trigger" class="search-nav no-select {{ Request::get('year') ? 'active' : '' }}" data-toggle="modal" data-target="#date-modal">
		<span class="hidden-xs">{{ Request::get('year') ? Request::get('year').'年' : '發佈日期'}}</span>
		<div class="hidden-sm hidden-md hidden-lg"><span style="vertical-align: middle;" class="material-icons">date_range</span></div>
	</div>

	<div id="duration-modal-trigger" class="search-nav no-select {{ Request::get('duration') ? 'active' : '' }}" data-toggle="modal" data-target="#duration-modal">
		<span class="hidden-xs">{{ Request::get('duration') ? Request::get('duration') : '片長'}}</span>
		<div class="hidden-sm hidden-md hidden-lg"><span style="vertical-align: middle;" class="material-icons">update</span></div>
	</div>

	<div class="no-select hidden-xs" style="display: inline-block; position: relative;">
		<div id="search-btn" class="search-btn"><i style="margin-top: 6px; margin-left: 7px; color: white; font-size: 17px; font-weight: bold;" class="material-icons">search</i></div>
		<input id="query" name="query" class="search-nav-bar" type="text" value="{{ request('query') }}" placeholder="搜索">
	</div>
</div>