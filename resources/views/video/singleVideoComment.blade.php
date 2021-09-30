<a>
  <img class="img-circle" style="width: 40px; height: auto; float:left;" src="{{ $comment->user->avatar_temp }}">
</a>
<div class="comment-index-text" style="font-size: 0.9em;"><a style="text-decoration: none; color: #fff;">{{ $comment->user->name }}&nbsp;&nbsp;<span style="color: darkgray; font-weight: 400; font-size: 0.85em;">{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span></a></div>
<div class="comment-index-text" style="color: white; font-size: 1em; margin-top: 3px; font-weight: 400">{{ $comment->text }}</div>

<div id="comment-like-form-wrapper" style="margin-top: 11px; margin-left: 56px; margin-bottom: 5px;">

	@if (Auth::check())
		@include('video.comment-like-form')
		<span class="comment-reply-btn" style="color: darkgray; margin-left: 25px; font-size: 0.95em; cursor: pointer; font-weight: 400" data-comment-id="{{ $comment->id }}">回覆</span>
		@if ($comment->replies_count)
			<div style="color: red; cursor: pointer; margin-top: 13px; margin-left: -5px; font-weight: 400;" class="load-replies-btn no-select" data-commentid="{{ $comment->id }}"><span style="vertical-align: middle; margin-top: -3px; margin-right: 7px;" class="material-icons">arrow_drop_down</span><span class="reply-btn-text">查看</span> {{ $comment->replies_count }} 則回覆</div>
		@endif
		<div id="comment-reply-wrapper-{{ $comment->id }}">
			@include('video.comment-reply-form')
		</div>
		<div id="reply-section-wrapper-{{ $comment->id }}" class="reply-section-wrapper">
		</div>

	@else
		<div style="display: inline-block;" data-toggle="modal" data-target="#signUpModal">
		  	<span style="vertical-align: middle; font-size: 1.15em; color: darkgray; margin-top: -3px; cursor: pointer;" class="material-icons">thumb_up</span>
		  	<span style="font-size: 0.90em; color: gray; padding-left: 5px; {{ $comment->likes->count() == 0 ? 'display:none' : '' }}">{{ $comment->likes->where('is_positive', true)->count() - $comment->likes->where('is_positive', false)->count() }}</span>
		</div>
		<div style="display: inline-block;" data-toggle="modal" data-target="#signUpModal">
		  	<span style="vertical-align: middle; font-size: 1.15em; color: darkgray; margin-top: -3px; margin-left: 15px; cursor: pointer;" class="material-icons">thumb_down</span>
		</div>
		<span style="color: darkgray; margin-left: 25px; font-size: 0.95em; cursor: pointer;" data-toggle="modal" data-target="#signUpModal">回覆</span>
		@foreach ($comment->replies as $reply)
			<div style="padding-top: 20px">
				<a>
				  <img class="img-circle" style="width: 30px; height: auto; float:left;" src="{{ $reply->user->avatar_temp }}">
				</a>
				<div class="comment-index-text" style="font-size: 0.9em; padding-left: 45px"><a style="text-decoration: none; color: darkgray;">{{ $reply->user->name }} • <span style="color: darkgray;">{{ Carbon\Carbon::parse($reply->created_at)->diffForHumans() }}</span></a></div>
				<div class="comment-index-text" style="color: white; font-size: 1em; margin-top: 1px; padding-left: 45px">{{ $reply->text }}</div>
			</div>
			<div style="padding-left: 45px; padding-top: 10px">
				<div style="display: inline-block;" data-toggle="modal" data-target="#signUpModal">
				  	<span style="vertical-align: middle; font-size: 1.15em; color: darkgray; margin-top: -3px; cursor: pointer;" class="material-icons">thumb_up</span>
				  	<span style="font-size: 0.95em; color: darkgray; padding-left: 5px; {{ $reply->likes->count() == 0 ? 'display:none' : '' }}">{{ $reply->likes->where('is_positive', true)->count() }}</span>
				</div>
				<div style="display: inline-block;" data-toggle="modal" data-target="#signUpModal">
				  	<span style="vertical-align: middle; font-size: 1.15em; color: darkgray; margin-top: -3px; margin-left: 15px; cursor: pointer;" class="material-icons">thumb_down</span>
				</div>
				<span style="color: darkgray; margin-left: 25px; font-size: 0.95em; cursor: pointer;" data-toggle="modal" data-target="#signUpModal">回覆</span>
			</div>
		@endforeach
	@endif

</div>

<br>