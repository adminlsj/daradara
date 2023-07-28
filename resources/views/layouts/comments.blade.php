@extends('layouts.app')

@section('nav')
  @include('nav.main')
@endsection

@section('content')

<div style="margin-top: 80px; margin-left: 4%; margin-right: 4%;">
	<div class="row analytics-row" style="text-align: center; border-top: 1px solid black; background-color: #f5f5f5; font-weight: bold; border-right: 1px solid black; border-left: 1px solid black">
		<div class="col-md-1">id</div>
		<div class="col-md-1">created_at</div>
		<div class="col-md-1">user_id</div>
		<div class="col-md-1">user_avatar</div>
		<div class="col-md-1">user_name</div>
		<div class="col-md-4">text</div>
		<div class="col-md-3">video</div>
	</div>

	@foreach ($comments as $comment)
		<div class="row analytics-row" style="text-align: center; border-right: 1px solid black; border-left: 1px solid black; color: white;">
			<div class="col-md-1">{{ $comment->id }}</div>
			<div class="col-md-1">{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</div>
			<div class="col-md-1">{{ $comment->user_id }}</div>
			<div class="col-md-1"><img src="{{ $comment->user->avatar_temp }}" width="30"></div>
			<div class="col-md-1">{{ $comment->user->name }}</div>
			<div class="col-md-4">{{ $comment->text }}</div>
			@if ($comment->video)
				<div class="col-md-3">
					<a href="{{ route('video.watch').'?v='.$comment->video->id }}" target="_blank">
						{{ $comment->video->title }}
					</a>
				</div>
			@elseif ($comment->preview)
				<div class="col-md-3">
					<a href="/previews/{{ $comment->preview->uuid }}" target="_blank">
						{{ substr($comment->preview->uuid, 0, 4) }}年{{ ltrim(substr($comment->preview->uuid, 4, 6), '0') }}月新番表
					</a>
				</div>
			@endif
		</div>
	@endforeach
</div>

<div style="text-align: center">
	{{ $comments->links() }}
</div>

@endsection