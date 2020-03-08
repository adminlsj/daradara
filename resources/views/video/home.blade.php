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
		<div class="padding-setup" style="overflow-x: hidden;">
			<div class="home-ads-wrapper">
				<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- Horizontal Banner Ads -->
				<ins class="adsbygoogle"
				     style="display:inline-block; width: calc(100%); border: 1px solid black"
				     data-ad-client="ca-pub-4485968980278243"
				     data-ad-slot="8455082664"></ins>
				<script>
				     (adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>

			<div class="row" style="padding-top:6px; padding-bottom: 4px;">
				<div class="col-md-12">
					<h4>
						發燒影片
						<a href="{{ route('video.rank') }}?g=variety" style="text-decoration: none; color: #323232;" class="pull-right">
							<i style="color:#323232; vertical-align:middle; font-size: 1.4em; margin-top: -3px; margin-right: -3px;" class="material-icons">bar_chart</i>
							排行榜
							<i style="color:darkgray; vertical-align:middle; font-size: 1em; margin-top: -3px;" class="material-icons">arrow_forward_ios</i>
						</a>
					</h4>
				</div>
			</div>
			<div class="row home-video-wrapper">
				@foreach ($trending as $video)
					@include('video.singleHomeVideo')
				@endforeach
			</div>

			<div class="row" style="padding-top:4px; padding-bottom: 4px;">
				<div class="col-md-12">
					<h4>
						最新上傳
						<a href="{{ route('video.rank') }}?g=variety" style="text-decoration: none; color: #323232;" class="pull-right">
							<i style="color:#323232; vertical-align:middle; font-size: 1.4em; margin-top: -3px; margin-right: -3px;" class="material-icons">bar_chart</i>
							排行榜
							<i style="color:darkgray; vertical-align:middle; font-size: 1em; margin-top: -3px;" class="material-icons">arrow_forward_ios</i>
						</a>
					</h4>
				</div>
			</div>
			<div class="row home-video-wrapper">
				@foreach ($newest as $video)
					@include('video.singleHomeVideo')
				@endforeach
			</div>

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
		</div>
	</div>
</div>
@endsection