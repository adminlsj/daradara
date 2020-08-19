<form id="comment-unlike-form" style="display: inline-block;" action="{{ route('comment.unlike') }}" method="POST">
	{{ csrf_field() }}
	<input type="hidden" id="type" name="type" value="comment">
	<input type="hidden" id="foreign_id" name="foreign_id" value="{{ $comment->id }}">
	<input type="hidden" id="is_positive" name="is_positive" value="false">
	@include('video.comment-unlike-btn')
</form>