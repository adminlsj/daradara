<form id="comment-like-form" style="display: inline-block;" action="{{ route('comment.like') }}" method="POST">
	{{ csrf_field() }}
	<input type="hidden" id="foreign_type" name="foreign_type" value="{{ strtolower(explode('\\', get_class($comment))[1]) }}">
	<input type="hidden" id="foreign_id" name="foreign_id" value="{{ $comment->id }}">
	<input type="hidden" id="is_positive" name="is_positive" value="true">
	@include('video.comment-like-btn')
</form>