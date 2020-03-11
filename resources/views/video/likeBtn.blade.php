<form id="video-like-form" action="{{ route('video.like') }}">
  {{ csrf_field() }}
  <input name="like-user-id" type="hidden" value="{{ Auth::user()->id }}">
  <input name="like-type" type="hidden" value="video">
  <input name="like-foreign-id" type="hidden" value="{{ $video->id }}">
  <input name="like-is-positive" type="hidden" value="{{ true }}">
  <button style="" class="single-icon no-button-style" method="POST">
    <i class="material-icons">thumb_up</i>
    <div>{{ App\Like::count('video', $video->id, true) }}</div>
  </button>
</form>