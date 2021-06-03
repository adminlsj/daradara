@extends('layouts.app')

@section('nav')
	<div class="hidden-xs">
		@include('nav.main')
	</div>
	<div class="hidden-sm hidden-md hidden-lg" style="padding: 0 15px; height: 68px;">
	    <a class="hover-opacity" href="/" style="color: white; line-height: 68px;">
		    <img height="30" src="https://i.imgur.com/PTFz5Ej.png">
	    </a>

		<form id="search-form" style="display: inline-block; margin-left: 8px; width: calc(100% - 33px); position: relative;">
		    <i style="position: absolute; top: 8px; left: 17px; color: dimgray;" class="material-icons">search</i>
		    <input id="nav-query" name="query" style="box-shadow: none; outline: none; border: 1px solid rgba(58,60,63,.85); background-color: transparent; font-size: 1.1em;border-radius: 3px; height: 40px; color: darkgray; padding-bottom: 2px; font-weight: 500; transition: .3s cubic-bezier(0,0,.2,1); width: 100%; padding-left: 52px;" type="text" value="{{ request('query') }}" placeholder="搜索">
		</form>
	</div>
@endsection

@section('content')
<form id="hentai-form" action="{{ route('home.search') }}" method="GET">
	@include('video.search-nav')

	<div id="home-rows-wrapper" class="search-rows-wrapper" style="position: relative;">
	  	@if ($doujin)
		  	<div class="home-rows-videos-wrapper mobile-full-width" style="white-space: normal;">
			    @foreach ($videos as $video)
				    @include('video.card')
				@endforeach
			</div>
	    @else
		    <div class="home-rows-videos-wrapper" style="white-space: normal; margin-left: -2px; margin-right: -2px;">
			    @foreach ($videos as $video)
			      	<a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video['id'] }}" target="_blank">
				        <div class="home-rows-videos-div" style="position: relative; display: inline-block; margin-bottom:50px;">
				          <img src="{{ $video['cover'] }}">
				          <div class="home-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 3px 5px; background: linear-gradient(to bottom, transparent 0%, black 120%);">{{ $video['title'] }}</div>
				        </div>
				    </a>
			    @endforeach
			</div>
		@endif
		<div class="search-pagination hidden-xs">{!! $videos->appends(request()->input())->links() !!}</div>
		<div class="search-pagination mobile-search-pagination hidden-sm hidden-md hidden-lg">{!! $videos->appends(request()->input())->onEachSide(1)->links() !!}</div>

		@include('ads.home-top-squares')
	</div>

	<div id="tags" class="modal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content" style="border-radius: 3px; background-color: #222222; color: white">
	      <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
	        <span style="position: absolute; top: 20px; left: 16px; cursor: pointer; font-size: 24px;" class="material-icons pull-left no-select" data-dismiss="modal">close</span>
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

	<div id="brands" class="modal" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content" style="border-radius: 3px; background-color: #222222; color: white">
	      <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
	        <span style="position: absolute; top: 20px; left: 16px; cursor: pointer; font-size: 24px;" class="material-icons pull-left no-select" data-dismiss="modal">close</span>
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