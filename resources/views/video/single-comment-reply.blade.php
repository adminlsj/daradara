<div style="padding-top: 15px">
	<a href="{{ route('user.show', $comment_reply->user) }}">
	  <img class="img-circle" style="width: 25px; height: auto; float:left;" src="{{ $comment_reply->user->avatar == null ? $comment_reply->user->avatarDefault() : $comment_reply->user->avatar->filename }}">
	</a>
	<div class="comment-index-text" style="font-size: 0.9em; padding-left: 35px"><a style="text-decoration: none; color: gray;" href="{{ route('user.show', $comment_reply->user) }}">{{ $comment_reply->user->name }} • <span style="color: gray;">{{ Carbon\Carbon::parse($comment_reply->created_at)->diffForHumans() }}</span></a></div>
	<div class="comment-index-text" style="color: #222222; font-size: 1em; margin-top: 1px; padding-left: 35px">{{ $comment_reply->text }}</div>
</div>
<div style="padding-left: 35px; padding-top: 9px">
	@include('video.comment-like-form', ['comment' => $comment_reply])
	@include('video.comment-unlike-form', ['comment' => $comment_reply])
	<span class="comment-reply-btn" style="color: dimgray; margin-left: 25px; font-size: 0.95em; cursor: pointer;" data-comment-id="{{ $comment->id }}" data-comment-user="{{ $comment_reply->user->name }}">回覆</span>
</div>