<div id="search-nav-wrapper">

	<div style="color: white; font-size: 35px; display: inline-block; margin-right: 35px; margin-top: 10px;">{{ Request::get('genre') ? Request::get('genre') : '全部類型'}}</div>

	<div class="search-nav no-select" data-toggle="modal" data-target="#tags" style="color: white; font-size: 14px; display: inline-block; background-color: black; border: 1px solid hsla(0,0%,100%,.9); padding: 5px 10px 3px 10px; vertical-align: middle; margin-top: -17px; border-radius: 0px;">
		標籤
		<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 16px; margin-right: -7px">arrow_drop_down</i>
	</div>

	<div class="search-nav no-select" data-toggle="modal" data-target="#sort-modal" style="color: white; font-size: 14px; display: inline-block; background-color: black; border: 1px solid hsla(0,0%,100%,.9); padding: 5px 10px 3px 10px; vertical-align: middle; margin-top: -17px; border-radius: 0px;">
		排序方式
		<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 16px; margin-right: -7px">arrow_drop_down</i>
	</div>

	<div class="search-nav no-select" data-toggle="modal" data-target="#date-modal" style="color: white; font-size: 14px; display: inline-block; background-color: black; border: 1px solid hsla(0,0%,100%,.9); padding: 5px 10px 3px 10px; vertical-align: middle; margin-top: -17px; border-radius: 0px;">
		發佈日期
		<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 16px; margin-right: -7px">arrow_drop_down</i>
	</div>

	<div style="display: inline-block; position: relative;">
		<input id="query" name="query" type="text" value="{{ request('query') }}" placeholder="搜索" style="color: white; font-size: 14px; display: inline-block; background-color: black; border: 1px solid hsla(0,0%,100%,.9); padding: 3px 44px 3px 10px; border-radius: 0px; margin-top: -17px; line-height: 24px; width: 250px; vertical-align: middle; outline: none;">
		<div id="search-btn" class="search-btn" style="top:-12px; right: 1px; border-radius: 0px; background-color: rgba(255,255,255,.1); width: 34px;"><i style="margin-top: 4px; margin-left: 7px; color: rgba(255,255,255,0.5); font-size: 22px;" class="material-icons">search</i></div>
	</div>

	<div class="search-nav no-select" style="color: white; font-size: 14px; display: inline-block; background-color: black; border: 1px solid hsla(0,0%,100%,.9); padding: 3px 10px 3px 12px; vertical-align: middle; margin-top: 20px; border-radius: 0px; float: right; margin-right: 0px; line-height: 25px; vertical-align: middle;">
		<img style="width: 15px; margin-top: -4px; margin-right: 10px;" src="https://i.imgur.com/qGFVxZb.png">
		搜索影片結果
		<i class="material-icons" style="vertical-align: middle; margin-top: -3px; margin-left: 16px; margin-right: -7px">arrow_drop_down</i>
	</div>

	<div class="search-nav no-select" style="color: white; font-size: 14px; display: inline-block; background-color: rgba(0,0,0,.1); border: 1px solid hsla(0,0%,100%,.9); border-right: none; padding: 3px 1px 3px 11px; vertical-align: middle; margin-top: 20px; border-radius: 0px; float: right; margin-right: 0px; line-height: 25px; vertical-align: middle; opacity: .65;">
		<img style="width: 15px; margin-top: -4px; margin-right: 10px; opacity: .8;" src="https://i.imgur.com/osVi2GM.png">
	</div>

	<!-- <input id="query" name="query" type="text" value="{{ request('query') }}" placeholder="搜索" style="color: white; font-size: 14px; display: inline-block; background-color: black; border: 1px solid hsla(0,0%,100%,.9); padding: 5px 10px 3px 10px; border-radius: 0px; margin-top: -17px; margin-right: 0px; line-height: 22px; float: right; margin-top: 20px; width: 250px">
	<i style="margin-top: 6px; margin-left: 7px; color: white; font-size: 17px; font-weight: bold;" class="material-icons">search</i> -->

	<!-- <div id="genre-modal-trigger" class="search-nav no-select {{ Request::get('genre') ? 'active' : '' }}" data-toggle="modal" data-target="#genre-modal">
		<span class="hidden-xs">{{ Request::get('genre') ? Request::get('genre') : '類型'}}</span>
		<div class="hidden-sm hidden-md hidden-lg" style="border-right: 1px solid #2b2b2b; display: inline-block; margin-right: 7px; line-height: 31px;">
	      <a style="color: white; margin-right: 11px; margin-left: 10px; background-color: #2b2b2b; padding: 8px 13px 8px 10px; border-radius: 2px; font-weight: bold; text-decoration: none;">
	        <img style="margin-top: -3px; margin-right: 7px;" height="17" src="https://cdn.jsdelivr.net/gh/tatakanuta/tatakanuta@v1.0.0/asset/icon/categories.png">{{ Request::get('genre') ? Request::get('genre') : '類型'}}
	      </a>
	    </div>
	</div>

	<div class="search-nav no-select {{ Request::get('tags') ? 'active' : '' }}" data-toggle="modal" data-target="#tags">
		<span class="hidden-xs">標籤</span>
		<div style="padding: 6px 10px;" class="nav-home-mobile-button hidden-sm hidden-md hidden-lg">標籤</div>
	</div>

	<div id="sort-modal-trigger" class="search-nav no-select {{ Request::get('sort') ? 'active' : '' }}" data-toggle="modal" data-target="#sort-modal">
		<span class="hidden-xs">{{ Request::get('sort') ? Request::get('sort') : '排序方式'}}</span>
		<div style="padding: 6px 10px;" class="nav-home-mobile-button hidden-sm hidden-md hidden-lg">{{ Request::get('sort') ? Request::get('sort') : '排序方式'}}</div>
	</div>

	<div class="search-nav no-select {{ Request::get('brands') ? 'active' : '' }}" data-toggle="modal" data-target="#brands">
		<span class="hidden-xs">品牌</span>
		<div style="padding: 6px 10px;" class="nav-home-mobile-button hidden-sm hidden-md hidden-lg">品牌</div>
	</div>

	<div id="date-modal-trigger" class="search-nav no-select {{ Request::get('year') ? 'active' : '' }}" data-toggle="modal" data-target="#date-modal">
		<span class="hidden-xs">{{ Request::get('year') ? Request::get('year').'年' : '發佈日期'}}</span>
		<div style="padding: 6px 10px;" class="nav-home-mobile-button hidden-sm hidden-md hidden-lg">{{ Request::get('year') ? Request::get('year').'年' : '發佈日期'}}</div>
	</div>

	<div id="duration-modal-trigger" class="hidden-sm search-nav no-select {{ Request::get('duration') ? 'active' : '' }}" data-toggle="modal" data-target="#duration-modal">
		<span class="hidden-xs">{{ Request::get('duration') ? Request::get('duration') : '片長'}}</span>
		<div style="padding: 6px 10px;" class="nav-home-mobile-button hidden-sm hidden-md hidden-lg" style="margin-right: 10px;">{{ Request::get('duration') ? Request::get('duration') : '片長'}}</div>
	</div>

	<div class="no-select hidden-xs" style="display: inline-block; position: relative;">
		<div id="search-btn" class="search-btn"><i style="margin-top: 6px; margin-left: 7px; color: white; font-size: 17px; font-weight: bold;" class="material-icons">search</i></div>
		<input id="query" name="query" class="search-nav-bar" type="text" value="{{ request('query') }}" placeholder="搜索">
	</div> -->
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