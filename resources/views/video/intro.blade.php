@extends('layouts.app')

@section('content')
<div style="background-image: url({{ $watch->imgur}}); background-size: 100%; background-repeat: no-repeat; background-position: 50%; filter: blur(30px); z-index: 0; opacity: 0.5">
	<div class="padding-setup mobile-container">
		<div style="padding: 10px 0px;" class="row">
			<div class="col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-3 col-md-3 col-md-offset-0">
				<img src="{{ $watch->imgur }}" style="width: 100%; height: 100%; border-radius: 3px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.5);" alt="{{ $watch->title }}">
				<div style="margin-top: 10px" class="visible-xs visible-sm"></div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-9">
				<h4 class="hidden-xs hidden-sm" style="margin-top:5px; margin-bottom: 0px; line-height: 24px; font-size: 1.3em; font-weight: bold; color: white;">{{ $watch->title }}</h4>
				<h4 class="visible-xs visible-sm" style="margin-top:5px; margin-bottom: 0px; line-height: 24px; font-size: 1.3em; font-weight: bold; color: white; text-align: center">{{ $watch->title }}</h4>

				<h4 class="hidden-xs hidden-sm" style="margin-top:5px; white-space: pre-wrap;color:#d3d3d3; line-height: 15px; font-size: 0.95em; text-align: center; font-weight: 300;">{{ Carbon\Carbon::parse($watch->created_at )->format('Y年m月d日首播') }}  |  更新至第{{ $videos->count() }}集</h4>
				<h4 class="visible-xs visible-sm" style="margin-top:5px; white-space: pre-wrap;color:#d3d3d3; line-height: 15px; font-size: 0.95em; text-align: center; font-weight: 300;">{{ Carbon\Carbon::parse($watch->created_at )->format('Y年m月d日首播') }}  |  更新至第{{ $videos->count() }}集</h4>

				<a href="{{ route('video.watch') }}?v={{ $videos->first()->id }}" style="color:white;background-color: #d84b6b; font-weight: bold; margin:0px; padding: 8px" class="btn" target="_blank">
					<i style="vertical-align:middle; font-size: 1.4em; margin-top: -3px; margin-right: -3px;" class="material-icons">play_arrow</i>&nbsp;&nbsp;立即播放
				</a>

				<h4 style="white-space: pre-wrap;color:white; line-height: 19px; font-size: 0.95em;">{{ $watch->description }}</h4>
				<h4 style="white-space: pre-wrap;color:white; line-height: 19px; font-size: 1.2em; padding-top: 10px;">角色聲優</h4>
				<h4 style="white-space: pre-wrap;color:white; line-height: 19px; font-size: 0.95em;">{{ $watch->cast }}</h4>
			</div>
		</div>
	</div>
</div>
<div class="padding-setup mobile-container">
	<div class="row" style="padding: 10px 0px; position: absolute; top: 50px; width: inherit;">
		<div class="col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-3 col-md-3 col-md-offset-0">
			<img src="{{ $watch->imgur }}" style="width: 100%; height: 100%; border-radius: 3px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.5);" alt="{{ $watch->title }}">
			<div style="margin-top: 10px" class="visible-xs visible-sm"></div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-9">
			<h4 class="hidden-xs hidden-sm" style="margin-top:5px; margin-bottom: 0px; line-height: 24px; font-size: 1.3em; font-weight: bold; color: white;">{{ $watch->title }}</h4>
			<h4 class="visible-xs visible-sm" style="margin-top:5px; margin-bottom: 0px; line-height: 24px; font-size: 1.3em; font-weight: bold; color: white; text-align: center">{{ $watch->title }}</h4>

			<h4 class="hidden-xs hidden-sm" style="margin-top:5px; white-space: pre-wrap;color:#d3d3d3; line-height: 15px; font-size: 0.95em; text-align: center; font-weight: 300;">{{ Carbon\Carbon::parse($watch->created_at )->format('Y年m月d日首播') }}  |  更新至第{{ $videos->count() }}集</h4>
			<h4 class="visible-xs visible-sm" style="margin-top:5px; white-space: pre-wrap;color:#d3d3d3; line-height: 15px; font-size: 0.95em; text-align: center; font-weight: 300;">{{ Carbon\Carbon::parse($watch->created_at )->format('Y年m月d日首播') }}  |  更新至第{{ $videos->count() }}集</h4>

			<a style="color: white; margin: 3px 0px;" href="{{ route('video.watch') }}?v={{ $videos->first()->id }}" class="btn btn-info" target="_blank">
				<i style="vertical-align:middle; font-size: 1.4em; margin-top: -3px; margin-right: -3px;" class="material-icons">play_arrow</i>&nbsp;&nbsp;立即播放
			</a>

			<h4 style="white-space: pre-wrap;color:white; line-height: 19px; font-size: 0.95em;">{{ $watch->description }}</h4>
			<h4 style="white-space: pre-wrap;color:white; line-height: 19px; font-size: 1.2em; padding-top: 10px;">角色聲優</h4>
			<h4 style="white-space: pre-wrap;color:white; line-height: 19px; font-size: 0.95em;">{{ $watch->cast }}</h4>
		</div>
	</div>
</div>

<hr style="border:solid 1.5px #222222; margin-top: 0px">

<div class="padding-setup mobile-container">
	<div class="row">
		<div class="padding-setup" style="font-weight: 400; margin-bottom: 10px; font-size: 1.2em; color: white; font-weight: bold;">播放列表</div>
	    @foreach ($videos as $video)
	    	@include('video.singleRelatedPost')
	    @endforeach
	</div>
</div>
@endsection