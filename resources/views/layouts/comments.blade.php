@extends('layouts.app')

@section('nav')
  @include('nav.main')
@endsection

@section('content')

<div style="margin-top: 80px; margin-left: 4%; margin-right: 4%;">
	<div class="row analytics-row" style="text-align: center; border-top: 1px solid black; background-color: #f5f5f5; font-weight: bold; border-right: 1px solid black; border-left: 1px solid black">
		<div class="col-md-1">id</div>
		<div class="col-md-1">user_id</div>
		<div class="col-md-1">created_at</div>
		<div class="col-md-5">text</div>
		<div class="col-md-4">video</div>
	</div>

	@foreach ($comments as $comment)
		<div class="row analytics-row" style="text-align: center; border-right: 1px solid black; border-left: 1px solid black">
			<div class="col-md-1">{{ $comment->id }}</div>
			<div class="col-md-1">{{ $comment->user_id }}</div>
			<div class="col-md-1">{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</div>
			<div class="col-md-5">{{ $comment->text }}</div>
			<div class="col-md-4"><a href="{{ route('video.watch').'?v='.$comment->video->id }}" target="_blank">{{ $comment->video->title }}</a></div>
		</div>
	@endforeach
</div>

<div style="text-align: center">
	{{ $comments->links() }}
</div>

@endsection