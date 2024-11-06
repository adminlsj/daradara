@extends('layouts.app')

@section('nav')
	<div class="hidden-xs">
		<div id="main-nav" style="z-index: 10000 !important; position: fixed !important; background-color: #141414 !important; margin-top: -3px;" class="main-nav hidden-xs">
		  @include('nav.main-content')
		</div>
	</div>
	<div id="main-nav-home-mobile" style="z-index: 10000 !important; overflow-x: hidden; background: black; background-color: black; transition: height 0.3s, background-color 0.4s, backdrop-filter 0.4s, -webkit-backdrop-filter 0.4s, top 0.4s;" class="hidden-sm hidden-md hidden-lg">

	  <div style="padding: 0 15px;">
	    <a href="/" style="padding-right: 2.5%; color: white; font-size: 1.40em; line-height: 57px; margin-left: 5px;">
	      <img style="width: 15px; margin-top: -7px; margin-right: 2px;" src="https://vdownload.hembed.com/image/icon/nav_logo.png?secure=HxkFdqiVxMMXXjau9riwGg==,4855471889">
	    </a>

	    <form id="search-form" style="display: inline-block; margin-left: 5px; width: calc(100% - 84px); position: relative;">
		    <input id="nav-query" name="nav-query" style="width: 100%; height: 32px; margin-top: -10px; vertical-align: middle; border-radius: 3px; background-color: #272727; border-color: #272727 !important; line-height: 32px; padding-left: 41px; font-size: 15px; padding-top: 4px" class="search-nav-bar" type="text" value="{{ request('query') }}" placeholder="搜尋 Hanime1.me">
		    <img style="width: 26px; position: absolute; top: 5px; left: 10px; opacity: 0.4;" src="https://vdownload.hembed.com/image/icon/search_input_placeholder.png?secure=10N-U1uEz-5YMgWwuLCfPw==,4855472065">
		</form>

		@if (Auth::check())
	      <a id="user-modal-trigger" href="{{ route('anime.search') }}" style="padding-left: 1px; padding-right: 0px; cursor: pointer;" class="nav-icon pull-right no-select" >
	          <img style="width: 24px; border-radius: 2px;" src="{{ Auth::user()->avatar_temp }}">
	      </a>
	    @else
	      <a id="user-modal-trigger" href="{{ route('login') }}" style="padding-left: 1px; padding-right: 0px; cursor: pointer;" class="nav-icon pull-right no-select" >
	          <img style="width: 24px; border-radius: 2px;" src="https://vdownload.hembed.com/image/icon/user_default_image.jpg?secure=ue9M119kdZxHcZqDPrunLQ==,4855471320">
	      </a>
	    @endif
	  </div>
	  @include('anime.search.search-nav-mobile')
	</div>
@endsection

@section('content')
<form style="overflow-y: hidden; overflow-x: hidden;" id="hentai-form" action="{{ route('anime.search') }}" method="GET">

	@include('anime.search.search-nav-desktop')

	<div id="home-rows-wrapper" class="search-rows-wrapper" style="padding-top: 150px;">

		<div class="hidden-sm hidden-md hidden-lg" style="text-align: center; margin-top: 110px; margin-bottom: -22px;">
			@include('layouts.exoclick', ['id' => '5058654', 'width' => '300', 'height' => '100'])
		</div>

		@include('layouts.card-wrapper', ['title' => '最近流行', 'videos' => $最近流行, 'link' => route('anime.search').'?genre=裏番'])
		@include('layouts.card-wrapper', ['title' => '本季熱門', 'videos' => $本季熱門, 'link' => route('anime.search').'?genre=裏番'])
		@include('layouts.card-wrapper', ['title' => '最新上市', 'videos' => $最新上市, 'link' => route('anime.search').'?genre=裏番'])
		@include('layouts.card-wrapper', ['title' => '最新上傳', 'videos' => $最新上傳, 'link' => route('anime.search').'?genre=裏番'])
		@include('layouts.card-wrapper', ['title' => '大家在看', 'videos' => $大家在看, 'link' => route('anime.search').'?genre=裏番'])
	</div>
</form>
<br><br>
@include('layouts.h1-footer')

@include('layouts.nav-bottom')

@endsection