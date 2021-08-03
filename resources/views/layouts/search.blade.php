@extends('layouts.app')

@section('nav')
	<div class="hidden-xs">
		@include('nav.main')
	</div>
	<div id="search-top-nav-mobile" class="hidden-sm hidden-md hidden-lg" style="padding: 0 15px; height: 68px; position: fixed; z-index: 1000; background-color: #141414; width: 100%;">
	    <a class="hover-opacity" href="/" style="color: white; line-height: 68px; text-decoration: none;">
		    <img height="30" src="https://i.imgur.com/PTFz5Ej.png">
	    </a>

		<form id="search-form" style="display: inline-block; margin-left: 8px; width: calc(100% - 74px); position: relative;">
		    <div id="nav-search-btn" class="search-btn"><i style="margin-top: 4px; margin-left: 5px; color: white; font-size: 21px; font-weight: bold;" class="material-icons">search</i></div>
		    <input id="nav-query" name="nav-query" style="width: 100%" class="search-nav-bar" type="text" value="{{ request('query') }}" placeholder="搜索">
		</form>

		<a style="padding-right: 0px; line-height: 68px; color: white;" class="nav-icon pull-right" href="{{ Auth::check() ? route('home.list') : route('login') }}"><span style="vertical-align: middle; font-size: 36px; margin-top: -1px;" class="material-icons">account_circle</span></a>
	</div>
@endsection

