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
<div class="new-main-content">
	<div style="background-color: #F5F5F5;" class="paravi-padding-setup">
		<form id="search-form" class="hidden-md hidden-lg" style="width: 100%; position: relative; padding-top: 15px" action="{{ route('video.search') }}" method="GET">
	        <input name="query" style="width: 100%; box-shadow: none; border: 1px solid #e8eaed; background-color: #e8eaed; font-size: 1.1em;border-radius: 7px; height: 40px; padding-left: 13px; color: #222222; padding-bottom: 2px; font-weight: 500; -webkit-appearance: none;" type="text" value="{{ request('query') }}" placeholder="搜索">
	        <a class="search-submit-btn" type="submit" style="position: absolute; top: 19px; right: 15px; color: dimgray; cursor: pointer;"><i class="material-icons">search</i></a>
	    </form>
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