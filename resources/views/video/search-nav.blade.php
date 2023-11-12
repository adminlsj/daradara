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