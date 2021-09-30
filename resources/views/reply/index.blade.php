<div id="reply-start-{{ $comment_id }}" style="margin-top: -8px;">
	@foreach ($replies as $reply)
		<div style="padding-top: 20px">
			<a>
			  <img class="img-circle" style="width: 30px; height: auto; float:left;" src="{{ $reply->user->avatar_temp }}">
			</a>
			<div class="comment-index-text" style="font-size: 0.9em; padding-left: 45px"><a style="text-decoration: none; color: #fff;">{{ $reply->user->name }}&nbsp;&nbsp;<span style="color: darkgray; font-weight: 400; font-size: 0.85em;">{{ Carbon\Carbon::parse($reply->created_at)->diffForHumans() }}</span></a></div>
			<div class="comment-index-text" style="color: white; font-size: 1em; margin-top: 3px; padding-left: 45px; font-weight: 400">{{ $reply->text }}</div>
		</div>
		<div style="padding-left: 45px; padding-top: 10px">
			@include('video.comment-like-form', ['comment' => $reply])
			<span class="comment-reply-btn" style="color: darkgray; margin-left: 25px; font-size: 0.95em; cursor: pointer; font-weight: 400" data-comment-id="{{ $comment_id }}" data-comment-user="{{ $reply->user->name }}">回覆</span>
		</div>
	@endforeach
</div>