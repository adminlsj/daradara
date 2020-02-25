@extends('layouts.app')

@section('nav')
	@include('layouts.nav-main', ['theme' => 'white', 'logoImage' => 'https://i.imgur.com/M8tqx5K.png'])
@endsection

@section('content')
<div class="hidden-sm hidden-xs sidebar-menu">
	@include('video.sidebarMenu', ['theme' => 'white'])
</div>
<div class="main-content" style="background-color: #F5F5F5;">
	<div>
		<div class="padding-setup" style="padding-top: 20px">
			<i style="font-size: 80px; color: gray; float: left; margin-left: -5px;" class="material-icons">subscriptions</i>
			<div style="margin-left: 85px; margin-top: 3px; height: 76px">
				<div style="font-size: 1.2em">讓頻道訂閱信息更充實</div>
				<div style="color: gray; margin-top: 3px;">訂閱您喜愛的頻道，保證不會錯過最新內容。</div>
			</div>
		</div>
		<hr style="border-color: #e9e9e9; margin-bottom: 0px">
		<div class="row padding-setup" style="padding-top:12px; padding-bottom: 5px;">
			<div class="col-md-12">
				<h4>
					綜藝推薦
					<a href="{{ route('video.rank') }}?g=drama" style="text-decoration: none; color: #323232;" class="pull-right">
						<i style="color:#323232; vertical-align:middle; font-size: 1.4em; margin-top: -3px; margin-right: -3px;" class="material-icons">bar_chart</i>
						排行榜
						<i style="color:darkgray; vertical-align:middle; font-size: 1em; margin-top: -3px;" class="material-icons">arrow_forward_ios</i>
					</a>
				</h4>
			</div>
		</div>
		<div class="padding-setup">
			<div class="row home-video-wrapper">
				@foreach ($variety as $watch)
					@include('video.singleWatchIndex', ['watch' => $watch])
				@endforeach
			</div>
		</div>

		<div class="row padding-setup" style="padding-top:12px; padding-bottom: 4px;">
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
		<div class="padding-setup">
			<div class="row home-video-wrapper">
				@foreach ($drama as $watch)
					@include('video.singleWatchIndex', ['watch' => $watch])
				@endforeach
			</div>
		</div>

		<div class="row padding-setup" style="padding-top:12px; padding-bottom: 4px;">
			<div class="col-md-12">
				<h4>
					動漫推薦
					<a href="{{ route('video.rank') }}?g=drama" style="text-decoration: none; color: #323232;" class="pull-right">
						<i style="color:#323232; vertical-align:middle; font-size: 1.4em; margin-top: -3px; margin-right: -3px;" class="material-icons">bar_chart</i>
						排行榜
						<i style="color:darkgray; vertical-align:middle; font-size: 1em; margin-top: -3px;" class="material-icons">arrow_forward_ios</i>
					</a>
				</h4>
			</div>
		</div>
		<div class="padding-setup">
			<div class="row home-video-wrapper">
				@foreach ($anime as $watch)
					@include('video.singleWatchIndex', ['watch' => $watch])
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
	@parent
	<script src="{{ mix('js/loadMore.js') }}"></script>
@endsection