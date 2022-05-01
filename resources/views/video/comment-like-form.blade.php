<form class="comment-like-form" style="display: inline-block;" action="{{ route('comment.like') }}" method="POST">
	{{ csrf_field() }}
	<input type="hidden" id="foreign_type" name="foreign_type" value="{{ strtolower(explode('\\', get_class($comment))[1]) }}">
	<input type="hidden" id="foreign_id" name="foreign_id" value="{{ $comment->id }}">
	<input type="hidden" id="is_positive" name="is_positive" value="">
	<span class="comment-like-btn-wrapper">
		@include('video.comment-like-btn', 
				[
					'commentLikeUserId' => Auth::user()->id, 
					'likedComment' => $comment->likes->where('user_id', Auth::user()->id)->where('is_positive', true)->count(), 
					'commentLikesCount' => $comment->likes->count(), 
					'commentLikesSum' => $comment->likes->where('is_positive', true)->count() - $comment->likes->where('is_positive', false)->count(), 
					'unlikedComment' => $comment->likes->where('user_id', Auth::user()->id)->where('is_positive', false)->count()
				])
	</span>
</form>