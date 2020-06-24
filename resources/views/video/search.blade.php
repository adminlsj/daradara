@extends('layouts.app')

@section('head')
    @parent
    <title>{{ $query }} - 娛見日本 LaughSeeJapan</title>
    <meta name="title" content="{{ $query }} - 娛見日本 LaughSeeJapan">
    <meta name="description" 
              content="娛見日本 LaughSeeJapan 讓您享受最愛的影片、上傳原創內容，並與全世界觀眾分享您的影片。">
@endsection

@section('nav')
<div class="hidden-xs">
	@include('layouts.nav-main-search', ['theme' => 'white'])
</div>
<div class="hidden-sm hidden-md hidden-lg">
	@include('layouts.nav-main-search-mobile', ['theme' => 'white'])
</div>
@endsection

@section('content')
<div class="new-main-content" style="margin-bottom: -50px">
	<div class="search-padding-setup">
		<div class="row" style="padding-top: 15px; padding-bottom: 8px">
			<div class="col-md-12">
				<div class="video-sidebar-wrapper">
					@if ($user && ($count = $user->watches()->count()) > 0)
						@include('video.card-user')
					@endif
					@foreach ($watches as $watch)
						@if ($watch->videos->first())
							@include('video.card-playlist', ['user' => $watch->user()])
						@endif
					@endforeach
					@foreach ($topResults as $video)
						@include('video.card')
					@endforeach
				    <div id="sidebar-results"><!-- results appear here --></div>
				    <div style="text-align: center;" class="ajax-loading"><img style="width: 40px; height: auto; padding-top: 25px; padding-bottom: 30px;" src="https://i.imgur.com/wgOXAy6.gif"/></div>
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