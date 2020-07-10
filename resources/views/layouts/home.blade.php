@extends('layouts.app')

@section('content')

<div class="hidden-sm hidden-xs sidebar-menu">
  @include('layouts.sidebarMenu', ['theme' => 'white'])
</div>

<div style="height: 100vh; background: url('https://i.imgur.com/ankEp1y.jpg') no-repeat fixed center; background-size: cover;">
	<span id="home-menu-btn" class="pull-left nav-item-icon no-select hidden-xs hidden-sm" style="text-decoration: none; line-height: 50px; margin-top: -1px; left: 23px; color: gray; cursor: pointer;">
		<span class="material-icons">menu</span>
	</span>

	<div style="padding: 0 20px">
		<a class="nav-item-icon" style="right: 16px; color: dimgray" href="{{ Auth::check() ? route('user.show', Auth::user()) : route('login')}}"><i class="material-icons">account_circle</i></a>
		<a href="{{ route('video.subscribes') }}" class="nav-item-icon" style="top: 10px; right: 62px; cursor: pointer; color: dimgray"><i style="font-size: 1.65em" class="material-icons">subscriptions</i></a>
		<a id="nav-account-icon" class="pull-right nav-item-icon" style="right: 105px; color: dimgray" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login')}}"><i class="material-icons">video_call</i></a>
	</div>

	<div style="margin: 0;position: absolute;top: 46%;left: 50%;transform: translate(-50%, -50%); width: 100%;">
		<div style="text-align: center">
			<img style="height: 35px;" src="https://i.imgur.com/5Hi5Sx7.png">
		</div>
		<form id="search-form" class="home-search-form" action="{{ route('video.search') }}" method="GET">
          <i style="position: absolute; top: 13px; left: 17px; color: dimgray" class="material-icons">search</i>
          <input name="query" type="text" value="{{ request('query') }}" placeholder="探索全世界的影片" autofocus>

          <div class="home-suggestion-tab" style="margin-top: 25px; padding: 0px 10px">
	          <div class="no-select"><a href="/search?query=動漫">動漫</a></div>
	          <div class="no-select"><a href="/search?query=原創動畫">原創動畫</a></div>
	          <div class="no-select"><a href="/search?query=新番">新番</a></div>
	          <div class="no-select"><a href="/search?query=anime1">anime1</a></div>
	          <div class="no-select"><a href="/search?query=日劇">日劇</a></div>
	          <div class="no-select"><a href="/search?query=綜藝">綜藝</a></div>
	          <div class="no-select"><a href="/search?query=嵐Arashi">嵐Arashi</a></div>
	          <div class="no-select"><a href="/search?query=松子Deluxe">松子Deluxe</a></div>
	          <div class="no-select"><a href="/search?query=Downtown">Downtown</a></div>
	          <div class="no-select"><a href="/search?query=倫敦之心">倫敦之心</a></div>
	          <div class="no-select"><a href="/search?query=Running+Man">Running Man</a></div>
	          <div class="no-select hidden-xs"><a href="/search?query=明星">明星</a></div>
	          <div class="no-select hidden-xs"><a href="/search?query=木村拓哉">木村拓哉</a></div>
	          <div class="no-select hidden-xs"><a href="/search?query=石原聰美">石原聰美</a></div>
	          <div class="no-select hidden-xs"><a href="/search?query=WEB動畫">WEB動畫</a></div>
	          <div class="no-select hidden-xs"><a href="/search?query=裏番">裏番</a></div>
	          <div class="no-select hidden-xs"><a href="/search?query=動畫廣告">動畫廣告</a></div>
	          <div class="no-select hidden-xs"><a href="/search?query=迷因翻譯">迷因翻譯</a></div>
	          <div class="no-select hidden-xs"><a href="/search?query=日本創意廣告">日本創意廣告</a></div>
	          <div class="no-select hidden-xs"><a href="/search?query=MAD·AMV">MAD·AMV</a></div>
	          <div class="no-select hidden-xs"><a href="/search?query=日本人氣YouTuber">日本人氣YouTuber</a></div>
          </div>
	    </form>
    </div>
</div>

<div class="hidden-xs" style="background-color: #333333; width: 100%; position: absolute; bottom: 0px; padding: 10px 10px; z-index: 100000;">
	<span style="float: left;"><a href="/contact" style="padding: 0px 15px; color: dimgray">廣告</a><a href="/about" style="padding: 0px 15px; color: dimgray">娛見日本</a><a href="/about" style="padding: 0px 15px; color: dimgray">關於</a><a href="/contact" style="padding: 0px 15px; color: dimgray">聯絡</a></span><span style="float: right"><a href="/terms" style="padding: 0px 15px; color: dimgray">服務條款</a><a href="/policies" style="padding: 0px 15px; color: dimgray">社群規範</a><a href="/copyright" style="padding: 0px 15px; color: dimgray">版權申訴</a></span>
</div>

@include('layouts.nav-bottom')

@endsection