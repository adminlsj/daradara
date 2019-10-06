@extends('layouts.app')

@section('content')
<div style="width:78%; margin: 0 auto; background-color: #414141" class="mobile-container">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 15px;">
			<div>
		        <h3 class="mobile-margin-top" style="color: white; font-weight: 500; margin-top:5px; margin-bottom: 15px;">節目列表</h3>
		    </div>
			<div class="video-sidebar-wrapper">
				@foreach ($videos as $video)
					<div style="margin-bottom: 15px;">
					  <a href="{{ route('video.watch') }}?v={{ $video->id }}" class="row no-gutter">
					    <div style="padding-left: 15px; padding-right: 3px; position: relative;" class="col-xs-6 col-sm-6 col-md-6">
					      <img src="{{ $banners[$video->category] }}" width="100%" height="100%">
					      <div style="position: absolute; right:3px; bottom: 0; height: 100%; width: 25%; background-color: rgba(0,0,0,.7); text-align: center; color: white;">
					      	<div style="margin: 0;position: absolute;top: 50%; left: 50%; transform: translate(-50%, -50%);">
						      	<div style="font-size: 1em;">{{ $counts[$video->category] }}</div>
						      	<div><i style="font-size: 2em;" class="material-icons">playlist_play</i></div>
					      	</div>
					      </div>
					    </div>
					    <div style="padding-top: 2px; padding-right: 15px; padding-left: 3px;" class="col-xs-6 col-sm-6 col-md-6">
					      <h4 style="color:white; margin-top:0px; margin-bottom: 0px; line-height: 19px; font-size: 1.05em;">{{ $titles[$video->category] }}</h4>
					      <p style="color: #e5e5e5; margin-top:1px; margin-bottom: 0px; font-size: 0.85em;">{{ $counts[$video->category] }}部影片</p>
					    </div>
					  </a>
					</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection