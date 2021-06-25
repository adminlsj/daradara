<div id="comment-reply-form-wrapper-{{ $comment->id }}" class="comment-reply-reply-form-wrapper" style="display: none">
	<form class="comment-reply-create-form" style="margin-top: 12px;" action="{{ route('video.replyComment') }}" method="POST">
		{{ csrf_field() }}
		<input name="reply-comment-id" type="hidden" value="{{ $comment->id }}">
		<a href="{{ route('user.show', Auth::user()) }}">
			<img class="img-circle" style="width: 30px; height: auto; float:left;" src="{{ Auth::user()->avatar_temp }}">
		</a>
		<input class="comment-text" style="width: calc(100% - 45px); line-height: 25px; background-color: inherit; border: none; outline: none; color: white;" type="text" id="reply-comment-text" name="reply-comment-text" placeholder="新增一則公開評論...">
	</form>
</div>