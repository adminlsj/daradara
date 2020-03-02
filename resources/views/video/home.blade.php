@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['theme' => 'white', 'logoImage' => 'https://i.imgur.com/M8tqx5K.png'])
	@include('layouts.nav-home-mobile')
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>
<div class="main-content">
	<div style="background-color: #F5F5F5;" class="nav-home-mobile-padding">
		<div id="myCarousel" class="carousel slide" data-ride="carousel" style="{{ !Request::has('g') || Request::get('g') == 'newest' ? '' : 'display:none;' }}">
		  <!-- Indicators -->
		  <ol class="carousel-indicators">
		    <li data-target="#myCarousel" data-slide-to="0" class="{{ !Request::has('g') ? 'active' : '' }}"></li>
		    <li data-target="#myCarousel" data-slide-to="1" class="{{ Request::has('g') && Request::get('g') == 'newest' ? 'active' : ''}}"></li>
		  </ol>

		  <!-- Wrapper for slides -->
		  <div class="carousel-inner">
		    <div class="banner item {{ !Request::has('g') ? 'active' : '' }}">
				<a href="{{ route('video.intro', ['variety', '月曜夜未央']) }}">
					<div class="banner-img-container" style="position: relative; background-color: #080B1A;">
						<img src="https://i.imgur.com/Zb9Tnxe.png" alt="月曜夜未央">
						<div class="button">立即觀看</div>
					</div>
				</a>
			</div>

		    <div class="banner item {{ Request::has('g') && Request::get('g') == 'newest' ? 'active' : ''}}">
				<a href="{{ route('video.intro', ['variety', '交給嵐吧_嵐的大挑戰']) }}">
					<div class="banner-img-container" style="position: relative; background-color: #EAE5B9;">
						<img src="https://i.imgur.com/kJylGtE.png" alt="交給嵐吧 / 嵐的大挑戰">
						<div style="color: #372020; border-color: #372020" class="button">立即觀看</div>
					</div>
				</a>
			</div>
		  </div>
		</div>

		<div class="padding-setup" style="overflow-x: hidden; {{ !Request::has('g') || Request::get('g') == 'newest' ? 'padding-top: 10px' : '' }}">
			<div class="row home-video-wrapper">
				@foreach ($videos as $video)
					@include('video.singleHomeVideo')
				@endforeach
			</div>

			@if (!Request::has('g'))
				<div class="row" style="padding-top:4px; padding-bottom: 4px;">
					<div class="col-md-12">
						<h4>
							綜藝推薦
							<a href="{{ route('video.rank') }}?g=variety" style="text-decoration: none; color: #323232;" class="pull-right">
								<i style="color:#323232; vertical-align:middle; font-size: 1.4em; margin-top: -3px; margin-right: -3px;" class="material-icons">bar_chart</i>
								排行榜
								<i style="color:darkgray; vertical-align:middle; font-size: 1em; margin-top: -3px;" class="material-icons">arrow_forward_ios</i>
							</a>
						</h4>
					</div>
				</div>
				<div class="row home-video-wrapper">
					@foreach ($variety as $video)
						@include('video.singleHomeVideo')
					@endforeach
				</div>

				<div class="row" style="padding-top:4px; padding-bottom: 4px;">
					<div class="col-md-12">
						<h4>
							日劇推薦
							<a href="{{ route('video.rank') }}?g=drama" style="text-decoration: none; color: #323232;" class="pull-right">
								<i style="color:#323232; vertical-align:middle; font-size: 1.4em; margin-top: -3px; margin-right: -3px;" class="material-icons">bar_chart</i>
								排行榜
								<i style="color:darkgray; vertical-align:middle; font-size: 1em; margin-top: -3px;" class="material-icons">arrow_forward_ios</i>
							</a>
						</h4>
					</div>
				</div>
				<div class="row home-video-wrapper">
					@foreach ($drama as $video)
						@include('video.singleHomeVideo')
					@endforeach
				</div>

				<div class="row" style="padding-top:4px; padding-bottom: 4px;">
					<div class="col-md-12">
						<h4>
							動漫推薦
							<a href="{{ route('video.rank') }}?g=anime" style="text-decoration: none; color: #323232;" class="pull-right">
								<i style="color:#323232; vertical-align:middle; font-size: 1.4em; margin-top: -3px; margin-right: -3px;" class="material-icons">bar_chart</i>
								排行榜
								<i style="color:darkgray; vertical-align:middle; font-size: 1em; margin-top: -3px;" class="material-icons">arrow_forward_ios</i>
							</a>
						</h4>
					</div>
				</div>
				<div class="row home-video-wrapper">
					@foreach ($anime as $video)
						@include('video.singleHomeVideo')
					@endforeach
				</div>
			@endif
		</div>
	</div>
</div>
@endsection