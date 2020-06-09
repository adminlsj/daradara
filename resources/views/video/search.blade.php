@extends('layouts.app')

@section('head')
    @parent
    <title>{{ $query }} - 娛見日本 LaughSeeJapan</title>
    <meta name="title" content="{{ $query }} - 娛見日本 LaughSeeJapan">
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

	@if ($user && $user->videos_count > 0)
		<div class="padding-setup hover-opacity-all" style="background-color: #F5F5F5; min-height: auto; padding-top: 13px;">
			<div id="search-top-watch" style="position: relative;">
			  <a href="{{ route('user.show', [$user]) }}" class="row no-gutter">
			    <div class="col-xs-6 col-sm-6 col-md-3" style="text-align: center;">
			    	<img class="lazy" style="width: calc((9 / 16) * 100%); height: auto; border-radius: 50%;" src="{{ $user->avatarCircleB() }}" data-src="{{ $user->avatar == null ? $user->avatarDefault() : $user->avatar->filename }}" data-srcset="{{ $user->avatar == null ? $user->avatarDefault() : $user->avatar->filename }}">
			    </div>
		    	<div class="search-user-text-wrapper" style="margin: 0; position: absolute; top: 50%; transform: translate(0%, -50%);">
					<h4 style="overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">{{ $user->name }}</h4>
					<p style="overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">5000 位訂閱者 • {{ $user->videos_count }} 部影片</p>
				</div>
			  </a>
			</div>
		</div>
	@endif

	@foreach ($watches as $watch)
		@if ($watch->videos->first())
			<div class="padding-setup hover-opacity-all" style="background-color: #F5F5F5; min-height: auto; padding-top: 13px;">
				<div id="search-top-watch">
				  <a href="{{ route('video.playlist') }}?list={{ $watch->id }}" class="row no-gutter">
				    <div class="col-xs-6 col-sm-6 col-md-3">
				      <img class="lazy" style="width: 100%; height: 100%;" src="{{ $watch->videos->first()->imgur16by9() }}" data-src="{{ $watch->videos->first()->imgurL() }}" data-srcset="{{ $watch->videos->first()->imgurL() }}" alt="{{ $watch->title }}">
				      <span>
				      	<div style="margin: 0;position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
					      	<div>{{ $watch->videos->count() }}</div>
					      	<i style="font-size: 1.6em; margin-right: -2px" class="material-icons">playlist_play</i>
					    </div>
				      </span>
				    </div>
				    <div class="col-xs-6 col-sm-6 col-md-7">
				      <h4 style="overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">{{ $watch->title }}</h4>
				      <p style="overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical;">創建者：{{ $watch->user()->name }}</p>
				      <p style="margin-top: 9px; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $watch->description }}</p>
				    </div>
				  </a>
				</div>
			</div>
		@endif
	@endforeach

	<div style="background-color: #F5F5F5;" class="padding-setup">
		<div class="row" style="padding-top: 6px; padding-bottom: 8px">
			<div class="col-md-12">
				<div style="margin-left: -10px; margin-right: -10px;" class="video-sidebar-wrapper">
					@foreach ($topResults as $video)
						@include('video.singleSearchVideo')
					@endforeach
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