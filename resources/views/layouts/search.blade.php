@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main-original-dark', ['theme' => 'white'])
@endsection

@section('content')

<div id="home-rows-wrapper" class="search-rows-wrapper" style="position: relative;">
	  <div class="home-rows-videos-wrapper" style="white-space: normal;">
	    @foreach ($videos as $video)
	      <a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video['id'] }}">
	        <div id="home-rows-videos-div" style="position: relative; display: inline-block; margin-bottom:50px">
	          <img src="{{ $video['cover'] }}">
	          <div id="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 3px 3px; background: linear-gradient(to bottom, transparent 0%, black 120%);">{{ $video['title'] }}</div>
	          </div>
	      </a>
	    @endforeach
	  </div>
	  <div class="search-pagination hidden-xs">{!! $videos->appends(request()->input())->links() !!}</div>
	  <div class="search-pagination mobile-search-pagination hidden-sm hidden-md hidden-lg">{!! $videos->appends(request()->input())->onEachSide(1)->links() !!}</div>
</div>

<form id="hentai-form" action="{{ route('home.search') }}" method="GET">
	<input type="hidden" id="query" name="query" value="{{ Request::get('query') }}">
	<div id="tags" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content" style="border-radius: 3px; background-color: #424242; color: white">
	      <div class="modal-header" style="border-bottom: 1px solid #3a3c3f">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title" style="text-align: center;">標籤</h4>
	      </div>
	      <div class="modal-body">
	      	<!--<h5>
	      		廣泛配對
		      	<label class="hentai-switch" style="float: right">
					<input type="checkbox" name="broad" id="broad" {{ Request::get('broad') ? 'checked' : '' }}>
					<span class="hentai-slider round"></span>
				</label>
			</h5>
	        <p style="color: darkgray; padding-bottom: 15px; font-size: 12px">較多結果，較不精準。配對所有包含任何一個選擇的標籤的影片，而非全部標籤。</p>-->

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
	      <div class="modal-footer" style="border-top: none;">
	      	<button style="border: none; color: white; background-color: transparent;" type="button" class="pull-left" data-dismiss="modal">取消</button>
	        <button style="border: none; color: #b08fff; background-color: transparent;" type="submit">搜索</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div id="brands" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content" style="border-radius: 3px; background-color: #424242; color: white">
	      <div class="modal-header" style="border-bottom: 1px solid #3a3c3f">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title" style="text-align: center">品牌</h4>
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
	      <div class="modal-footer" style="border-top: none;">
	      	<button style="border: none; color: white; background-color: transparent;" type="button" class="pull-left" data-dismiss="modal">取消</button>
	        <button style="border: none; color: #b08fff; background-color: transparent;" type="submit">搜索</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div id="sort-wrapper" class="modal fade" role="dialog">
		<div id="hentai-sort-panel">
			<input type="hidden" id="sort" name="sort" value="{{ Request::get('sort') }}">
			<div class="hentai-sort-options-wrapper"><div class="hentai-sort-options">本日排行</div></div>
			<div class="hentai-sort-options-wrapper"><div class="hentai-sort-options">最新內容</div></div>
			<div class="hentai-sort-options-wrapper"><div class="hentai-sort-options">最新上傳</div></div>
			<div class="hentai-sort-options-wrapper"><div class="hentai-sort-options">觀看次數</div></div>
		</div>
	</div>
</form>

@endsection