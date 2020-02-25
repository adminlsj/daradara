@extends('layouts.app')

@section('head')
    @parent
    <title>{{ $query }} | 娛見日本 LaughSeeJapan</title>
    <meta name="title" content="{{ $query }} | 娛見日本 LaughSeeJapan | 日本最強娛樂 | 綜藝 | 日劇 | 動漫">
    <meta name="description" 
              content="日本最強娛樂，最新綜藝！從綜藝到日劇和動漫，娛見日本 LaughSeeJapan 包攬最新最全的日娛王道！從搞笑到感動，從笑梗到溫情，從寵物到家庭，這裡可以找到讓你大笑，讓你痛哭，讓你重拾失去的情感，讓你回歸最原始的自己！這裡是日本，最強娛樂，最新綜藝，以及人文與文化！">
@endsection

@section('nav')
	@include('layouts.nav-main', ['theme' => 'white', 'logoImage' => 'https://i.imgur.com/M8tqx5K.png'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>

<div class="main-content">
	<div class="padding-setup" style="background-color: #e9e9e9; min-height: auto; padding-top: 7px; padding-bottom: 7px;">
		<div id="search-top-watch">
		  <a href="{{ route('video.intro', [$watch->genre, $watch->titleToUrl()]) }}" class="row no-gutter">
		    <div class="col-xs-6 col-sm-6 col-md-3">
		      <img style="width: 100%; height: 100%;" src="{{ $watch->imgurL() }}" alt="{{ $watch->title }}">
		      <span style="position: absolute; bottom:6px; right: 9px; background-color: rgba(0,0,0,0.8); color: white; padding: 1px 5px 1px 5px; opacity: 0.9; font-size: 0.85em; border-radius: 2px;">推薦</span>
		    </div>
		    <div class="col-xs-6 col-sm-6 col-md-7">
		      <h4>{{ $watch->title }}</h4>
		      <p style="overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">{{ $watch->cast }}</p>
		      <p style="margin-top: 9px; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $watch->description }}</p>
		    </div>
		  </a>
		</div>
	</div>
	<div style="background-color: #F5F5F5;" class="padding-setup">
		<div class="row" style="padding-top: 6px;">
			<div class="col-md-12">
				<div style="margin-left: -10px; margin-right: -10px;" class="video-sidebar-wrapper">
				    <div id="sidebar-results"><!-- results appear here --></div>
				    <div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 25px; padding-bottom: 30px;" src="https://i.imgur.com/TcZjkZa.gif"/></div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
	@parent
	<script src="{{ mix('js/loadMore.js') }}"></script>
@endsection