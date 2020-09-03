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
	  <div id="search-pagination">{!! $videos->appends(request()->input())->links() !!}</div>
</div>

<div style="background-color: #212121;">
	<div class="hentai-footer">
		<p>LaughSeeJapan hentai haven 帶給你最新最全的無碼高清中文字幕Hentai成人動漫。我們提供最優質的Hentai色情動漫裏番，並以最高畫質1080p呈現的Blu-ray rip。我們的18禁H漫網站適用於手機設備，並提供全網最優質的Hentai動畫。最新最全的Hentai裏番資料庫，LaughSeeJapan hentai 讓你一個按鈕觀看所有Hentai成人動畫，包括最新的2020年Hentai成人動漫。在這裏，你可以找到最優質的中文字幕H動畫 24小時！免費享受hentai動漫，成人動畫，H動漫，並且更有中文字幕，不必再聽日語猜故事！這個網站是繼avbebe之後，亞洲最優質的色情工口Hentai成人動漫，並且有許多Hentai分類，包括顏射、乳交、口交、熟女、學生妹、中出、百合、肛交，以及更多！</p>

		<p>Hentai是什麼？Hentai（変態 或 へんたい），Hentai 或 成人動漫的詞源來自日本，並指色情或成人動漫和動畫，特別是來自日本的18禁H動漫和成人動畫。</p>
	</div>
</div>

<form id="hentai-form" action="{{ route('home.search') }}" method="GET">
	<input type="hidden" id="query" name="query" value="{{ Request::get('query') }}">
	<div id="tags" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content" style="border-radius: 3px; background-color: #424242; color: white">
	      <div class="modal-header" style="border-bottom: 1px solid #3a3c3f">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title" style="text-align: center">標籤</h4>
	      </div>
	      <div class="modal-body">
	      	<h4>
	      		廣泛配對
		      	<label class="hentai-switch" style="float: right">
					<input type="checkbox" name="broad" id="broad" {{ Request::get('broad') ? 'checked' : '' }}>
					<span class="hentai-slider round"></span>
				</label>
			</h4>
	        <p style="color: darkgray; padding-bottom: 15px">較多結果，較不精準。配對所有包含任何一個選擇的標籤的影片，而非全部標籤。</p>
	        <h4>包含標籤</h4>
	        <p id="hentai-tags-text" style="color: darkgray; padding-bottom: 10px">搜索包含所有以下選擇的標籤的影片：</p>
	        @foreach (App\Video::$hentai_tags as $tag)
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

<div style="background-color: #17181a; width: 100%; height: 40px; line-height: 40px">
	<span style="float: left;"><a href="/contact" class="hidden-xs hidden-sm" style="padding: 0px 15px; color: darkgray">廣告</a><a href="/about" class="hidden-xs hidden-sm" style="padding: 0px 15px; color: darkgray">娛見日本</a><a href="/about" style="padding: 0px 15px; color: darkgray">關於</a><a href="/contact" style="padding: 0px 15px; color: darkgray">聯絡</a></span><span style="float: right"><a href="/terms" style="padding: 0px 15px; color: darkgray"><span class="hidden-xs hidden-sm">服務</span>條款</a><a href="/policies" style="padding: 0px 15px; color: darkgray"><span class="hidden-xs hidden-sm">社群</span>規範</a><a href="/copyright" style="padding: 0px 15px; color: darkgray">版權<span class="hidden-xs hidden-sm">申訴</span></a></span>
</div>

@endsection