<div id="search-nav-wrapper">

	<div id="genre-modal-trigger" class="search-nav no-select {{ Request::get('genre') ? 'active' : '' }}" data-toggle="modal" data-target="#genre-modal">
		<span class="hidden-xs">{{ Request::get('genre') ? Request::get('genre') : '類型'}}</span>
		<div class="hidden-sm hidden-md hidden-lg"><span style="vertical-align: middle;" class="material-icons">dashboard</span></div>
	</div>

	<div id="genre-modal" class="modal" role="dialog">
	  <div class="modal-dialog modal-sm" style="position: absolute; top: 87px;">
	    <div class="modal-content" style="border-radius: 3px; background-color: #222222; color: white;">
	      <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
	      	<span style="position: absolute; top: 20px; left: 16px; cursor: pointer; font-size: 24px;" class="material-icons pull-left no-select" data-dismiss="modal">close</span>
	        <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 5px; font-size: 18px;">影片類型</h4>
	      </div>
	      <div class="modal-body" style="padding: 0;">
	        <input type="hidden" id="genre" name="genre" value="{{ Request::get('genre') }}">
			<div class="simple-dropdown-item genre-option {{ Request::get('genre') == '全部' ? 'active' : ''}}" style="{{ Request::get('genre') == '全部' ? 'background-color: #333333' : ''}}">全部</div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item genre-option {{ Request::get('genre') == 'H動漫' ? 'active' : ''}}">H動漫</div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item genre-option {{ Request::get('genre') == '3D動畫' ? 'active' : ''}}">3D動畫</div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item genre-option {{ Request::get('genre') == '同人作品' ? 'active' : ''}}">同人作品</div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item genre-option {{ Request::get('genre') == 'Cosplay' ? 'active' : ''}}">Cosplay</div>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="search-nav no-select {{ Request::get('tags') ? 'active' : '' }}" data-toggle="modal" data-target="#tags">
		<span class="hidden-xs">標籤</span>
		<div class="hidden-sm hidden-md hidden-lg"><span style="vertical-align: middle;" class="material-icons">loyalty</span></div>
	</div>

	<div id="sort-modal-trigger" class="search-nav no-select {{ Request::get('sort') ? 'active' : '' }}" data-toggle="modal" data-target="#sort-modal">
		<span class="hidden-xs">{{ Request::get('sort') ? Request::get('sort') : '排序方式'}}</span>
		<div class="hidden-sm hidden-md hidden-lg"><span style="vertical-align: middle;" class="material-icons">sort</span></div>
	</div>

	<div id="sort-modal" class="modal" role="dialog">
	  <div class="modal-dialog modal-sm" style="position: absolute; top: 87px;">
	    <div class="modal-content" style="border-radius: 3px; background-color: #222222; color: white;">
	      <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
	      	<span style="position: absolute; top: 20px; left: 16px; cursor: pointer; font-size: 24px;" class="material-icons pull-left no-select" data-dismiss="modal">close</span>
	        <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 5px; font-size: 18px;">排序方式</h4>
	      </div>
	      <div class="modal-body" style="padding: 0;">
	        <input type="hidden" id="sort" name="sort" value="{{ Request::get('sort') }}">
			<div class="simple-dropdown-item hentai-sort-options-wrapper {{ Request::get('sort') == '本日排行' ? 'active' : ''}}"><div class="hentai-sort-options">本日排行</div></div>
			<hr style="margin: 0; border-color: #333333;">
			<!--<div class="simple-dropdown-item hentai-sort-options-wrapper"><div class="hentai-sort-options">本月排行</div></div>
			<hr style="margin: 0; border-color: #222222;">-->
			<div class="simple-dropdown-item hentai-sort-options-wrapper {{ Request::get('sort') == '最新內容' ? 'active' : ''}}"><div class="hentai-sort-options">最新內容</div></div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item hentai-sort-options-wrapper {{ Request::get('sort') == '最新上傳' ? 'active' : ''}}"><div class="hentai-sort-options">最新上傳</div></div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item hentai-sort-options-wrapper {{ Request::get('sort') == '觀看次數' ? 'active' : ''}}"><div class="hentai-sort-options">觀看次數</div></div>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="search-nav no-select {{ Request::get('brands') ? 'active' : '' }}" data-toggle="modal" data-target="#brands">
		<span class="hidden-xs">品牌</span>
		<div class="hidden-sm hidden-md hidden-lg"><span style="vertical-align: middle;" class="material-icons">business</span></div>
	</div>

	<div id="date-modal-trigger" class="search-nav no-select {{ Request::get('year') ? 'active' : '' }}" data-toggle="modal" data-target="#date-modal">
		<span class="hidden-xs">{{ Request::get('year') ? Request::get('year').'年' : '發佈日期'}}</span>
		<div class="hidden-sm hidden-md hidden-lg"><span style="vertical-align: middle;" class="material-icons">date_range</span></div>
	</div>

	<div id="date-modal" class="modal" role="dialog">
	  <div class="modal-dialog modal-sm" style="position: absolute; top: 87px;">
	    <div class="modal-content" style="border-radius: 3px; background-color: #222222; color: white;">
	      <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
	      	<span style="position: absolute; top: 20px; left: 16px; cursor: pointer; font-size: 24px;" class="material-icons pull-left no-select" data-dismiss="modal">close</span>
	        <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 5px; font-size: 18px;">發佈日期</h4>
	      </div>
	      <div class="modal-body" style="padding: 24px 20px;">
			<div class="form-group">
				<select class="form-control" id="year" name="year" style="width: calc(50% - 5px); display: inline-block; float: left;">
					<option value="">全部年份...</option>
					@for ($i = 2021; $i >= 1990; $i--)
						<option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>{{ $i }}年</option>
					@endfor
				</select>
				<select class="form-control" id="month" name="month" style="width: calc(50% - 5px); display: inline-block; float: right;">
					<option value="">全部月份...</option>
					@for ($i = 1; $i <= 12; $i++)
						<option value="{{ $i }}" {{ $i == $month ? 'selected' : '' }}>{{ $i }}月</option>
					@endfor
				</select>
			</div>
	      </div>
	      <hr style="border-color: #3a3c3f; margin: 0">
	      <div class="modal-footer" style="border-top: none; width: 100%; text-align: center; padding: 0;">
			<div style="display: inline-block; width: 50%; float: left; line-height: 46px; color: darkgray; cursor: pointer;" data-dismiss="modal">取消</div>
			<button style="border: none; color: white; background-color: #b08fff; border-radius: 0; height: 100%; width: 50%; font-weight: bold; line-height: 34px;" class="pull-right btn btn-primary" type="submit">儲存</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div id="duration-modal-trigger" class="search-nav no-select {{ Request::get('duration') ? 'active' : '' }}" data-toggle="modal" data-target="#duration-modal">
		<span class="hidden-xs">{{ Request::get('duration') ? Request::get('duration') : '片長'}}</span>
		<div class="hidden-sm hidden-md hidden-lg"><span style="vertical-align: middle;" class="material-icons">update</span></div>
	</div>

	<div id="duration-modal" class="modal" role="dialog">
	  <div class="modal-dialog modal-sm" style="position: absolute; top: 87px; left: calc(4% + 449px);">
	    <div class="modal-content" style="border-radius: 3px; background-color: #222222; color: white;">
	      <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
	      	<span style="position: absolute; top: 20px; left: 16px; cursor: pointer; font-size: 24px;" class="material-icons pull-left no-select" data-dismiss="modal">close</span>
	        <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 5px; font-size: 18px;">影片長度</h4>
	      </div>
	      <div class="modal-body" style="padding: 0;">
	        <input type="hidden" id="duration" name="duration" value="{{ Request::get('duration') }}">
			<div class="simple-dropdown-item duration-option"><span></span>全部</div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item duration-option {{ Request::get('duration') == '短片' ? 'active' : ''}}"><span>短片</span>&nbsp;（4 分鐘內）</div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item duration-option {{ Request::get('duration') == '中長片' ? 'active' : ''}}"><span>中長片</span>&nbsp;（4 至 20 分鐘）</div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item duration-option {{ Request::get('duration') == '長片' ? 'active' : ''}}"><span>長片</span>&nbsp;（20 分鐘以上）</div>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="no-select hidden-xs" style="display: inline-block; position: relative;">
		<div id="search-btn"><i style="margin-top: 6px; margin-left: 7px; color: white; font-size: 17px; font-weight: bold;" class="material-icons">search</i></div>
		<input id="query" name="query" class="search-nav-bar" type="text" value="{{ request('query') }}" placeholder="搜索">
	</div>
</div>