<form id="video-like-form" action="{{ route('video.like') }}">
  {{ csrf_field() }}
  <input name="like-user-id" type="hidden" value="{{ $user_id }}">
  <input name="like-foreign-id" type="hidden" value="{{ $video_id }}">
  <input name="like-is-positive" type="hidden" value="{{ true }}">
  <input name="like-status" type="hidden" value="{{ $liked }}">
  <input name="likes-count" type="hidden" value="{{ $likes_count }}">
  <button id="video-like-btn" class="single-icon-wrapper no-button-style" method="POST">
  	<div class="single-icon no-select">
	    <i class="material-icons{{ $liked ? '' : '-outlined'}}">thumb_up</i>{{ $likes_count }}
  	</div>
  </button>
</form>