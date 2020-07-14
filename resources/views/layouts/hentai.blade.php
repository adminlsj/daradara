@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
    @include('video.sidebarMenu', ['theme' => 'white'])
</div>

<div class="main-content">
	<div style="background-color: #F5F5F5;">
		<div class="row no-gutter load-more-container" style="padding-top: 19px;">
		  <h5 class="user-show-title" style="font-size: 1em; color: #555555; font-weight: normal; line-height: 0px">Hentai 紳士的成人動漫聖地</h5>
		  <h3 class="user-show-title" style="font-size: 2em; margin-top: 5px; margin-bottom: 10px">LaughSeeJapan 裏番</h3>
		</div>

		<div class="row no-gutter load-more-container">
		  <a href="/user/6944/playlists" style="color: inherit; text-decoration: none">
		    <h3 class="user-show-title">最新內容<i style="font-size: 0.85em; vertical-align: middle; margin-top: -3px; margin-left: 5px" class="material-icons">arrow_forward_ios</i></h3>
		  </a>
		  <div class="video-sidebar-wrapper">
		    @foreach ($newest as $watch)
		      <div class="{{ $loop->iteration > 4 ? 'hidden-xs' : ''}}">
		        @include('video.singleLoadMoreSliderPlaylists', ['video' => $watch->videos->first()])
		      </div>
		    @endforeach
		  </div>
		</div>

		<div class="row no-gutter load-more-container" style="margin-top: 5px;">
		  <a href="/search?query=裏番" style="color: inherit; text-decoration: none">
		    <h3 class="user-show-title">發燒影片<i style="font-size: 0.85em; vertical-align: middle; margin-top: -4px; margin-left: 5px" class="material-icons">arrow_forward_ios</i></h3>
		  </a>
		  <div class="video-sidebar-wrapper">
		    @foreach ($trending as $video)
		      <div class="{{ $loop->iteration > 4 ? 'hidden-xs' : ''}}">
		        @include('video.new-singleLoadMoreVideos')
		      </div>
		    @endforeach
		  </div>
		</div>

		<div class="row no-gutter load-more-container" style="margin-top: 5px;">
		  <a href="/user/6944/playlists" style="color: inherit; text-decoration: none">
		    <h3 class="user-show-title">精選推薦<i style="font-size: 0.85em; vertical-align: middle; margin-top: -4px; margin-left: 5px" class="material-icons">arrow_forward_ios</i></h3>
		  </a>
		  <div class="video-sidebar-wrapper">
		    @foreach ($random as $watch)
		      <div class="{{ $loop->iteration > 4 ? 'hidden-xs' : ''}}">
		        @include('video.singleLoadMoreSliderPlaylists', ['video' => $watch->videos->first()])
		      </div>
		    @endforeach
		  </div>
		</div>

		<br>
	</div>
</div>

@endsection