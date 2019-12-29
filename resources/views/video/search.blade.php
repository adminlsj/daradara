@extends('layouts.app')

@section('head')
    @parent
    <title>{{ $query }} | 娛見日本 LaughSeeJapan</title>
    <meta name="title" content="{{ $query }} | 娛見日本 LaughSeeJapan | 日本最強娛樂 | 綜藝 | 日劇 | 動漫">
    <meta name="description" 
              content="日本最強娛樂，最新綜藝！從綜藝到日劇和動漫，娛見日本 LaughSeeJapan 包攬最新最全的日娛王道！從搞笑到感動，從笑梗到溫情，從寵物到家庭，這裡可以找到讓你大笑，讓你痛哭，讓你重拾失去的情感，讓你回歸最原始的自己！這裡是日本，最強娛樂，最新綜藝，以及人文與文化！">
@endsection

@section('nav')
	@include('layouts.nav-main', ['logoImage' => 'https://i.imgur.com/M8tqx5K.png', 'backgroundColor' => 'white', 'itemsColor' => "gray"])
@endsection

@section('content')
<div class="padding-setup mobile-container">
	<div class="row" style="padding-top: 6px;">
		<div class="col-md-12">
			<h4 style="color: black; font-weight: 500; margin-bottom: 8px;"><a href="{{ route('blog.search')}}?query={{ $query }}">#{{ $query }}</a> 標籤的影片</h4>
			<div style="margin-left: -10px; margin-right: -10px;" class="video-sidebar-wrapper">
			    <div id="sidebar-results"><!-- results appear here --></div>
			    <div style="text-align: center" class="ajax-loading"><img src="https://s3.amazonaws.com/twobayjobs/system/loading.gif"/></div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
	@parent
	<script src="{{ mix('js/loadMore.js') }}"></script>
@endsection