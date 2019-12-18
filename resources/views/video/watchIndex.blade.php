@extends('layouts.app')

@section('content')
<div class="watch-index">
	<div style="margin: 0px 10px; padding-top: 10px;" class="row">
		@foreach ($videos as $watch => $video)
			<div class="{{ $genre == 'variety' ? 'watch-variety' : 'watch-single' }}">
			    <a style="text-decoration: none;" href="{{ route('video.watch') }}?v={{ $genre == 'variety' ? $video->last()->id : $video->first()->id }}">
				    <img src="{{ App\Watch::find($watch)->imgur }}" style="width: 100%; height: 100%;" alt="{{ App\Watch::find($watch)->title }}">
				    <div style="height: 50px">
					    <div style="margin-top: -27px;float: right; margin-right: 3px"><span style="background-color: rgba(0,0,0,0.8); color: white; padding: 1px 5px 1px 5px; opacity: 0.9; font-size: 0.85em; border-radius: 2px;">更新至第{{ $video->count() }}集</span></div>
						<h4 style="color:white; margin-top:5px; margin-bottom: 0px; line-height: 19px; font-size: 1.05em;overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ App\Watch::find($watch)->title }}</h4>
						<p style="color: #e5e5e5; margin-top:1px; margin-bottom: 0px; font-size: 0.85em;">更新 {{ Carbon\Carbon::parse($video->last()->created_at)->format('Y.m.d') }} </p>
					</div>
				</a>
			</div>
		@endforeach
	</div>
</div>
@endsection