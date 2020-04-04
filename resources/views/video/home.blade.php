@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['theme' => 'white', 'logoImage' => 'https://i.imgur.com/M8tqx5K.png'])
@endsection

@section('content')
<div style="background-color: #FEFEFE;">

	<div class="row no-gutter paravi-padding-setup hidden-xs hidden-sm" style="margin: 20px auto 50px auto; position:relative;">
		@foreach ($selected as $watch)
			<div class="col-xs-3 col-sm-2 col-md-2 hover-opacity">
				@if ($loop->iteration == 9 || $loop->iteration == 10)
					<img style="width: 100%; height: 100%; display: inline-block;" src="https://i.imgur.com/JlOsTjd.jpg">
				@else
					<a href="{{ route('video.intro', [$watch->genre, $watch->titleToUrl()]) }}">
						<img class="lazy" style="width: 100%; height: 100%; display: inline-block;" src="{{ $watch->imgurDefault() }}" data-src="{{ $watch->imgurL() }}" data-srcset="{{ $watch->imgurL() }}" alt="{{ $watch->title }}">
					</a>
				@endif
			</div>
		@endforeach
		<div class="col-xs-6 col-sm-4 col-md-4" style="position: absolute; top: 50%; left: 50%; -ms-transform: translate(-50%, -50%); transform: translate(-50%, -50%);">
			<div style="width: 100%; height: 100%; text-align: center">
				<div style="font-weight: 500; font-size: 1.5em; padding-bottom: 1vw; margin-top: -15px">LaughSeeJapan 娛見日本</div>
				<a href="{{ route('video.varietyList') }}" style="background-color: #d84b6b; color: white; padding: 10px 40px; border-radius: 50px; font-size: 1em">更多熱門頻道<i style="vertical-align: middle; font-size: 0.8em; margin-top: -2px; margin-left: 5px; margin-right: -5px" class="material-icons">arrow_forward_ios</i></a>
			</div>
		</div>
	</div>

	<div class="hidden-md hidden-lg hover-opacity" style="margin-bottom: 50px;">
		<a href="{{ route('video.varietyList') }}">
			<img style="width: 100%; height: 100%; display: inline-block;" src="https://i.imgur.com/CssRcYDh.jpg" alt="LaughSeeJapan 娛見日本">
		</a>
	</div>

	<div class="paravi-padding-setup" style="padding: 0px 6%; padding-bottom: 12px">
		<div style="border: 1px solid black">
			<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- Home Desktop Ads -->
			<ins class="adsbygoogle"
			     style="display:block;"
			     data-ad-client="ca-pub-4485968980278243"
			     data-ad-slot="4478704168"
			     data-ad-format="auto"
			     data-full-width-responsive="true"></ins>
			<script>
			     (adsbygoogle = window.adsbygoogle || []).push({});
			</script>
		</div>
	</div>

	<div class="paravi-padding-setup home-featured-wrapper">
		<div class="row no-gutter">
			<a href="{{ route('video.intro', ['drama', '半澤直樹-第二季']) }}" class="col-xs-6 col-sm-4 hover-opacity-all">
				<img style="width: 100%; height: 100%; display: inline-block;" src="https://i.imgur.com/LwQAG3Yh.jpg">
				<div style="margin-top: 0.7vw">
					<span class="featured-new-tag">NEW</span>
					<span class="featured-catchphrase">那個加倍奉還的男人！</span>
				</div>
			</a>
			<a href="{{ route('video.intro', ['drama', '默默奉獻的灰姑娘-醫院藥劑師的處方箋']) }}" class="col-xs-6 col-sm-4 hover-opacity-all">
				<img style="width: 100%; height: 100%; display: inline-block;" src="https://i.imgur.com/coFdG2lh.jpg">
				<div style="margin-top: 0.7vw">
					<span class="featured-new-tag">NEW</span>
					<span class="featured-catchphrase">白衣天使的石原女神！</span>
				</div>
			</a>
			<a href="{{ route('video.intro', ['drama', 'MIU404']) }}" class="col-xs-4 hover-opacity-all hidden-xs">
				<img style="width: 100%; height: 100%; display: inline-block;" src="https://i.imgur.com/2loSVtch.jpg">
				<div style="margin-top: 0.7vw">
					<span class="featured-new-tag">NEW</span>
					<span class="featured-catchphrase">搞笑偵探拍檔雙上陣！</span>
				</div>
			</a>
		</div>
	</div>

    @if (count($subscribes) != 0)
    	<div class="video-slider-title paravi-padding-setup">
	      <h4>最新訂閱內容<a href="{{ route('video.subscribes') }}">更多內容<i class="material-icons">arrow_forward_ios</i></a></h4>
	    </div>
	    @include('video.single-video-slider', ['videos' => $subscribes])
    @endif

    <div class="video-slider-title paravi-padding-setup">
    	<a href="{{ route('video.rank') }}"><h4>最夯發燒影片<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
    </div>
    @include('video.single-video-slider', ['videos' => $trendings])

    <div class="video-slider-title paravi-padding-setup">
    	<a href="{{ route('video.newest') }}"><h4>最新精彩內容<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
    </div>
    @include('video.single-video-slider', ['videos' => $newest])

    <div class="video-slider-title paravi-padding-setup">
    	<a href="{{ route('video.rank') }}"><h4>綜藝推薦<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
    </div>
    @include('video.single-video-slider', ['videos' => $variety])

    <div class="video-slider-title paravi-padding-setup">
    	<a href="{{ route('video.drama') }}"><h4>日劇推薦<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
    </div>
    @include('video.single-video-slider', ['videos' => $drama])

    <div class="video-slider-title paravi-padding-setup">
    	<a href="{{ route('video.anime') }}"><h4>動漫推薦<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
    </div>
    @include('video.single-video-slider', ['videos' => $anime])

    <div class="video-slider-title paravi-padding-setup">
    	<a href="{{ route('video.rank') }}"><h4>更多發燒影片<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
    </div>
    <div class="row no-gutter" style="padding: 0px calc(4% - 5px)">
      <div class="video-sidebar-wrapper">
          <div id="sidebar-results"><!-- results appear here --></div>
          <div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 25px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
      </div>
    </div>
</div>

<!-- Initialize Swiper -->
<script>
  var swiper = new Swiper('.swiper-container', {
    slidesPerView: 'auto',
    freeMode: true,
    mousewheel: true,
    spaceBetween: 10,
  });
</script>

@endsection

@section('script')
  @parent
  <script src="{{ mix('js/loadMore.js') }}"></script>
@endsection