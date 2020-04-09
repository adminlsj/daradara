@extends('layouts.app')

@section('head')
    @parent
    <title>{{ $query }} | 娛見日本 LaughSeeJapan</title>
    <meta name="title" content="{{ $query }} | 娛見日本 LaughSeeJapan">
    <meta name="description" 
              content="娛見日本 LaughSeeJapan 讓您享受最愛的影片、上傳原創內容，並與全世界觀眾分享您的影片。">
@endsection

@section('nav')
	@include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>

<div class="main-content">
	<div class="padding-setup" style="background-color: #e9e9e9; min-height: auto; padding-top: 11px; padding-bottom: 11px;">
		<div id="search-top-watch">
		  <a href="{{ route('video.intro', ['channel', $watch->titleToUrl()]) }}" class="row no-gutter">
		    <div class="col-xs-6 col-sm-6 col-md-3">
		      <img class="lazy" style="width: 100%; height: 100%;" src="{{ $watch->imgurDefault() }}" data-src="{{ $watch->imgurL() }}" data-srcset="{{ $watch->imgurL() }}" alt="{{ $watch->title }}">
		      <span>
		      	@if ($watch->genre == 'variety')
	                {{ Carbon\Carbon::parse($watch->updated_at)->diffForHumans() }}更新
	            @else
	                {{ $watch->is_ended ? '已完結全' : '更新至第' }}{{ $watch->videos()->count() }}集
	            @endif
		      </span>
		    </div>
		    <div class="col-xs-6 col-sm-6 col-md-7">
		      <h4 style="overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">{{ $watch->title }}</h4>
		      <p style="overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">{{ $watch->cast }}</p>
		      <p style="margin-top: 9px; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: {{ $watch->genre == 'variety' ? 3 : 10 }}; -webkit-box-orient: vertical;">{{ $watch->description }}</p>
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