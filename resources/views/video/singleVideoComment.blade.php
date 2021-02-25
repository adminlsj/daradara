<a>
  <img class="img-circle" style="width: 35px; height: auto; float:left;" src="{{ $comment->user->avatar == null ? $comment->user->avatarDefault() : $comment->user->avatar->filename }}">
</a>
<div class="comment-index-text" style="font-size: 0.9em;"><a style="text-decoration: none; color: darkgray;">{{ $comment->user->name }} • <span style="color: darkgray;">{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span></a></div>
<div class="comment-index-text" style="color: white; font-size: 1em; margin-top: 1px;">{{ $comment->text }}</div>

<div id="comment-like-form-wrapper" style="margin-top: 10px">

	@if (Auth::check())
		@include('video.comment-like-form')
		@include('video.comment-unlike-form')
		<span class="comment-reply-btn" style="color: darkgray; margin-left: 25px; font-size: 0.95em; cursor: pointer;" data-comment-id="{{ $comment->id }}">回覆</span>
		@include('video.comment-reply-form')
		<div id="reply-start-{{ $comment->id }}">
			@foreach ($comment->replies as $reply)
				@include('video.single-comment-reply')
			@endforeach
		</div>
	@else
		<div style="display: inline-block;" data-toggle="modal" data-target="#signUpModal">
		  	<span style="vertical-align: middle; font-size: 1.2em; color: darkgray; margin-top: -3px; cursor: pointer;" class="material-icons">thumb_up</span>
		  	<span style="font-size: 0.95em; color: darkgray; padding-left: 5px; {{ $comment->likes->count() == 0 ? 'display:none' : '' }}">{{ $comment->likes->count() }}</span>
		</div>
		<div style="display: inline-block;" data-toggle="modal" data-target="#signUpModal">
		  	<span style="vertical-align: middle; font-size: 1.2em; color: darkgray; margin-top: -3px; margin-left: 15px; cursor: pointer;" class="material-icons">thumb_down</span>
		</div>
		<span style="color: darkgray; margin-left: 25px; font-size: 0.95em; cursor: pointer;" data-toggle="modal" data-target="#signUpModal">回覆</span>
		@foreach ($comment->replies as $reply)
			<div style="padding-top: 15px">
				<a>
				  <img class="img-circle" style="width: 25px; height: auto; float:left;" src="{{ $reply->user->avatar == null ? $reply->user->avatarDefault() : $reply->user->avatar->filename }}">
				</a>
				<div class="comment-index-text" style="font-size: 0.9em; padding-left: 35px"><a style="text-decoration: none; color: darkgray;">{{ $reply->user->name }} • <span style="color: darkgray;">{{ Carbon\Carbon::parse($reply->created_at)->diffForHumans() }}</span></a></div>
				<div class="comment-index-text" style="color: white; font-size: 1em; margin-top: 1px; padding-left: 35px">{{ $reply->text }}</div>
			</div>
			<div style="padding-left: 35px; padding-top: 9px">
				<div style="display: inline-block;" data-toggle="modal" data-target="#signUpModal">
				  	<span style="vertical-align: middle; font-size: 1.2em; color: darkgray; margin-top: -3px; cursor: pointer;" class="material-icons">thumb_up</span>
				  	<span style="font-size: 0.95em; color: darkgray; padding-left: 5px; {{ $comment->likes->count() == 0 ? 'display:none' : '' }}">{{ $comment->likes->count() }}</span>
				</div>
				<div style="display: inline-block;" data-toggle="modal" data-target="#signUpModal">
				  	<span style="vertical-align: middle; font-size: 1.2em; color: darkgray; margin-top: -3px; margin-left: 15px; cursor: pointer;" class="material-icons">thumb_down</span>
				</div>
				<span style="color: darkgray; margin-left: 25px; font-size: 0.95em; cursor: pointer;" data-toggle="modal" data-target="#signUpModal">回覆</span>
			</div>
		@endforeach
	@endif

</div>

<br>