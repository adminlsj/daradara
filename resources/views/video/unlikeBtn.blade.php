<form id="video-unlike-form" action="{{ route('video.unlike') }}">
  {{ csrf_field() }}
  <input name="like-user-id" type="hidden" value="{{ Auth::user()->id }}">
  <input name="like-type" type="hidden" value="video">
  <input name="like-foreign-id" type="hidden" value="{{ $video->id }}">
  <input name="like-is-positive" type="hidden" value="{{ true }}">
  <button class="single-icon-wrapper no-button-style" method="POST">
  	<div class="single-icon no-select">
	    <i class="{{ Auth::check() && App\Like::where('type', 'video')->where('user_id', Auth::user()->id)->where('foreign_id', $video->id)->first() ? 'material-icons' : 'material-icons-outlined' }}">thumb_up</i>
	    <div>{{ App\Like::count('video', $video->id, true) }}</div>
	</div>
  </button>
</form>