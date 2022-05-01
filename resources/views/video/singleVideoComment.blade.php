<a>
  <img class="img-circle" style="width: 40px; height: auto; float:left;" src="{{ $comment->user->avatar_temp }}">
</a>
<div class="comment-index-text" style="font-size: 0.9em;"><a style="text-decoration: none; color: #fff;">{{ $comment->user->name }}&nbsp;&nbsp;<span style="color: darkgray; font-weight: 400; font-size: 0.85em;">{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span></a></div>
<div class="comment-index-text" style="color: white; font-size: 1em; margin-top: 3px; font-weight: 400; word-wrap: break-word;">{{ $comment->text }}</div>

<div id="comment-like-form-wrapper" style="margin-top: 11px; margin-left: 56px; margin-bottom: 5px;">

	@if (Auth::check())
		@include('video.comment-like-form')
		<span class="comment-reply-btn" style="color: darkgray; margin-left: 25px; font-size: 0.95em; cursor: pointer; font-weight: 400" data-comment-id="{{ $comment->id }}">回覆</span>
		@if ($comment->replies_count)
			<div style="color: red; cursor: pointer; margin-top: 13px; margin-left: -5px; font-weight: 400;" class="load-replies-btn no-select" data-commentid="{{ $comment->id }}"><span style="vertical-align: middle; margin-top: -3px; margin-right: 7px;" class="material-icons">arrow_drop_down</span><span class="reply-btn-text">查看</span> {{ $comment->replies_count }} 則回覆</div>
			<div class="comment-reply-ajax-loading" style="text-align: center; display: none;">
        <img style="width: 40px;" src="https://i.imgur.com/wgOXAy6.gif"/>
      </div>
		@endif
		<div id="comment-reply-wrapper-{{ $comment->id }}">
			@include('video.comment-reply-form')
		</div>
		<div id="reply-section-wrapper-{{ $comment->id }}" class="reply-section-wrapper">
		</div>

	@else
		<div style="display: inline-block;" data-toggle="modal" data-target="#signUpModal">
		  	<span style="vertical-align: middle; font-size: 1.12em; color: #fff; margin-top: 0px; cursor: pointer;" class="material-icons-outlined">thumb_up</span>
		  	<span style="font-size: 0.90em; color: darkgray; margin-left: 5px; font-weight: 400; {{ $comment->likes->count() == 0 ? 'display:none' : '' }}">{{ $comment->likes->where('is_positive', true)->count() - $comment->likes->where('is_positive', false)->count() }}</span>
		</div>
		<div style="display: inline-block;" data-toggle="modal" data-target="#signUpModal">
		  	<span style="vertical-align: middle; font-size: 1.12em; color: #fff; margin-top: 0px; margin-left: 15px; cursor: pointer;" class="material-icons-outlined">thumb_down</span>
		</div>
		<span style="color: darkgray; margin-left: 25px; font-size: 0.95em; cursor: pointer; font-weight: 400" data-toggle="modal" data-target="#signUpModal">回覆</span>

		@if ($comment->replies_count)
			<div style="color: red; cursor: pointer; margin-top: 13px; margin-left: -5px; font-weight: 400;" class="load-replies-btn no-select" data-commentid="{{ $comment->id }}"><span style="vertical-align: middle; margin-top: -3px; margin-right: 7px;" class="material-icons">arrow_drop_down</span><span class="reply-btn-text">查看</span> {{ $comment->replies_count }} 則回覆</div>
		@endif

		<div id="reply-section-wrapper-{{ $comment->id }}" class="reply-section-wrapper">
		</div>
	@endif

</div>

<br>