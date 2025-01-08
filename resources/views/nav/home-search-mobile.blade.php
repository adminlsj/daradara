<div class="filters-wrap home-search-nav-mobile">
	<div class="filter search">
		<div class="bar" style="position: relative; width: calc(100vw - 92px); height: 42px;">
			<input id="text" name="text" type="text" style="padding-left: 35px;" value="{{ $text ? $text : '' }}" placeholder="搜尋 daradara">
			<input type="submit" style="display: none">
			<i class="fa fa-search" style="color: rgba(201,215,227); font-size: 1.3rem; height: 1.6rem; position: absolute; left: 12px; top: 14px"></i>
		</div>
	</div>

	<div class="filter format" style="position: relative;">
		<div onclick="extra_filter_toggle()" class="extra-filter-wrap no-select" style="background-color: transparent; height: 42px; width: 42px;" type="button" data-toggle="dropdown">
			<div id="home-filter-more-btn" style="height: 42px; width: 42px; margin-top: 0px;">
				<i class="material-icons">tune</i>
			</div>
		</div>
	</div>
</div>

<div class="video-buttons-wrapper desktop-inline-mobile-block hide-scrollbar">
	<div class="home-genre-tabs-wrapper" data-toggle="modal" data-target="#genre-modal">
		<span class="home-genre-tabs">分類標籤<img style="margin-top: -2px; margin-left: 7px; width: 12px;" src="https://images2.imgbox.com/36/8c/Npue5qJ0_o.png"></span>
	</div>

	<div class="home-genre-tabs-wrapper" data-toggle="modal" data-target="#year-modal">
		<span class="home-genre-tabs">播出年份<img style="margin-top: -2px; margin-left: 7px; width: 12px;" src="https://images2.imgbox.com/36/8c/Npue5qJ0_o.png"></span>
	</div>

	<div id="year-modal" class="modal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
	        <h4 class="modal-title">播出年份</h4>
	      </div>
	      <div class="modal-body" style="padding: 0; text-align: center">
	        <input type="hidden" id="sort" name="sort" value="{{ $sort ? $sort : '' }}">

	        @for ($i = Carbon\Carbon::now()->year + 1; $i >= 1917; $i--)
		        <div class="simple-dropdown-item hentai-sort-options-wrapper {{ $sort ? $sort == $i ? 'active' : '' : '' }}"><div class="hentai-sort-options">{{ $i }}</div></div>
<<<<<<< HEAD
		        <hr class="{{ $i == 1917 ? 'hidden-sm hidden-md hidden-lg hidden-xl' : '' }}" style="margin: 0; border-color: #E0E7EF;">
	        @endfor
	      </div>
	      <hr style="border-color: #E0E7EF; margin: 0">
=======
		        <hr class="{{ $i == 1917 ? 'hidden-sm hidden-md hidden-lg hidden-xl' : '' }}" style="margin: 0; border-color: #323434;">
	        @endfor
	      </div>
	      <hr style="border-color: #323434; margin: 0">
>>>>>>> 7089439c27bd6e541980461503031168dc2a2f1f
	      <div class="modal-footer">
	      	<div data-dismiss="modal">取消</div>
			<button class="pull-right btn btn-primary" type="submit">顯示搜索結果</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="home-genre-tabs-wrapper" data-toggle="modal" data-target="#date-modal">
		<span class="home-genre-tabs">播放季度<img style="margin-top: -2px; margin-left: 7px; width: 12px;" src="https://images2.imgbox.com/36/8c/Npue5qJ0_o.png"></span>
	</div>

	<div class="home-genre-tabs-wrapper" data-toggle="modal" data-target="#date-modal">
		<span class="home-genre-tabs">類型<img style="margin-top: -2px; margin-left: 7px; width: 12px;" src="https://images2.imgbox.com/36/8c/Npue5qJ0_o.png"></span>
	</div>

	<div class="home-genre-tabs-wrapper" data-toggle="modal" data-target="#date-modal">
		<span class="home-genre-tabs">播放狀態<img style="margin-top: -2px; margin-left: 7px; width: 12px;" src="https://images2.imgbox.com/36/8c/Npue5qJ0_o.png"></span>
	</div>

	<div class="home-genre-tabs-wrapper" data-toggle="modal" data-target="#date-modal">
		<span class="home-genre-tabs">串流平台<img style="margin-top: -2px; margin-left: 7px; width: 12px;" src="https://images2.imgbox.com/36/8c/Npue5qJ0_o.png"></span>
	</div>

	<div class="home-genre-tabs-wrapper" data-toggle="modal" data-target="#date-modal">
		<span class="home-genre-tabs">原產國家<img style="margin-top: -2px; margin-left: 7px; width: 12px;" src="https://images2.imgbox.com/36/8c/Npue5qJ0_o.png"></span>
	</div>

	<div class="home-genre-tabs-wrapper" data-toggle="modal" data-target="#date-modal">
		<span class="home-genre-tabs">原作素材<img style="margin-top: -2px; margin-left: 7px; width: 12px;" src="https://images2.imgbox.com/36/8c/Npue5qJ0_o.png"></span>
	</div>
</div>
