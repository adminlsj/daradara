<form id="video-like-form" action="{{ route('video.like') }}">
  {{ csrf_field() }}
  <input name="like-user-id" type="hidden" value="{{ $user_id }}">
  <input name="like-foreign-id" type="hidden" value="{{ $video_id }}">
  <input name="like-is-positive" type="hidden" value="{{ true }}">
  <input name="like-status" type="hidden" value="{{ $liked }}">
  <button class="single-icon-wrapper no-button-style" method="POST">
  	<div class="single-icon no-select">
	    <i style="color: white; padding-top: 8px; font-size: 20px" class="material-icons">{{ $liked ? 'favorite' : 'favorite_border'}}</i>
  	</div>
  </button>
</form>