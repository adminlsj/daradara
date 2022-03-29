<div id="search-nav-wrapper">

	<div id="genre-modal-trigger" class="search-nav no-select {{ Request::get('genre') ? 'active' : '' }}" data-toggle="modal" data-target="#genre-modal">
		<span class="hidden-xs">{{ Request::get('genre') ? Request::get('genre') : '類型'}}</span>
		<div class="hidden-sm hidden-md hidden-lg" style="border-right: 1px solid #2b2b2b; display: inline-block; margin-right: 7px; line-height: 31px;">
	      <a style="color: white; margin-right: 11px; margin-left: 10px; background-color: #2b2b2b; padding: 7px 13px 7px 10px; border-radius: 2px; font-weight: bold; text-decoration: none;">
	        <img style="margin-top: -3px; margin-right: 7px;" height="17" src="https://cdn.jsdelivr.net/gh/tatakanuta/tatakanuta@v1.0.0/asset/icon/categories.png">{{ Request::get('genre') ? Request::get('genre') : '類型'}}
	      </a>
	    </div>
	</div>

	<div class="search-nav no-select {{ Request::get('tags') ? 'active' : '' }}" data-toggle="modal" data-target="#tags">
		<span class="hidden-xs">標籤</span>
		<div class="nav-home-mobile-button hidden-sm hidden-md hidden-lg">標籤</div>
	</div>

	<div id="sort-modal-trigger" class="search-nav no-select {{ Request::get('sort') ? 'active' : '' }}" data-toggle="modal" data-target="#sort-modal">
		<span class="hidden-xs">{{ Request::get('sort') ? Request::get('sort') : '排序方式'}}</span>
		<div class="nav-home-mobile-button hidden-sm hidden-md hidden-lg">{{ Request::get('sort') ? Request::get('sort') : '排序方式'}}</div>
	</div>

	<div class="search-nav no-select {{ Request::get('brands') ? 'active' : '' }}" data-toggle="modal" data-target="#brands">
		<span class="hidden-xs">品牌</span>
		<div class="nav-home-mobile-button hidden-sm hidden-md hidden-lg">品牌</div>
	</div>

	<div id="date-modal-trigger" class="search-nav no-select {{ Request::get('year') ? 'active' : '' }}" data-toggle="modal" data-target="#date-modal">
		<span class="hidden-xs">{{ Request::get('year') ? Request::get('year').'年' : '發佈日期'}}</span>
		<div class="nav-home-mobile-button hidden-sm hidden-md hidden-lg">{{ Request::get('year') ? Request::get('year').'年' : '發佈日期'}}</div>
	</div>

	<div id="duration-modal-trigger" class="hidden-sm search-nav no-select {{ Request::get('duration') ? 'active' : '' }}" data-toggle="modal" data-target="#duration-modal">
		<span class="hidden-xs">{{ Request::get('duration') ? Request::get('duration') : '片長'}}</span>
		<div class="nav-home-mobile-button hidden-sm hidden-md hidden-lg" style="margin-right: 10px;">{{ Request::get('duration') ? Request::get('duration') : '片長'}}</div>
	</div>

	<div class="no-select hidden-xs" style="display: inline-block; position: relative;">
		<div id="search-btn" class="search-btn"><i style="margin-top: 6px; margin-left: 7px; color: white; font-size: 17px; font-weight: bold;" class="material-icons">search</i></div>
		<input id="query" name="query" class="search-nav-bar" type="text" value="{{ request('query') }}" placeholder="搜索">
	</div>
</div>

<script>
	@if ($is_mobile)
		var $window = $(window).scroll(function(){
		  if ( $window.scrollTop() > 48 ) {   
		    $("#search-nav-wrapper").css({"position":"fixed", 'top':'0px'});
		  } else {
		    $("#search-nav-wrapper").css({"position":"absolute", 'top':'48px'});
		  }
		});
	@endif
</script>