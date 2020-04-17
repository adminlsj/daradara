@extends('layouts.app')

@section('head')
    @parent
    <title>{{ Request::get('q') }} - 娛見日本 LaughSeeJapan</title>
    <meta name="title" content="{{ Request::get('q') }} - 娛見日本 LaughSeeJapan">
    <meta name="description" 
          content="在娛見日本 LaughSeeJapan 上享受您最愛的影片、崁入原創內容，並與全世界觀眾分享您的影片。">
@endsection

@section('nav')
	@include('layouts.nav-main-original', ['theme' => 'white'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>

<div class="main-content">
	<div style="background-color: #F5F5F5; padding-bottom: 10px">

		<div style="margin: 0 auto 0 auto; padding-top: 10px; margin-bottom: 10px">
			<div style="background-color: white; padding-top: 1px; margin-left: 10px;">
				<div style="margin-left: -5px">
					<div class="video-slider-title paravi-padding-setup">
				    	<a href="{{ route('video.newest') }}"><h4>最新精彩內容<span class="hidden-xs">更多內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
				    </div>
				    @include('video.single-video-slider', ['videos' => $newest])
			    </div>
		    </div>
		</div>

		<div class="row paravi-padding-setup">
			<div style="overflow-y: hidden;">
				<div class="explore-slider-title" style="background-color: white; padding: 15px 0px 0px 18px; margin-bottom: -10px;">
		    		<a href="{{ route('video.newest') }}"><h4 style="font-weight: 500">搜索結果<span>最新內容</span><i class="material-icons">arrow_forward_ios</i></h4></a>
			    </div>
			    <script async src="https://cse.google.com/cse.js?cx=004204537983416081067:6ev1yqb2x3e"></script>
				<div class="gcse-searchresults-only"></div>
			</div>
		</div>

	</div>
</div>
@endsection