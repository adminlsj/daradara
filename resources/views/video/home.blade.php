@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['theme' => 'white', 'logoImage' => 'https://i.imgur.com/M8tqx5K.png'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>
<div class="main-content">
	<div style="background-color: #F5F5F5;">
		<div style="overflow-x: hidden; padding-top:10px;">
			<div class="hidden-xs hidden-sm">
				<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
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

		    <div id='home-first-title' style="padding: 0px 20px; padding-bottom: 8px">
		      <h4>LaughSeeJapan熱門頻道<a href="{{ route('video.varietyList') }}" style="float: right; text-decoration: none; color: black"><i style="vertical-align:middle; font-size: 1em; margin-top: -3.5px;" class="material-icons">arrow_forward_ios</i></a></h4>
		    </div>
		    <div id="custom-scroll-slider">
			    @foreach ($selected as $watch)
		          <div style="border-radius: 10px; box-shadow: 1px 4px 6px rgba(0,0,0,0.1); width: 150px !important; background: #fff; display: inline-block; vertical-align: text-top;">
		            <a style="text-decoration: none; color: black" href="{{ route('video.intro', [$watch->genre, $watch->titleToUrl()]) }}">
		              <img class="lazy" style="width: 100%; height: 100%; border-top-left-radius: 10px; border-top-right-radius: 10px;" src="{{ $watch->imgurDefault() }}" data-src="{{ $watch->imgurL() }}" data-srcset="{{ $watch->imgurL() }}" alt="{{ $watch->title }}">

		              <div style="height: 47px; padding: 2px 15px;">
		                <h4 style="line-height: 19px; font-size: 1em;overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; font-weight: 450; white-space: initial">{{ $watch->title }}</h4>
		              </div>
		            </a>
		          </div>
		        @endforeach
	        </div>

	        @if (count($subscribes) != 0)
	        	<div style="margin-top: 25px; padding: 0px 20px; padding-bottom: 9px">
			      <h4>最新訂閱內容</h4>
			    </div>
			    @include('video.single-video-slider', ['videos' => $subscribes])
			    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 show-more-btn">
			      <a href="{{ route('video.subscribes') }}">
			        <div>顯示更多</div>
			      </a>
			    </div>
	        @endif

		    <div style="margin-top: {{ count($subscribes) != 0 ? '70px' : '25px' }}; padding: 0px 20px; padding-bottom: 9px">
		      <h4>最夯發燒影片</h4>
		    </div>
		    @include('video.single-video-slider', ['videos' => $trendings])
		    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 show-more-btn">
		      <a href="{{ route('video.rank') }}">
		        <div>顯示更多</div>
		      </a>
		    </div>

		    <div style="margin-top: 70px; padding: 0px 20px; padding-bottom: 9px">
		      <h4>最新精彩內容</h4>
		    </div>
		    @include('video.single-video-slider', ['videos' => $newest])
		    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 show-more-btn">
		      <a href="{{ route('video.newest') }}?g=variety">
		        <div>顯示更多</div>
		      </a>
		    </div>

		    <div style="margin-top: 70px; padding: 0px 20px; padding-bottom: 9px">
		      <h4>綜藝推薦</h4>
		    </div>
		    @include('video.single-video-slider', ['videos' => $variety])
		    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 show-more-btn">
		      <a href="{{ route('video.rank') }}?g=variety">
		        <div>顯示更多</div>
		      </a>
		    </div>

		    <div style="margin-top: 70px; padding: 0px 20px; padding-bottom: 9px">
		      <h4>日劇推薦</h4>
		    </div>
		    @include('video.single-video-slider', ['videos' => $drama])
		    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 show-more-btn">
		      <a href="{{ route('video.drama') }}">
		        <div>顯示更多</div>
		      </a>
		    </div>

		    <div style="margin-top: 70px; padding: 0px 20px; padding-bottom: 9px">
		      <h4>動漫推薦</h4>
		    </div>
		    @include('video.single-video-slider', ['videos' => $anime])
		    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 show-more-btn">
		      <a href="{{ route('video.anime') }}">
		        <div>顯示更多</div>
		      </a>
		    </div>

		    <div style="margin-top: 70px; padding: 0px 20px; padding-bottom: 9px">
		      <h4>更多發燒影片</h4>
		    </div>
		    <div class="row no-gutter" style="padding: 0px 15px">
		      <div class="video-sidebar-wrapper">
		          <div id="sidebar-results"><!-- results appear here --></div>
		          <div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 25px; padding-bottom: 50px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
		      </div>
		    </div>
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