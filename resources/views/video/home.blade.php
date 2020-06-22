@extends('layouts.app')

@section('nav')
	@include('layouts.nav-home', ['theme' => 'white'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
  @include('layouts.sidebarMenu', ['theme' => 'white'])
</div>

<div class="new-main-content" style="margin-top: -50px;">
	<div style="background-color: white; text-align: center; position: relative;">
		<div style="margin: 0;position: absolute;top: 35%;left: 50%;transform: translate(-50%, -50%); width: 100%">
			<div class="row no-gutter load-more-container" style="padding-top: 19px;">
			  <h5 class="user-show-title home-subtitle">只有想不到，沒有找不到</h5>
			  <h3 class="user-show-title home-title">LaughSeeJapan</h3>
			</div>
			<form id="search-form" class="home-search-form" action="{{ route('video.search') }}" method="GET">
	          <i style="position: absolute; top: 13px; left: 17px; color: dimgray" class="material-icons">search</i>
	          <input name="query" type="text" value="{{ request('query') }}" placeholder="探索全世界的影片" autofocus>
		    </form>
		    <div class="trending-search-text">熱門搜索詞：<a style="padding-left: 5px" href="/search?query=anime1">anime1</a>|<a href="/search?query=動漫">動漫</a>|<a class="hidden-xs" href="/search?query=格萊普尼爾">格萊普尼爾</a><span class="hidden-xs">|</span><a class="hidden-xs" href="/search?query=原創動畫">原創動畫</a><span class="hidden-xs">|</span><a href="/search?query=綜藝">綜藝</a>|<a class="hidden-xs" href="/search?query=嵐Arashi">嵐Arashi</a><span class="hidden-xs">|</span><a class="hidden-xs" href="/search?query=松子Deluxe">松子Deluxe</a><span class="hidden-xs">|</span><a href="/search?query=日劇">日劇</a><span class="hidden-xs">|</span><a class="hidden-xs" href="/search?query=木村拓哉">木村拓哉</a></div>
	    </div>
	</div>
</div>

<div class="hidden-xs hidden-sm" style="background-color: #e8eaed; width: 100%; position: absolute; bottom: 0px; padding: 10px 10px; z-index: 100000;">
	<span style="float: left;"><a href="/contact" style="padding: 0px 15px; color: gray">廣告</a><a href="/about" style="padding: 0px 15px; color: gray">娛見日本</a><a href="/about" style="padding: 0px 15px; color: gray">關於</a><a href="/contact" style="padding: 0px 15px; color: gray">聯絡</a></span><span style="float: right"><a href="/terms" style="padding: 0px 15px; color: gray">服務條款</a><a href="/policies" style="padding: 0px 15px; color: gray">社群規範</a><a href="/copyright" style="padding: 0px 15px; color: gray">版權申訴</a></span>
</div>

@endsection