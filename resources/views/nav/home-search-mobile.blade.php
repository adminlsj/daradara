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
	        <div class="simple-dropdown-item hentai-sort-options-wrapper home-option year-option">全部</div>
	        <hr style="margin: 0; border-color: #E0E7EF;">
	        @for ($i = Carbon\Carbon::now()->year + 1; $i >= 1917; $i--)
		        <div class="simple-dropdown-item hentai-sort-options-wrapper home-option year-option {{ $year ? $year == $i ? 'active' : '' : '' }}" data-input="year">{{ $i }}</div>
		        <hr class="{{ $i == 1917 ? 'hidden-sm hidden-md hidden-lg hidden-xl' : '' }}" style="margin: 0; border-color: #E0E7EF;">
	        @endfor
	      </div>
	      <hr style="border-color: #E0E7EF; margin: 0">
	      <div class="modal-footer">
	      	<div data-dismiss="modal">取消</div>
			<button class="pull-right btn btn-primary" type="submit">顯示搜索結果</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="home-genre-tabs-wrapper" data-toggle="modal" data-target="#season-modal">
		<span class="home-genre-tabs">播放季度<img style="margin-top: -2px; margin-left: 7px; width: 12px;" src="https://images2.imgbox.com/36/8c/Npue5qJ0_o.png"></span>
	</div>

	<div id="season-modal" class="modal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
	        <h4 class="modal-title">播放季度</h4>
	      </div>
	      <div class="modal-body" style="padding: 0; text-align: center">
			@foreach (['全部', '1月冬番', '4月春番', '7月夏番', '10月秋番'] as $option)
		        <div class="simple-dropdown-item hentai-sort-options-wrapper home-option season-option {{ $season ? $season == $option ? 'active' : '' : '' }}" data-input="season">{{ $option }}</div>
		        <hr style="margin: 0; border-color: #E0E7EF;">
	        @endforeach
	      </div>
	      <hr style="border-color: #E0E7EF; margin: 0">
	      <div class="modal-footer">
	      	<div data-dismiss="modal">取消</div>
			<button class="pull-right btn btn-primary" type="submit">顯示搜索結果</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="home-genre-tabs-wrapper" data-toggle="modal" data-target="#category-modal">
		<span class="home-genre-tabs">類型<img style="margin-top: -2px; margin-left: 7px; width: 12px;" src="https://images2.imgbox.com/36/8c/Npue5qJ0_o.png"></span>
	</div>

	<div id="category-modal" class="modal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
	        <h4 class="modal-title">類型</h4>
	      </div>
	      <div class="modal-body" style="padding: 0; text-align: center">
			@foreach (['全部', 'TV', 'Movie', 'TV Special', 'Special', 'OVA', 'ONA', 'Music', 'PV', 'CM', 'Unknown'] as $option)
		        <div class="simple-dropdown-item hentai-sort-options-wrapper home-option category-option {{ $category ? $category == $option ? 'active' : '' : '' }}" data-input="category">{{ $option }}</div>
		        <hr class="{{ $loop->last ? 'hidden-sm hidden-md hidden-lg hidden-xl' : '' }}" style="margin: 0; border-color: #E0E7EF;">
	        @endforeach
	      </div>
	      <hr style="border-color: #E0E7EF; margin: 0">
	      <div class="modal-footer">
	      	<div data-dismiss="modal">取消</div>
			<button class="pull-right btn btn-primary" type="submit">顯示搜索結果</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="home-genre-tabs-wrapper" data-toggle="modal" data-target="#airing-status-modal">
		<span class="home-genre-tabs">播放狀態<img style="margin-top: -2px; margin-left: 7px; width: 12px;" src="https://images2.imgbox.com/36/8c/Npue5qJ0_o.png"></span>
	</div>

	<div id="airing-status-modal" class="modal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
	        <h4 class="modal-title">播放狀態</h4>
	      </div>
	      <div class="modal-body" style="padding: 0; text-align: center">
			@foreach (['全部', 'Currently Airing', 'Finished Airing', 'Not yet aired', 'Cancelled'] as $option)
		        <div class="simple-dropdown-item hentai-sort-options-wrapper home-option airing-status-option {{ $airing_status ? $airing_status == $option ? 'active' : '' : '' }}" data-input="airing_status">{{ $option }}</div>
		        <hr style="margin: 0; border-color: #E0E7EF;">
	        @endforeach
	      </div>
	      <hr style="border-color: #E0E7EF; margin: 0">
	      <div class="modal-footer">
	      	<div data-dismiss="modal">取消</div>
			<button class="pull-right btn btn-primary" type="submit">顯示搜索結果</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="home-genre-tabs-wrapper" data-toggle="modal" data-target="#streaming-on-modal">
		<span class="home-genre-tabs">串流平台<img style="margin-top: -2px; margin-left: 7px; width: 12px;" src="https://images2.imgbox.com/36/8c/Npue5qJ0_o.png"></span>
	</div>

	<div id="streaming-on-modal" class="modal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
	        <h4 class="modal-title">串流平台</h4>
	      </div>
	      <div class="modal-body" style="padding: 0; text-align: center">
			@foreach (['全部'] as $option)
		        <div class="simple-dropdown-item hentai-sort-options-wrapper home-option streaming-on-option {{ $streaming_on ? $streaming_on == $option ? 'active' : '' : '' }}" data-input="streaming_on">{{ $option }}</div>
		        <hr style="margin: 0; border-color: #E0E7EF;">
	        @endforeach
	      </div>
	      <hr style="border-color: #E0E7EF; margin: 0">
	      <div class="modal-footer">
	      	<div data-dismiss="modal">取消</div>
			<button class="pull-right btn btn-primary" type="submit">顯示搜索結果</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="home-genre-tabs-wrapper" data-toggle="modal" data-target="#country-modal">
		<span class="home-genre-tabs">原產國家<img style="margin-top: -2px; margin-left: 7px; width: 12px;" src="https://images2.imgbox.com/36/8c/Npue5qJ0_o.png"></span>
	</div>

	<div id="country-modal" class="modal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
	        <h4 class="modal-title">原產國家</h4>
	      </div>
	      <div class="modal-body" style="padding: 0; text-align: center">
			@foreach (['全部'] as $option)
		        <div class="simple-dropdown-item hentai-sort-options-wrapper home-option country-option {{ $country ? $country == $option ? 'active' : '' : '' }}" data-input="country">{{ $option }}</div>
		        <hr style="margin: 0; border-color: #E0E7EF;">
	        @endforeach
	      </div>
	      <hr style="border-color: #E0E7EF; margin: 0">
	      <div class="modal-footer">
	      	<div data-dismiss="modal">取消</div>
			<button class="pull-right btn btn-primary" type="submit">顯示搜索結果</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="home-genre-tabs-wrapper" data-toggle="modal" data-target="#source-modal">
		<span class="home-genre-tabs">原作素材<img style="margin-top: -2px; margin-left: 7px; width: 12px;" src="https://images2.imgbox.com/36/8c/Npue5qJ0_o.png"></span>
	</div>

	<div id="source-modal" class="modal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
	        <h4 class="modal-title">原作素材</h4>
	      </div>
	      <div class="modal-body" style="padding: 0; text-align: center">
			@foreach (['全部'] as $option)
		        <div class="simple-dropdown-item hentai-sort-options-wrapper home-option source-option {{ $source ? $source == $option ? 'active' : '' : '' }}" data-input="source">{{ $option }}</div>
		        <hr style="margin: 0; border-color: #E0E7EF;">
	        @endforeach
	      </div>
	      <hr style="border-color: #E0E7EF; margin: 0">
	      <div class="modal-footer">
	      	<div data-dismiss="modal">取消</div>
			<button class="pull-right btn btn-primary" type="submit">顯示搜索結果</button>
	      </div>
	    </div>
	  </div>
	</div>
</div>
