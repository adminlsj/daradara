<button id="comment-like-btn-{{ $comment->id }}" class="no-button-style">
	@if ($comment_count = App\Like::where('type', 'comment')->where('foreign_id', $comment->id)->where('is_positive', true)->count())
	  	<span style="vertical-align: middle; font-size: 1.2em; color: darkgray; margin-top: -3px; cursor: pointer; {{ Auth::check() && App\Like::where('user_id', Auth::user()->id)->where('type', 'comment')->where('foreign_id', $comment->id)->where('is_positive', true)->first() ? 'color: #4377e8' : '' }}" class="material-icons">thumb_up</span>
	  	<span style="font-size: 0.95em; color: gray; margin-left: 5px; {{ $comment_count == 0 ? 'display:none' : '' }}">{{ $comment_count }}</span>

	@else
		<span style="vertical-align: middle; font-size: 1.2em; color: darkgray; margin-top: -3px; cursor: pointer;" class="material-icons">thumb_up</span>
	@endif
</button>