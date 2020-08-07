@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main-original-dark', ['theme' => 'white'])
@endsection

@section('content')

<div class="paravi-padding-setup" style="padding-top: 65px; background-color: #303030">
	<div style="text-align: center;">{!! $videos->render() !!}</div>
	<div class="row hentai-row-wrapper" style="{{ $videos->count() >= 48 || Request::get('page') > 1 ? 'margin-top: 5px;' : 'margin-top: 20px;' }}">
		@foreach ($videos as $video)
			<div class="col-xs-4 col-sm-3 col-md-2">
				<a href="/watch?v={{ $video->id }}" style="text-decoration: none;" class="hover-opacity-all" title="{{ $video->title }}">
					<img class="lazy" style="border-radius: 3px; width: 100%; height: 100%;" src="{{ App\Image::$portrait }}" data-src="{{ $video->cover }}" data-srcset="{{ $video->cover }}" alt="{{ $video->title }}">
					<div style="height: 65px; padding: 4px 1px; color: #fff; font-size: 0.95em; line-height: 19px;"><span style="overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $video->title }}</span></div>
				</a>
			</div>
		@endforeach
	</div>
	<div style="text-align: center;">{!! $videos->render() !!}</div>
</div>

<div style="background-color: #212121;">
	<div class="hentai-footer">
		<p>LaughSeeJapan hentai haven 帶給你最新最全的無碼高清中文字幕Hentai成人動漫。我們提供最優質的Hentai色情動漫裏番，並以最高畫質1080p呈現的Blu-ray rip。我們的18禁H漫網站適用於手機設備，並提供全網最優質的Hentai動畫。最新最全的Hentai裏番資料庫，LaughSeeJapan hentai 讓你一個按鈕觀看所有Hentai成人動畫，包括最新的2020年Hentai成人動漫。在這裏，你可以找到最優質的中文字幕H動畫 24小時！免費享受hentai動漫，成人動畫，H動漫，並且更有中文字幕，不必再聽日語猜故事！這個網站是繼avbebe之後，亞洲最優質的色情工口Hentai成人動漫，並且有許多Hentai分類，包括顏射、乳交、口交、熟女、學生妹、中出、百合、肛交，以及更多！</p>

		<p>Hentai是什麼？Hentai（変態 或 へんたい），Hentai 或 成人動漫的詞源來自日本，並指色情或成人動漫和動畫，特別是來自日本的18禁H動漫和成人動畫。</p>
	</div>
</div>

<form action="{{ route('home.hentai') }}" method="GET">
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
</form>

<div style="background-color: #17181a; width: 100%; height: 40px; line-height: 40px">
	<span style="float: left;"><a href="/contact" class="hidden-xs hidden-sm" style="padding: 0px 15px; color: darkgray">廣告</a><a href="/about" class="hidden-xs hidden-sm" style="padding: 0px 15px; color: darkgray">娛見日本</a><a href="/about" style="padding: 0px 15px; color: darkgray">關於</a><a href="/contact" style="padding: 0px 15px; color: darkgray">聯絡</a></span><span style="float: right"><a href="/terms" style="padding: 0px 15px; color: darkgray"><span class="hidden-xs hidden-sm">服務</span>條款</a><a href="/policies" style="padding: 0px 15px; color: darkgray"><span class="hidden-xs hidden-sm">社群</span>規範</a><a href="/copyright" style="padding: 0px 15px; color: darkgray">版權<span class="hidden-xs hidden-sm">申訴</span></a></span>
</div>

@endsection