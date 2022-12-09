@extends('layouts.app')

@section('nav')
	<div class="hidden-xs">
		@include('nav.main')
	</div>
	<div id="main-nav-home" style="z-index: 10000; padding:0; padding-top: 3px; height: 48px; line-height: 40px; margin-bottom: 0px; background-color: black; position: relative;" class="hidden-sm hidden-md hidden-lg">

	  <div style="padding: 0 10px; margin-bottom: -10px;">
	    <a href="/" style="color: white; font-size: 1.4em;">
	      <img style="margin-top: -4px; margin-left: 3px; margin-right: 4px;" height="17" src="https://cdn.jsdelivr.net/gh/tatakanuta/tatakanuta@v1.0.0/asset/icon/back.png">
	    </a>

	    <form id="search-form" style="display: inline-block; margin-left: 7px; width: calc(100% - 115px); position: relative;">
		    <div id="nav-search-btn" class="search-btn"><img style="margin-top: -8px; margin-left: 7px;" height="20" src="https://cdn.jsdelivr.net/gh/tatakanuta/tatakanuta@v1.0.0/asset/icon/search.png"></div>
		    <input id="nav-query" name="nav-query" style="width: 100%; height: 35px; margin-top: -5px; vertical-align: middle; border-top-left-radius: 2px; border-bottom-left-radius: 2px; border-top-right-radius: 0px; border-bottom-right-radius: 0px; background-color: #1e1e1e; border-color: #1e1e1e; line-height: 35px; padding-left: 7px; font-size: 15px; padding-top: 5px" class="search-nav-bar" type="text" value="{{ request('query') }}" placeholder="搜尋 Hanime1.me">
		</form>

		@if (Auth::check())
		    <div id="search-user-mobile-modal-trigger" style="padding-left: 12px; padding-right: 0px; cursor: pointer;" class="nav-icon pull-right" data-toggle="modal" data-target="#search-user-mobile-modal">
		      <img style="width: 26px; border-radius: 50%;" src="{{ Auth::user()->avatar_temp }}">
		    </div>

		    <div style="z-index: 10001" id="search-user-mobile-modal" class="modal" role="dialog">
		      <div class="modal-dialog modal-sm" style="position: absolute; top: 87px;">
		        <div class="modal-content" style="border-radius: 3px; background-color: #222222; color: white;">
		          <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
		            <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
		            <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 5px; font-size: 18px;">帳戶設定</h4>
		          </div>

		          <div class="modal-body" style="padding: 0; height: calc(100% - 65px); overflow-x: hidden;">
		            @include('layouts.user-modal-content')
		            <hr style="margin: 0; border-color: #333333;">
		          </div>
		        </div>
		      </div>
		    </div>
		@else
		    <a style="padding-right: 0px" class="nav-icon pull-right" href="{{ route('home.list') }}">
		      <span style="vertical-align: middle; margin-top: -1px;" class="material-icons">account_circle</span>
		    </a>
		@endif
	  </div>
	</div>
@endsection

@section('content')

