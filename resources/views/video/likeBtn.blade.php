<form id="video-like-form" action="{{ route('video.like') }}">
  {{ csrf_field() }}
  <input name="like-user-id" type="hidden" value="{{ Auth::user()->id }}">
  <input name="like-foreign-type" type="hidden" value="video">
  <input name="like-foreign-id" type="hidden" value="{{ $video->id }}">
  <input name="like-is-positive" type="hidden" value="{{ true }}">
  <button class="single-icon-wrapper no-button-style" method="POST">
  	<div class="single-icon no-select">
	    <i style="color: white; padding-top: 8px; font-size: 20px" class="material-icons">{{ App\Like::where('user_id', Auth::user()->id)->where('foreign_type', 'video')->where('foreign_id', $video->id)->first() ? 'favorite' : 'favorite_border'}}</i>
  	</div>
  </button>
</form>