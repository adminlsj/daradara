@extends('layouts.app')

@section('nav')
	<div class="hidden-xs">
		@include('nav.main')
	</div>
	<div id="main-nav-home" style="z-index: 10000; padding:0; padding-top: 3px; height: 48px; line-height: 40px; position: absolute; background-image: none; border-bottom: 1px solid #2b2b2b; margin-bottom: 0px; background-color: #141414;" class="hidden-sm hidden-md hidden-lg">

	  <div style="padding: 0 10px; margin-bottom: -10px;">
	    <a href="/" style="color: white; font-size: 1.4em;">
	      <img style="margin-top: -5px; margin-left: 3px; margin-right: 4px;" height="17" src="https://cdn.jsdelivr.net/gh/tatakanuta/tatakanuta@v1.0.0/asset/icon/back.png">
	    </a>

	    <form id="search-form" style="display: inline-block; margin-left: 7px; width: calc(100% - 115px); position: relative;">
		    <div id="nav-search-btn" class="search-btn"><img style="margin-top: -9px; margin-left: 7px;" height="20" src="https://cdn.jsdelivr.net/gh/tatakanuta/tatakanuta@v1.0.0/asset/icon/search.png"></div>
		    <input id="nav-query" name="nav-query" style="width: 100%; height: 35px; margin-top: -6px; vertical-align: middle; border-top-left-radius: 2px; border-bottom-left-radius: 2px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; background-color: #1e1e1e; border-color: #1e1e1e; line-height: 35px; padding-left: 7px; font-size: 15px; padding-top: 5px" class="search-nav-bar" type="text" value="{{ request('query') }}" placeholder="搜尋 Hanime1.me">
		</form>

	    <a style="padding-right: 0px" class="nav-icon pull-right" href="{{ route('home.list') }}">
	      <span style="vertical-align: middle; margin-top: -2px;" class="material-icons">account_circle</span>
	    </a>
	  </div>
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
			<div class="simple-dropdown-item genre-option {{ $genre == '裏番' ? 'active' : ''}}">裏番</div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item genre-option {{ $genre == '泡麵番' ? 'active' : ''}}">泡麵番</div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item genre-option {{ $genre == '3D動畫' ? 'active' : ''}}">3D動畫</div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item genre-option {{ $genre == '同人作品' ? 'active' : ''}}">同人作品</div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item genre-option {{ $genre == 'Cosplay' ? 'active' : ''}}">Cosplay</div>
			<hr style="margin: 0; border-color: #333333;">
			<a style="color: white; text-decoration: none;" href="{{ route('comic.index') }}"><div class="simple-dropdown-item genre-option">H漫畫</div></a>
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

		    <h5 style="margin-bottom: 15px; font-weight: bold">影片屬性：</h5>
	        @foreach (App\Video::$metadata as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : '' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold">人物關係：</h5>
	        @foreach (App\Video::$setting as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : '' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold">角色設定：</h5>
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

	        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold">故事劇情：</h5>
	        @foreach (App\Video::$storyline as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : '' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold">性交體位：</h5>
	        @foreach (App\Video::$position as $tag)
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
			<div class="simple-dropdown-item hentai-sort-options-wrapper {{ $sort == '最新上市' ? 'active' : ''}}"><div class="hentai-sort-options">最新上市</div></div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item hentai-sort-options-wrapper {{ $sort == '最新上傳' ? 'active' : ''}}"><div class="hentai-sort-options">最新上傳</div></div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item hentai-sort-options-wrapper {{ $sort == '本日排行' ? 'active' : ''}}"><div class="hentai-sort-options">本日排行</div></div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item hentai-sort-options-wrapper {{ $sort == '本週排行' ? 'active' : ''}}"><div class="hentai-sort-options">本週排行</div></div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item hentai-sort-options-wrapper {{ $sort == '本月排行' ? 'active' : ''}}"><div class="hentai-sort-options">本月排行</div></div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item hentai-sort-options-wrapper {{ $sort == '觀看次數' ? 'active' : ''}}"><div class="hentai-sort-options">觀看次數</div></div>
			<hr style="margin: 0; border-color: #333333;">
			<div class="simple-dropdown-item hentai-sort-options-wrapper {{ $sort == '他們在看' ? 'active' : ''}}"><div class="hentai-sort-options">他們在看</div></div>
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

		<div class="hidden-sm hidden-md hidden-lg" style="text-align: center; padding-top: 14px; {{ $videos->lastPage() == 1 ? 'margin-bottom: 24px' : 'margin-bottom: -24px'}}">
			@include('layouts.exoclick', ['id' => '4396576', 'width' => '300', 'height' => '100'])
		</div>

		<div style="margin-bottom: -13px" class="search-pagination mobile-search-pagination hidden-sm hidden-md hidden-lg">{!! $videos->appends(request()->query())->onEachSide(1)->links() !!}</div>

	  	@if ($doujin)
			<div class="content-padding-new">
				<div class="row no-gutter" style="margin-left: -5px; margin-right: -5px;">
					@foreach ($videos as $video)
						<div class="col-xs-6 col-sm-4 col-md-3 search-doujin-row-lg" style="padding-left: 5px; padding-right: 5px;">
							@include('layouts.owl-home-uncover-row')
						</div>
					@endforeach
				</div>
			</div>
	    @else
		    <div class="home-rows-videos-wrapper" style="white-space: normal; margin-left: -2px; margin-right: -2px;">
			    @foreach ($videos as $video)
			      	<a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video['id'] }}">
				        <div class="home-rows-videos-div" style="position: relative; display: inline-block; margin-bottom:50px;">
				          <img src="{{ $video['cover'] }}">
				          <div class="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 2px 5px; background: linear-gradient(to bottom, transparent 0%, black 120%);">{{ $video['title'] }}</div>
				        </div>
				    </a>
			    @endforeach
			</div>
		@endif

		<div class="{{ $doujin ? 'search-doujin-pagination-desktop-margin' : 'search-hentai-pagination-desktop-margin' }} search-pagination hidden-xs">{!! $videos->appends(request()->query())->links() !!}</div>
		<div style="{{ $doujin ? 'margin-top: -26px;' : 'margin-top: -29px;' }}" class="search-pagination mobile-search-pagination hidden-sm hidden-md hidden-lg">{!! $videos->appends(request()->query())->onEachSide(1)->links() !!}</div>

		@include('ads.search-banner-panel')

		<div class="hidden-sm hidden-md hidden-lg" style="text-align: center; margin-bottom: -40px; {{ $videos->lastPage() == 1 ? 'margin-top: 32px' : 'margin-top: -12px' }}">
			<!-- JuicyAds v3.1 -->
			<script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
			<ins id="941419" data-width="300" data-height="112"></ins>
			<script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':941419});</script>
			<!--JuicyAds END-->
		</div>
	</div>
</form>

<script>
	var urlParams = new URLSearchParams(window.location.search);
	// $(".mobile-search-pagination .pagination .disabled").addClass('hidden-xs');
	if (urlParams.has('page') && urlParams.get('page') > 2) {
		$(".mobile-search-pagination .pagination .page-item:nth-child(3)").addClass('hidden');
	}
	if (urlParams.has('page') && urlParams.get('page') < {{ $videos->lastPage() }} - 1) {
		$(".mobile-search-pagination .pagination .page-item:nth-last-child(3)").addClass('hidden');
	}
</script>

<div style="background-color: #212121; margin-top: 40px;">
	<div class="hentai-footer">
		<p>Hanime1.me 暗黑版 anime1.me 帶給你最新最全的無碼高清中文字幕Hentai成人動漫。我們提供最優質的Hentai色情動漫裏番，並以最高畫質1080p呈現的Blu-ray rip。我們的18禁H漫網站適用於手機設備，並提供全網最優質的Hentai動畫。最新最全的Hentai裏番資料庫，Hanime1.me hentai 讓你一個按鈕觀看所有Hentai成人動畫，包括最新的2020年Hentai成人動漫。在這裏，你可以找到最優質的中文字幕H動畫 24小時！免費享受hentai動漫，成人動畫，H動漫，並且更有中文字幕，不必再聽日語猜故事！這個網站是繼avbebe之後，亞洲最優質的色情工口Hentai成人動漫，並且有許多Hentai分類，包括顏射、乳交、口交、熟女、學生妹、中出、百合、肛交，以及更多！</p>

		<p>Hentai是什麼？Hentai（変態 或 へんたい），Hentai 或 成人動漫的詞源來自日本，並指色情或成人動漫和動畫，特別是來自日本的18禁H動漫和成人動畫。</p>
	</div>
</div>

@endsection