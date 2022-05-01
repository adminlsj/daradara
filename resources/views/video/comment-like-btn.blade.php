<button class="no-button-style comment-like-btn">
	<input name="comment-like-user-id" type="hidden" value="{{ $commentLikeUserId }}">
	<input name="like-comment-status" type="hidden" value="{{ $likedComment }}">
	<input name="comment-likes-count" type="hidden" value="{{ $commentLikesCount }}">
	<input name="comment-likes-sum" type="hidden" value="{{ $commentLikesSum }}">
	<input name="unlike-comment-status" type="hidden" value="{{ $unlikedComment }}">
  	<span style="vertical-align: middle; font-size: 1.12em; color: #fff; margin-top: 0px; cursor: pointer;" class="material-icons-{{ $likedComment ? 'sharp' : 'outlined' }}">thumb_up</span>
  	<span style="font-size: 0.90em; color: darkgray; margin-left: 5px; font-weight: 400; {{ $commentLikesCount == 0 ? 'display:none' : '' }}">{{ $commentLikesSum }}</span>
</button>
<button class="no-button-style comment-unlike-btn">
  	<span style="vertical-align: middle; font-size: 1.12em; color: #fff; margin-top: 0px; margin-left: 15px; cursor: pointer;" class="material-icons-{{ $unlikedComment ? 'sharp' : 'outlined' }}">thumb_down</span>
</button>