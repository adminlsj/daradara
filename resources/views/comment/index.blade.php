<div id="comment-start">
	@foreach($comments as $comment)
		<div id="comment{{ $comment->id }}" class="row">
			<div class="col-md-1 col-xs-2">
				<a href="/orders/search?name="><img src="https://s3-us-west-2.amazonaws.com/freerider/avatars/thumbnails/{{ $comment->user->avatar->filename }}.jpg" class="img-responsive img-circle"></a>
			</div>
			<div class="col-md-9 col-xs-7">
				<div class="row">
					<a style="color: black; font-weight: 600" href="{{ route('user.show', ['user' => $comment->user->id]) }}">{{$comment->user->name}}</a>
				</div>
				<div class="row">
					<p>{{ $comment->text }}</p>
				</div>
			</div>
			<div class="col-md-2 text-right col-xs-3">
				<small>{{ $comment->created_at->diffForHumans() }}</small>
			</div>
		</div>
		<br>
	@endforeach
</div>