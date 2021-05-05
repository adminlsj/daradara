@extends('layouts.app')

@section('nav')
	<nav id="hentai-main-nav" style="background-image: linear-gradient(to bottom,rgba(0,0,0,.7) 10%,rgba(0,0,0,0)); z-index: 100">
	  <a id="hentai-logo" class="pull-left hidden-md hidden-sm hidden-xs" href="/" style="color: white; font-size: 1.4em;">
	      <span style="color: crimson">H</span>anime1<span style="color: crimson">.</span>me
	  </a>

	  <a class="pull-left hidden-lg hover-opacity" href="/" style="color: white; line-height: 68px;">
	      <img height="30" src="https://i.imgur.com/PTFz5Ej.png">
	  </a>

	  <form id="search-form" class="pull-left">
	      <i style="position: absolute; top: 8px; left: 17px; color: dimgray" class="material-icons">search</i>
	      <input id="nav-query" name="query" style="box-shadow: none; border: 1px solid rgba(58,60,63,.85); background-color: transparent; font-size: 1.1em;border-radius: 3px; height: 40px; padding-left: 53px; color: darkgray; padding-bottom: 2px; font-weight: 500; transition: .3s cubic-bezier(0,0,.2,1);" type="text" value="{{ request('query') }}" placeholder="搜索">
	  </form>

	  @if (Auth::check())
	    <a class="hidden-xs hidden-sm hidden-md nav-item-icon" style="top: 17px; right: 4%; color: white;" href="{{ route('home.list') }}"><i class="material-icons">account_circle</i></a>
	    <a class="hidden-xs hidden-sm hidden-md nav-item-icon" style="top: 17px; right: calc(4% + 50px); color: white;" href="{{ route('user.userEditUpload', Auth::user()) }}"><i class="material-icons">video_call</i></a>
	  @else
	    <a class="no-select pull-right hidden-xs hidden-sm hidden-md" style="margin-right: 5px; line-height: 67px; color: white; font-weight: bold;" href="{{ route('login') }}">登入</a>
	    <a class="no-select pull-right hidden-xs hidden-sm hidden-md" style="color: white; line-height: 67px; font-weight: bold; margin-right: 30px" href="{{ route('register') }}">註冊</a>
	    <a class="no-select pull-right hidden-xs hidden-sm hidden-md" style="line-height: 67px; margin-top: 7px; margin-right: 30px;" href="{{ route('login') }}"><i class="material-icons" style="color: white;">video_call</i></a>
	  @endif
	</nav>
@endsection

@section('content')

<div id="home-rows-wrapper" style="position: relative; margin-top: 78px; padding: 0px 15px; margin-bottom: 70px; color: white">
	<form id="hentai-form" action="{{ route('home.search') }}" method="GET">
		<input type="hidden" id="query" name="query" value="{{ Request::get('query') }}">

		<h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold; color: darkgray">分類：</h5>
        @foreach (App\Video::$genre as $tag)
        	<label class="hentai-tags-wrapper">
			  <input name="tags[]" type="checkbox" value="{{ $tag }}">
			  <span class="checkmark">{{ $tag }}</span>
			</label>
        @endforeach

        <h5 style="margin-bottom: 15px; font-weight: bold; color: darkgray">人物設定：</h5>
        @foreach (App\Video::$setting as $tag)
        	<label class="hentai-tags-wrapper">
			  <input name="tags[]" type="checkbox" value="{{ $tag }}">
			  <span class="checkmark">{{ $tag }}</span>
			</label>
        @endforeach

        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold; color: darkgray">職業設定：</h5>
        @foreach (App\Video::$profession as $tag)
        	<label class="hentai-tags-wrapper">
			  <input name="tags[]" type="checkbox" value="{{ $tag }}">
			  <span class="checkmark">{{ $tag }}</span>
			</label>
        @endforeach

        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold; color: darkgray">外貌身材：</h5>
        @foreach (App\Video::$appearance as $tag)
        	<label class="hentai-tags-wrapper">
			  <input name="tags[]" type="checkbox" value="{{ $tag }}">
			  <span class="checkmark">{{ $tag }}</span>
			</label>
        @endforeach

        <h5 style="margin-top: 15px; margin-bottom: 15px; font-weight: bold; color: darkgray">劇情內容：</h5>
        @foreach (App\Video::$storyline as $tag)
        	<label class="hentai-tags-wrapper">
			  <input name="tags[]" type="checkbox" value="{{ $tag }}">
			  <span class="checkmark">{{ $tag }}</span>
			</label>
        @endforeach
	</form>
</div>

@include('layouts.nav-bottom')

@endsection