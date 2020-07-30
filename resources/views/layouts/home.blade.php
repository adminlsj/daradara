@extends('layouts.app')

@section('content')

<div class="hidden-sm hidden-xs sidebar-menu">
  @include('layouts.sidebarMenu', ['theme' => 'white'])
</div>

<div style="height: 100%;">
	<span id="home-menu-btn" class="pull-left nav-item-icon no-select hidden-xs hidden-sm" style="text-decoration: none; line-height: 50px; margin-top: -1px; left: 23px; color: gray; cursor: pointer;">
		<span class="material-icons">menu</span>
	</span>

	<div style="padding: 0 20px">
		@if (Auth::check())
	        <a class="hidden-xs hidden-sm nav-item-icon" style="right: 26px; color: #666666;" href="{{ route('user.show', Auth::user()) }}"><i class="material-icons">account_circle</i></a>
	        <a class="hidden-xs hidden-sm nav-item-icon" style="top: 9px; right: 76px; color: #666666;" href="{{ route('video.subscribes') }}"><i class="material-icons" style="font-size: 1.7em">subscriptions</i></a>
	        <a class="hidden-xs hidden-sm nav-item-icon" style="right: 122px; color: #666666;" href="{{ route('user.userEditUpload', Auth::user()) }}"><i class="material-icons">video_call</i></a>
	    @else
	        <a class="no-select nav-item-text hidden-xs hidden-sm" style="color: #e8eaed; border: 1px solid #e8eaed; padding: 8px 14px; margin-top: 5px; margin-right: 7px; font-weight: bold; color: #666666" href="{{ route('login') }}">登入</a>
	        <a class="no-select nav-item-text hidden-xs hidden-sm" style="color: white; background-color: #e8eaed; border-color: #e8eaed; padding: 7px 14px; margin-top: 5px; font-weight: bold; color: #666666;" href="{{ route('register') }}">註冊</a>
	        <a class="no-select pull-right hidden-xs hidden-sm" style="margin-top: 8px; margin-right: 18px; color: #666666;" href="{{ route('login') }}"><i class="material-icons">video_call</i></a>
	    @endif

		<a class="hidden-md hidden-lg nav-item-icon" style="right: 16px; color: #666666;" href="{{ Auth::check() ? route('user.show', Auth::user()) : route('login')}}"><i class="material-icons">account_circle</i></a>
		<a id="toggleSearchBar" class="hidden-md hidden-lg nav-item-icon" style="right: 60px; cursor: pointer; color: #666666;"><i class="material-icons">search</i></a>
		<a id="nav-account-icon" class="pull-right hidden-md hidden-lg nav-item-icon" style="right: 104px; color: #666666;" href="{{ Auth::check() ? route('user.userEditUpload', Auth::user()) : route('login')}}"><i class="material-icons">video_call</i></a>
	</div>

	<div style="margin: 0;position: absolute;top: 46%;left: 50%;transform: translate(-50%, -50%); width: 100%;">
		<div class="home-logo" style="text-align: center">
			<img src="https://i.imgur.com/5Hi5Sx7.png">
		</div>
		<form id="search-form" class="home-search-form" action="{{ route('video.search') }}" method="GET">
          <i style="position: absolute; top: 13px; left: 17px; color: dimgray" class="material-icons">search</i>
          <input name="query" type="text" value="{{ request('query') }}" placeholder="探索全世界的影片" autofocus>

          <div class="home-suggestion-tab" style="margin-top: 30px; padding: 0px 10px">
	          <div class="no-select"><a href="/search?query=動漫">動漫</a></div>
	          <div class="no-select"><a href="/search?query=原創動畫">原創動畫</a></div>
	          <div class="no-select"><a href="/search?query=新番">新番</a></div>
	          <div class="no-select"><a href="/user/746">anime1</a></div>
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
	          <div class="no-select hidden-xs"><a href="/hentai">裏番</a></div>
	          <div class="no-select hidden-xs"><a href="/search?query=動畫廣告">動畫廣告</a></div>
	          <div class="no-select hidden-xs"><a href="/search?query=迷因翻譯">迷因翻譯</a></div>
	          <div class="no-select hidden-xs"><a href="/search?query=日本創意廣告">日本創意廣告</a></div>
	          <div class="no-select hidden-xs"><a href="/search?query=MAD·AMV">MAD·AMV</a></div>
	          <div class="no-select hidden-xs"><a href="/search?query=日本人氣YouTuber">日本人氣YouTuber</a></div>
          </div>
	    </form>
    </div>
</div>

<div class="hidden-xs hidden-sm" style="background-color: #e8eaed; width: 100%; position: absolute; bottom: 0px; padding: 10px 10px; z-index: 100000;">
	<span style="float: left;"><a href="/contact" style="padding: 0px 15px; color: darkgray">廣告</a><a href="/about" style="padding: 0px 15px; color: darkgray">娛見日本</a><a href="/about" style="padding: 0px 15px; color: darkgray">關於</a><a href="/contact" style="padding: 0px 15px; color: darkgray">聯絡</a></span><span style="float: right"><a href="/terms" style="padding: 0px 15px; color: darkgray">服務條款</a><a href="/policies" style="padding: 0px 15px; color: darkgray">社群規範</a><a href="/copyright" style="padding: 0px 15px; color: darkgray">版權申訴</a></span>
</div>

@include('layouts.nav-bottom')

@endsection