@extends('layouts.app')

@section('content')
<div class="watch-index">
	<div style="margin: 0px 10px; padding-top: 10px;" class="row">
		@foreach ($videos as $watch => $video)
			<div class="watch-single">
			    <a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video->first()->id }}">
				    <img src="{{ App\Watch::find($watch)->imgur }}" width="100%" height="100%">
				    <div style="margin-top: -23px;float: right; margin-right: 4px"><span style="background-color: rgba(0,0,0,0.8); color: white; padding: 1px 5px 1px 5px; opacity: 0.9; font-size: 0.85em; border-radius: 2px;">更新至第{{ $video->count() }}集</span></div>
					<h4 style="color:white; margin-top:5px; margin-bottom: 0px; line-height: 19px; font-size: 1.05em;">{{ App\Watch::find($watch)->title }}</h4>
					<p style="color: #e5e5e5; margin-top:1px; margin-bottom: 0px; font-size: 0.85em;">最後更新 {{ Carbon\Carbon::parse($video->first()->created_at)->format('Y.m.d') }} </p>
				</a>
			</div>
		@endforeach
	</div>
</div>
@endsection