@extends('layouts.app')

@section('nav')
	<div class="hidden-xs">
		@include('nav.main')
	</div>
	<div id="main-nav-home" style="z-index: 10000; padding:0; padding-top: 3px; height: 50px; line-height: 40px; margin-bottom: 0px; background-color: black; position: relative;" class="hidden-sm hidden-md hidden-lg">

	  <div style="padding: 0 10px; margin-bottom: -10px;">
	    <a href="/" style="color: #e5e5e5;">
	      <i class="material-icons-outlined" style="vertical-align: middle; margin-top: 0px; margin-left: 0px; font-size: 28px">chevron_left</i>
	    </a>

	    <form id="search-form" style="display: inline-block; margin-left: 7px; width: calc(100% - 39px); position: relative;">
		    <input id="nav-query" name="nav-query" style="width: 100%; height: 36px; margin-top: 0px; vertical-align: middle; border-radius: 5px; background-color: #323231; border-color: #323231 !important; line-height: 35px; padding-left: 37px; font-size: 15px; padding-top: 4px" class="search-nav-bar" type="text" value="{{ request('query') }}" placeholder="搜尋 Hanime1.me">
		    <i class="material-icons" style="color: dimgray; position: absolute; top: 9px; left: 7px; font-size: 25px">search</i>
		</form>
	  </div>
	</div>
@endsection

@section('content')

<form id="hentai-form" action="{{ route('home.search') }}" method="GET">

	@include('video.search-nav-desktop')

	@include('video.search-nav-mobile')

	<div id="genre-modal" class="modal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
	        <h4 class="modal-title">影片類型</h4>
	      </div>
	      <div class="modal-body" style="padding: 0; text-align: center">
	        <input type="hidden" id="genre" name="genre" value="{{ $genre }}">

	        @foreach (['全部', '裏番', '泡麵番', 'Motion Anime', '3D動畫', '同人作品', 'Cosplay'] as $option)
		        <div style="line-height: 30px" class="simple-dropdown-item genre-option {{ $genre == $option ? 'active' : ''}}"><div class="hentai-sort-options">{{ $option }}</div></div>
				<hr style="margin: 0; border-color: #323434;">
	        @endforeach

			<a style="color: white; text-decoration: none; line-height: 30px" href="/previews/{{ Carbon\Carbon::now()->format('Ym') }}"><div class="simple-dropdown-item genre-option">新番預告</div></a>
			<hr style="margin: 0; border-color: #323434;">
			<a style="color: white; text-decoration: none; line-height: 30px" href="{{ route('comic.index') }}"><div class="simple-dropdown-item genre-option">H漫畫</div></a>
			<hr class="hidden-sm hidden-md hidden-lg hidden-xl" style="margin: 0; border-color: #323434;">
	      </div>

	      <hr style="border-color: #323434; margin: 0">
		  <div class="modal-footer">
			<div data-dismiss="modal">取消</div>
			<button class="pull-right btn btn-primary" type="submit">顯示搜索結果</button>
		  </div>
	    </div>
	  </div>
	</div>

	<div id="tags" class="modal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
	        <h4 class="modal-title">內容標籤</h4>
	      </div>
	      <div class="modal-body" style="overflow-y: scroll; padding-top: 0px;">
	      	<div style="background-color: #323434; margin: 0 -15px 20px -15px; padding: 5px 15px 0px 15px;">
				<h5 style="font-weight: bold">
			  		廣泛配對
			      	<label class="hentai-switch" style="float: right">
						<input type="checkbox" name="broad" id="broad" {{ Request::get('broad') ? 'checked' : '' }}>
						<span class="hentai-slider round"></span>
					</label>
				</h5>
			    <p style="color: gray; padding-bottom: 12px; font-size: 12px; padding-right: 60px; font-weight: normal;">較多結果，較不精準。配對所有包含任何一個選擇的標籤的影片，而非全部標籤。</p>
		    </div>

		    <h5 style="margin-top: 20px; margin-bottom: 15px; font-weight: bold">影片屬性</h5>
	        @foreach (App\Video::$metadata as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : '' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold">人物關係</h5>
	        @foreach (App\Video::$setting as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : '' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold">角色設定</h5>
	        @foreach (App\Video::$profession as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : '' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold">外貌身材</h5>
	        @foreach (App\Video::$appearance as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : '' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold">故事劇情</h5>
	        @foreach (App\Video::$storyline as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : '' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach

	        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold">性交體位</h5>
	        @foreach (App\Video::$position as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : '' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach
	      </div>
	      <hr style="border-color: #323434; margin: 0">
	      <div class="modal-footer">
			<div data-dismiss="modal">取消</div>
			<button class="pull-right btn btn-primary" type="submit">顯示搜索結果</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div id="sort-modal" class="modal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
	        <h4 class="modal-title">排序方式</h4>
	      </div>
	      <div class="modal-body" style="padding: 0; text-align: center">
	        <input type="hidden" id="sort" name="sort" value="{{ $sort }}">

	        @if ($type == 'artist')
		        @php $options = ['字母順序', '影片數量', '加入日期', '更新日期'] @endphp
	        @else
		        @php $options = ['最新上市', '最新上傳', '本日排行', '本週排行', '本月排行', '觀看次數', '他們在看'] @endphp
	        @endif

	        @foreach ($options as $option)
		        <div class="simple-dropdown-item hentai-sort-options-wrapper {{ $sort == $option ? 'active' : ''}}"><div class="hentai-sort-options">{{ $option }}</div></div>
				<hr class="{{ $loop->last ? 'hidden-sm hidden-md hidden-lg hidden-xl' : '' }}" style="margin: 0; border-color: #323434;">
	        @endforeach
	      </div>
	      <hr style="border-color: #323434; margin: 0">
	      <div class="modal-footer">
	      	<div data-dismiss="modal">取消</div>
			<button class="pull-right btn btn-primary" type="submit">顯示搜索結果</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div id="date-modal" class="modal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
	        <h4 class="modal-title">發佈日期</h4>
	      </div>
	      <div class="modal-body" style="padding: 24px 15px;">
			<div class="form-group">
				<select class="form-control" id="year" name="year" style="width: calc(50% - 5px); display: inline-block; float: left;">
					<option value="">全部年份...</option>
					@for ($i = 2022; $i >= 1990; $i--)
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
	      <hr style="border-color: #323434; margin: 0">
	      <div class="modal-footer">
			<div data-dismiss="modal">取消</div>
			<button class="pull-right btn btn-primary" type="submit">顯示搜索結果</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div id="search-content-padding-desktop" class="hidden-xs"></div>
	<div id="search-content-padding-mobile" class="hidden-sm hidden-md hidden-lg hidden-xl"></div>

	<div id="home-rows-wrapper" class="search-rows-wrapper">

		<div class="hidden-sm hidden-md hidden-lg" style="text-align: center; margin-top: 0px; margin-bottom: -22px;">
			@include('layouts.exoclick', ['id' => '4396576', 'width' => '300', 'height' => '100'])
		</div>

		<div style="margin-bottom: -12px" class="search-pagination mobile-search-pagination hidden-sm hidden-md hidden-lg">{!! $results->appends(request()->query())->onEachSide(1)->links() !!}</div>

		@if ($type == 'artist')
			<div class="content-padding-new">
				<div class="row no-gutter" style="margin-left: -3px; margin-right: -3px;">
					@foreach ($results as $artist)
						<div class="col-xs-6 col-sm-4 col-md-1 search-artist-card hidden-xs hover-lighter multiple-link-wrapper" style="padding-left: 3px; padding-right: 3px; margin-bottom: 30px;">
							<a class="overlay" href="{{ route('home.search') }}?query={{ $artist->name }}&genre={{ $genre }}"></a>
							@include('video.card-artist-desktop')
						</div>
						<div class="col-xs-12 hidden-sm hidden-md hidden-lg hidden-xl hover-lighter multiple-link-wrapper" style="padding-left: 3px; padding-right: 3px; margin-bottom: 8px;">
							<a class="overlay" href="{{ route('home.search') }}?query={{ $artist->name }}&genre={{ $genre }}"></a>
							@include('video.card-artist-mobile')
						</div>
					@endforeach
				</div>
			</div>
		@else
		  	@if ($doujin)
				<div class="content-padding-new">
					<div class="row no-gutter" style="margin-left: -3px; margin-right: -3px;">
						@foreach ($results as $video)
							<div class="col-xs-6 col-sm-4 col-md-2 search-doujin-videos hidden-xs hover-lighter multiple-link-wrapper" style="padding-left: 3px; padding-right: 3px; margin-bottom: 45px;">
								<a class="overlay" href="{{ route('video.watch') }}?v={{ $video->id }}"></a>
								@include('video.card-doujin-desktop')
							</div>
							<div class="col-xs-12 search-doujin-videos hidden-sm hidden-md hidden-lg hidden-xl hover-lighter multiple-link-wrapper" style="padding-left: 4px; padding-right: 4px; margin-bottom: 16px;">
								<a class="overlay" href="{{ route('video.watch') }}?v={{ $video->id }}"></a>
								@include('video.card-doujin-mobile')
							</div>
						@endforeach
					</div>
				</div>
		    @else
			    <div class="home-rows-videos-wrapper" style="white-space: normal; margin-left: -2px; margin-right: -2px;">
				    @foreach ($results as $video)
				      	<a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video['id'] }}">
					        <div class="home-rows-videos-div search-videos" style="position: relative; display: inline-block;">
					          <img style="border-radius: 3px" src="{{ $video['cover'] }}">
					          <div class="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 2px 6px; background: linear-gradient(to bottom, transparent 0%, black 120%); border-radius: 3px">{{ $video['title'] }}</div>
					        </div>
					    </a>
				    @endforeach
				</div>
			@endif
		@endif

		<div class="{{ $doujin ? 'search-doujin-pagination-desktop-margin' : 'search-hentai-pagination-desktop-margin' }} search-pagination hidden-xs">{!! $results->appends(request()->query())->links() !!}</div>
		<div style="{{ $doujin ? 'margin-top: -26px;' : 'margin-top: -29px;' }}" class="search-pagination mobile-search-pagination hidden-sm hidden-md hidden-lg">{!! $results->appends(request()->query())->onEachSide(1)->links() !!}</div>

		@include('ads.search-banner-panel')

		<div class="hidden-sm hidden-md hidden-lg" style="text-align: center; margin-bottom: -40px; {{ $results->lastPage() == 1 ? 'margin-top: 32px' : 'margin-top: -12px' }}">
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
	if (urlParams.has('page') && urlParams.get('page') < {{ $results->lastPage() }} - 1) {
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