@section('content')
<form id="hentai-form" action="{{ route('home.search') }}" method="GET">
	@include('video.search-nav')

	<div id="genre-modal" class="modal" role="dialog">
	  <div class="modal-dialog modal-sm" style="position: absolute; top: 87px;">
	    <div class="modal-content" style="border-radius: 3px; background-color: #222222; color: white;">
	      <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
	      	<span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
	        <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 5px; font-size: 18px;">影片類型</h4>
	      </div>
	      <div class="modal-body" style="padding: 0;">
	        <input type="hidden" id="genre" name="genre" value="{{ $genre }}">
			<div class="simple-dropdown-item genre-option {{ $genre == '全部' ? 'active' : ''}}" style="{{ $genre == '全部' ? 'background-color: #333333' : ''}}">全部</div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item genre-option {{ $genre == 'H動漫' ? 'active' : ''}}">H動漫</div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item genre-option {{ $genre == '3D動畫' ? 'active' : ''}}">3D動畫</div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item genre-option {{ $genre == '同人作品' ? 'active' : ''}}">同人作品</div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item genre-option {{ $genre == 'Cosplay' ? 'active' : ''}}">Cosplay</div>
	      </div>
	    </div>
	  </div>
	</div>

	<div id="tags" class="modal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content" style="border-radius: 3px; background-color: #222222; color: white">
	      <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
	        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
	        <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 5px; font-size: 18px;">內容標籤</h4>
	      </div>
	      <div class="modal-body" style="overflow-y: scroll; padding-top: 0px;">
	      	<div style="background-color: #333333; margin: 0 -15px 20px -15px; padding: 5px 15px 0px 15px;">
				<h5 style="font-weight: bold">
			  		廣泛配對
			      	<label class="hentai-switch" style="float: right">
						<input type="checkbox" name="broad" id="broad" {{ Request::get('broad') ? 'checked' : '' }}>
						<span class="hentai-slider round"></span>
					</label>
				</h5>
			    <p style="color: darkgray; padding-bottom: 12px; font-size: 12px; padding-right: 60px;">較多結果，較不精準。配對所有包含任何一個選擇的標籤的影片，而非全部標籤。</p>
		    </div>

	        <h5 style="margin-bottom: 15px; font-weight: bold">人物設定：</h5>
	        @foreach (App\Video::$setting as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : '' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold">職業設定：</h5>
	        @foreach (App\Video::$profession as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : '' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold">外貌身材：</h5>
	        @foreach (App\Video::$appearance as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : '' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold">劇情內容：</h5>
	        @foreach (App\Video::$storyline as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : '' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach
	      </div>
	      <hr style="border-color: #3a3c3f; margin: 0">
	      <div class="modal-footer" style="border-top: none; width: 100%; text-align: center; padding: 0;">
			<div style="display: inline-block; width: 50%; float: left; line-height: 46px; color: darkgray; cursor: pointer;" data-dismiss="modal">取消</div>
			<button style="border: none; color: white; background-color: #b08fff; border-radius: 0; height: 100%; width: 50%; font-weight: bold; line-height: 34px;" class="pull-right btn btn-primary" type="submit">儲存</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div id="sort-modal" class="modal" role="dialog">
	  <div class="modal-dialog modal-sm" style="position: absolute; top: 87px;">
	    <div class="modal-content" style="border-radius: 3px; background-color: #222222; color: white;">
	      <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
	      	<span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
	        <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 5px; font-size: 18px;">排序方式</h4>
	      </div>
	      <div class="modal-body" style="padding: 0;">
	        <input type="hidden" id="sort" name="sort" value="{{ $sort }}">
			<div class="simple-dropdown-item hentai-sort-options-wrapper {{ $sort == '本日排行' ? 'active' : ''}}"><div class="hentai-sort-options">本日排行</div></div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item hentai-sort-options-wrapper {{ $sort == '最新內容' ? 'active' : ''}}"><div class="hentai-sort-options">最新內容</div></div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item hentai-sort-options-wrapper {{ $sort == '最新上傳' ? 'active' : ''}}"><div class="hentai-sort-options">最新上傳</div></div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item hentai-sort-options-wrapper {{ $sort == '觀看次數' ? 'active' : ''}}"><div class="hentai-sort-options">觀看次數</div></div>
	      </div>
	    </div>
	  </div>
	</div>

	<div id="brands" class="modal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content" style="border-radius: 3px; background-color: #222222; color: white">
	      <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
	        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
	        <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 5px; font-size: 18px;">製作公司</h4>
	      </div>
	      <div class="modal-body">
	        <h4>品牌 / 製作</h4>
	        <p id="hentai-tags-text" style="color: darkgray; padding-bottom: 10px">搜索以下選擇的品牌或製作的影片：</p>
	        @foreach (App\Video::$hentai_brands as $brand)
	        	<label class="hentai-tags-wrapper">
				  <input name="brands[]" type="checkbox" value="{{ $brand }}" {{ $brands != [] && in_array($brand, $brands) ? 'checked' : '' }}>
				  <span style="border-radius: 0px;" class="checkmark">{{ $brand }}</span>
				</label>
	        @endforeach
	      </div>
	      <hr style="border-color: #3a3c3f; margin: 0">
	      <div class="modal-footer" style="border-top: none; width: 100%; text-align: center; padding: 0;">
			<div style="display: inline-block; width: 50%; float: left; line-height: 46px; color: darkgray; cursor: pointer;" data-dismiss="modal">取消</div>
			<button style="border: none; color: white; background-color: #b08fff; border-radius: 0; height: 100%; width: 50%; font-weight: bold; line-height: 34px;" class="pull-right btn btn-primary" type="submit">儲存</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div id="date-modal" class="modal" role="dialog">
	  <div class="modal-dialog modal-sm" style="position: absolute; top: 87px;">
	    <div class="modal-content" style="border-radius: 3px; background-color: #222222; color: white;">
	      <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
	      	<span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
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

	<div id="duration-modal" class="modal" role="dialog">
	  <div class="modal-dialog modal-sm" style="position: absolute; top: 87px; left: calc(4% + 449px);">
	    <div class="modal-content" style="border-radius: 3px; background-color: #222222; color: white;">
	      <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
	      	<span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
	        <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 5px; font-size: 18px;">影片長度</h4>
	      </div>
	      <div class="modal-body" style="padding: 0;">
	        <input type="hidden" id="duration" name="duration" value="{{ $duration }}">
			<div class="simple-dropdown-item duration-option"><span></span>全部</div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item duration-option {{ $duration }}"><span>短片</span>&nbsp;（4 分鐘內）</div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item duration-option {{ $duration }}"><span>中長片</span>&nbsp;（4 至 20 分鐘）</div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item duration-option {{ $duration }}"><span>長片</span>&nbsp;（20 分鐘以上）</div>
	      </div>
	    </div>
	  </div>
	</div>

	<div id="home-rows-wrapper" class="search-rows-wrapper" style="position: relative;">
	  	@if ($doujin)
		  	<div class="home-rows-videos-wrapper mobile-full-width" style="white-space: normal;">
		  		@if ($is_mobile)
				    @foreach ($videos as $video)
					    @include('video.card-mobile')
					@endforeach
				@else
					@foreach ($videos as $video)
					    @include('video.card-desktop')
					@endforeach
				@endif
			</div>
	    @else
		    <div class="home-rows-videos-wrapper" style="white-space: normal; margin-left: -2px; margin-right: -2px;">
			    @foreach ($videos as $video)
			      	<a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video['id'] }}">
				        <div class="home-rows-videos-div" style="position: relative; display: inline-block; margin-bottom:50px;">
				          <img src="{{ $video['cover'] }}">
				          <div class="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 3px 5px; background: linear-gradient(to bottom, transparent 0%, black 120%);">{{ $video['title'] }}</div>
				        </div>
				    </a>
			    @endforeach
			</div>
		@endif
		<div class="search-pagination hidden-xs">{!! $videos->appends(request()->query())->links() !!}</div>
		<div class="search-pagination mobile-search-pagination hidden-sm hidden-md hidden-lg">{!! $videos->appends(request()->query())->onEachSide(1)->links() !!}</div>

		@include('ads.search-banner-panel')
	</div>
</form>

<script>
	var urlParams = new URLSearchParams(window.location.search);
	$(".mobile-search-pagination .pagination .disabled").addClass('hidden-xs');
	if (urlParams.has('page') && urlParams.get('page') > 2) {
		$(".mobile-search-pagination .pagination .page-item:nth-child(3)").addClass('hidden');
	}
	if (urlParams.has('page') && urlParams.get('page') < {{ $videos->lastPage() }} - 1) {
		$(".mobile-search-pagination .pagination .page-item:nth-last-child(3)").addClass('hidden');
	}
</script>

@endsection