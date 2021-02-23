<div id="comment-reply-form-wrapper-{{ $comment->id }}" class="comment-reply-reply-form-wrapper" style="display: none">
	<form class="comment-reply-create-form" style="margin-top: 12px;" action="{{ route('video.replyComment') }}" method="POST">
		{{ csrf_field() }}
		<input name="reply-comment-id" type="hidden" value="{{ $comment->id }}">
		<a href="{{ route('user.show', Auth::user()) }}">
			<img class="lazy img-circle" style="width: 25px; height: auto; float:left;" src="https://i.imgur.com/JMcgEkPs.jpg" data-src="{{ Auth::user()->avatar == null ? Auth::user()->avatarDefault() : Auth::user()->avatar->filename }}" data-srcset="{{ Auth::user()->avatar == null ? Auth::user()->avatarDefault() : Auth::user()->avatar->filename }}">
		</a>
		<input class="comment-text" style="width: calc(100% - 45px); line-height: 25px; background-color: inherit; border: none; outline: none; color: white;" type="text" id="reply-comment-text" name="reply-comment-text" placeholder="新增一則公開評論...">
	</form>
</div>