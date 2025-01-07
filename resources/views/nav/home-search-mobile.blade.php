<div class="filters-wrap home-search-nav-mobile">
	<div class="filter search">
		<div class="bar" style="position: relative; width: calc(100vw - 72px); height: 42px;">
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

<div class="video-buttons-wrapper desktop-inline-mobile-block hide-scrollbar" style="text-align: left; height: 40px; line-height: 40px; overflow-y: hidden; display: block; margin-top: -23px; margin-bottom: 20px;">
	<div class="home-genre-tabs-wrapper" data-toggle="modal" data-target="#genre-modal">
		<span class="home-genre-tabs">分類標籤<img style="margin-top: -2px; margin-left: 7px; width: 12px;" src="https://images2.imgbox.com/36/8c/Npue5qJ0_o.png"></span>
	</div>

	<div class="home-genre-tabs-wrapper" data-toggle="modal" data-target="#tags">
		<span class="home-genre-tabs">播出年份<img style="margin-top: -2px; margin-left: 7px; width: 12px;" src="https://images2.imgbox.com/36/8c/Npue5qJ0_o.png"></span>
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
