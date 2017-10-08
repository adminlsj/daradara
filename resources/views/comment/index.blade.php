<div id="comment-start">
	@foreach($comments as $comment)
		<div id="comment{{ $comment->id }}" class="row">
			<div class="col-md-1">
				<a href="{{ route('user.show', ['user' => $comment->user->id]) }}"><img src="https://s3-us-west-2.amazonaws.com/freerider/avatars/thumbnails/{{ $comment->user->avatar->filename }}.jpg" class="img-responsive img-circle"></a>
			</div>
			<div class="col-md-9">
				<div class="row">
					<a style="color: black; font-weight: 600" href="{{ route('user.show', ['user' => $comment->user->id]) }}">{{$comment->user->name}}</a>
				</div>
				<div class="row">
					<p>{{ $comment->text }}</p>
				</div>
			</div>
			<div class="col-md-2 text-right">
				<small>{{ $comment->created_at->diffForHumans() }}</small>
				@if(Auth::check() && auth()->user()->id == $comment->user->id)
					<form id="deleteComment{{ $comment->id }}" action="{{ route('order.comment.destroy', ['order'=>$order->id, 'comment'=>$comment->id]) }}" method="POST" name="delete_item">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}
						<button type="submit" class="btn btn-danger" style="margin-top: 5px; line-height: 15px"><small>Delete</small></button>
					</form>
				@endif
			</div>
		</div>
		<br>
	@endforeach
</div>