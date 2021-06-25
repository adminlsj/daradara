<div style="padding-top: 20px">
	<a>
	  <img class="img-circle" style="width: 30px; height: auto; float:left;" src="{{ $reply->user->avatar_temp }}">
	</a>
	<div class="comment-index-text" style="font-size: 0.9em; padding-left: 45px"><a style="text-decoration: none; color: darkgray;">{{ $reply->user->name }} • <span style="color: darkgray;">{{ Carbon\Carbon::parse($reply->created_at)->diffForHumans() }}</span></a></div>
	<div class="comment-index-text" style="color: white; font-size: 1em; margin-top: 1px; padding-left: 45px">{{ $reply->text }}</div>
</div>
<div style="padding-left: 45px; padding-top: 10px">
	@include('video.comment-like-form', ['comment' => $reply])
	<span class="comment-reply-btn" style="color: darkgray; margin-left: 25px; font-size: 0.95em; cursor: pointer;" data-comment-id="{{ $comment->id }}" data-comment-user="{{ $reply->user->name }}">回覆</span>
</div>