<form id="hentai-form" action="{{ route('home.search') }}" method="GET">

	@include('video.search-nav-desktop')

	@include('video.search-nav-mobile')

	<div id="genre-modal" class="modal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content" style="border-radius: 12px; border: 1px solid #323434; background-color: #181817; color: white">
	      <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
	        <span class="material-icons pull-left no-select modal-close-btn" style="font-size: 18px; margin-top: 4px;" data-dismiss="modal">close</span>
	        <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 6px; font-size: 16px;">影片類型</h4>
	      </div>
	      <div class="modal-body" style="padding: 0; text-align: center">
	        <input type="hidden" id="genre" name="genre" value="{{ $genre }}">

	        @foreach (['全部', '裏番', '泡麵番', 'Motion Anime', '3D動畫', '同人作品', 'Cosplay'] as $option)
		        <div style="line-height: 30px" class="simple-dropdown-item genre-option {{ $sort == $option ? 'active' : ''}}"><div class="hentai-sort-options">{{ $option }}</div></div>
				<hr style="margin: 0; border-color: #323434;">
	        @endforeach

			<a style="color: white; text-decoration: none; line-height: 30px" href="/previews/{{ Carbon\Carbon::now()->format('Ym') }}"><div class="simple-dropdown-item genre-option">新番預告</div></a>
			<hr style="margin: 0; border-color: #323434;">
			<a style="color: white; text-decoration: none; line-height: 30px" href="{{ route('comic.index') }}"><div class="simple-dropdown-item genre-option">H漫畫</div></a>
			<hr class="hidden-sm hidden-md hidden-lg hidden-xl" style="margin: 0; border-color: #323434;">
	      </div>

	      <hr style="border-color: #3a3c3f; margin: 0">
		  <div class="modal-footer" style="border-top: none; width: 100%; text-align: center; padding: 12px 15px">
			<div style="display: inline-block; float: left; line-height: 37px; color: white; cursor: pointer; text-decoration: underline; margin-left: 5px" data-dismiss="modal">取消</div>
			<button style="border: none; color: white; background-color: #323434; border-radius: 0; height: 100%; width: auto; font-weight: bold; border-radius: 5px; padding: 10px 20px; " class="pull-right btn btn-primary" type="submit">顯示搜索結果</button>
		  </div>
	    </div>
	  </div>
	</div>

	<div id="tags" class="modal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content" style="border-radius: 12px; border: 1px solid #323434; background-color: #181817; color: white">
	      <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
	        <span class="material-icons pull-left no-select modal-close-btn" style="font-size: 18px; margin-top: 4px;" data-dismiss="modal">close</span>
	        <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 6px; font-size: 16px;">內容標籤</h4>
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
			    <p style="color: gray; padding-bottom: 12px; font-size: 12px; padding-right: 60px;">較多結果，較不精準。配對所有包含任何一個選擇的標籤的影片，而非全部標籤。</p>
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

	        <h5 style="margin-top: 15px; margin-bottom: 10px; font-weight: bold">性交體位</h5>
	        @foreach (App\Video::$position as $tag)
	        	<label class="hentai-tags-wrapper">
				  <input name="tags[]" type="checkbox" value="{{ $tag }}" {{ $tags != [] && in_array($tag, $tags) ? 'checked' : '' }}>
				  <span class="checkmark">{{ $tag }}</span>
				</label>
	        @endforeach
	      </div>
	      <hr style="border-color: #3a3c3f; margin: 0">
	      <div class="modal-footer" style="border-top: none; width: 100%; text-align: center; padding: 12px 15px">
			<div style="display: inline-block; float: left; line-height: 37px; color: white; cursor: pointer; text-decoration: underline; margin-left: 5px" data-dismiss="modal">取消</div>
			<button style="border: none; color: white; background-color: #323434; border-radius: 0; height: 100%; width: auto; font-weight: bold; border-radius: 5px; padding: 10px 20px; " class="pull-right btn btn-primary" type="submit">顯示搜索結果</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div id="sort-modal" class="modal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content" style="border-radius: 12px; border: 1px solid #323434; background-color: #181817; color: white">
	      <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
	        <span class="material-icons pull-left no-select modal-close-btn" style="font-size: 18px; margin-top: 4px;" data-dismiss="modal">close</span>
	        <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 6px; font-size: 16px;">排序方式</h4>
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
	      <hr style="border-color: #3a3c3f; margin: 0">
	      <div class="modal-footer" style="border-top: none; width: 100%; text-align: center; padding: 12px 15px">
			<div style="display: inline-block; float: left; line-height: 37px; color: white; cursor: pointer; text-decoration: underline; margin-left: 5px" data-dismiss="modal">取消</div>
			<button style="border: none; color: white; background-color: #323434; border-radius: 0; height: 100%; width: auto; font-weight: bold; border-radius: 5px; padding: 10px 20px; " class="pull-right btn btn-primary" type="submit">顯示搜索結果</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div id="date-modal" class="modal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content" style="border-radius: 12px; border: 1px solid #323434; background-color: #181817; color: white">
	      <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
	        <span class="material-icons pull-left no-select modal-close-btn" style="font-size: 18px; margin-top: 4px;" data-dismiss="modal">close</span>
	        <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 6px; font-size: 16px;">發佈日期</h4>
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
	      <hr style="border-color: #3a3c3f; margin: 0">
	      <div class="modal-footer" style="border-top: none; width: 100%; text-align: center; padding: 12px 15px">
			<div style="display: inline-block; float: left; line-height: 37px; color: white; cursor: pointer; text-decoration: underline; margin-left: 5px" data-dismiss="modal">取消</div>
			<button style="border: none; color: white; background-color: #323434; border-radius: 0; height: 100%; width: auto; font-weight: bold; border-radius: 5px; padding: 10px 20px; " class="pull-right btn btn-primary" type="submit">顯示搜索結果</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div id="home-rows-wrapper" class="search-rows-wrapper">

		@if ($type == 'artist')
			<div class="content-padding-new">
				<div class="row no-gutter" style="margin-left: -3px; margin-right: -3px;">
					@foreach ($results as $artist)
						<div class="col-xs-6 col-sm-4 col-md-1" style="padding-left: 3px; padding-right: 3px; width: calc(100%/8);">
							<div class="hover-lighter card-mobile-panel" style="margin-bottom: 30px; border-radius: 5px;">
								<a href="{{ route('home.search') }}?query={{ $artist->name }}" style="text-decoration: none;">
									<div style="position: relative;">
										<img style="width: 100%;" src="https://i.imgur.com/1JyJ58n.jpg">
										<img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 3px" src="{{ $artist->avatar_temp }}">
								    </div>
								</a>

								<div style="margin-top: -1px; padding: 0 8px;">
									<div style="text-decoration: none; color: black;">
										<a href="{{ route('home.search') }}?query={{ $artist->name }}" style="color: white; font-size: inherit;">
											<div class="card-mobile-title">{{ $artist->name }}</div>
										</a>

										<div class="card-mobile-genre-wrapper" style="margin-top: 3px; margin-left: -2px">
											<a style="text-decoration: none; font-size: 12px; color: dimgray; margin-left: 2px; display: inline-block;" class="card-mobile-user">{{ $artist->videos_count }} 部影片</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		@else
		  	@if ($doujin)
				<div class="content-padding-new hidden-xs">
					<div class="row no-gutter" style="margin-left: -3px; margin-right: -3px;">
						@foreach ($results as $video)
							<div class="col-xs-6 col-sm-4 col-md-2 search-doujin-videos" style="padding-left: 3px; padding-right: 3px;">
								@include('layouts.owl-home-uncover-row')
							</div>
						@endforeach
					</div>
				</div>

				<div class="content-padding-new hidden-sm hidden-md hidden-lg hidden-xl">
					<div class="row no-gutter" style="margin-left: -3px; margin-right: -3px;">
						@foreach ($results as $video)
							<div class="col-xs-12" style="padding-left: 3px; padding-right: 3px;">

								<div class="hover-lighter card-mobile-panel" style="margin-bottom: 10px;">
									<div style="width: 150px; display: inline-block;">
										<a href="{{ route('video.watch') }}?v={{ $video->id }}" style="text-decoration: none;">
											<div style="position: relative; display: inline-block;">
												<img style="width: 100%; height: 100%; border-radius: 5px;" src="https://i.imgur.com/D1l0JoC.jpg">
												<img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 5px" src="{{ $video->thumbL() }}">
										    </div>
										</a>
									</div>

									<div style="display: inline-block; text-decoration: none; color: black; margin-top: -6px; margin-left: 8px; height: 50px; width: calc(100% - 168px); vertical-align: top;">
										<a href="{{ route('video.watch') }}?v={{ $video->id }}" style="color: white; font-size: inherit;">
											<div class="card-mobile-title" style="font-weight: bold;">{{ str_replace("[".$video->user->name."] ", "", $video->title) }}</div>
										</a>

										<div class="card-mobile-genre-wrapper" style="margin-top: 3px; margin-left: -2px">
											<a href="{{ route('home.search') }}?query={{ $video->user->name }}" style="font-size: 12px; color: dimgray; margin-left: 2px; display: inline-block; font-weight: bold;" class="card-mobile-user">{{ $video->user->name }}</a>
										</div>

										<div style="float: left; margin-top: -2px;">
											@if ($video->duration != null)
											    <div class="card-mobile-duration" style="background: #2E2E2E; padding: 0px 3px; line-height: 20px; color: #b8babc; font-weight: bold;">
											    	{{ $video->duration >= 3600 ? gmdate('H:i:s', $video->duration) : gmdate('i:s', $video->duration) }}
											    </div>
										    @endif

										    <div class="card-mobile-duration" style="background: #2E2E2E; padding: 0px 3px; line-height: 20px; margin-right: 5px; color: #b8babc; font-weight: bold;">
										    	{{ $video->views() }}次
										    </div>
										</div>

									</div>
								</div>

							</div>
						@endforeach
					</div>
				</div>
		    @else
			    <div class="home-rows-videos-wrapper" style="white-space: normal; margin-left: -2px; margin-right: -2px;">
				    @foreach ($results as $video)
				      	<a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video['id'] }}">
					        <div class="home-rows-videos-div" style="position: relative; display: inline-block; margin-bottom:50px;">
					          <img src="{{ $video['cover'] }}">
					          <div class="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 2px 5px; background: linear-gradient(to bottom, transparent 0%, black 120%);">{{ $video['title'] }}</div>
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