<button id="comment-like-btn" class="no-button-style comment-like-btn">
	<input name="comment-like-user-id" type="hidden" value="{{ $commentLikeUserId }}">
	<input name="like-comment-status" type="hidden" value="{{ $likedComment }}">
	<input name="comment-likes-count" type="hidden" value="{{ $commentLikesCount }}">
	<input name="comment-likes-sum" type="hidden" value="{{ $commentLikesSum }}">
	<input name="unlike-comment-status" type="hidden" value="{{ $unlikedComment }}">
  	<span style="vertical-align: middle; font-size: 1.15em; color: darkgray; margin-top: -3px; cursor: pointer; {{ $likedComment ? 'color: #4377e8' : '' }}" class="material-icons">thumb_up</span>
  	<span style="font-size: 0.90em; color: gray; margin-left: 5px; letter-spacing: 3px; {{ $commentLikesCount == 0 ? 'display:none' : '' }}">{{ $commentLikesSum }}</span>
</button>
<button id="comment-unlike-btn" class="no-button-style comment-unlike-btn">
  	<span style="vertical-align: middle; font-size: 1.15em; color: darkgray; margin-top: -3px; margin-left: 15px; cursor: pointer; {{ $unlikedComment ? 'color: #4377e8' : '' }}" class="material-icons">thumb_down</span>
</button>