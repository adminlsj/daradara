<form id="video-unlike-form" action="{{ route('video.unlike') }}">
  {{ csrf_field() }}
  <input name="like-user-id" type="hidden" value="{{ Auth::user()->id }}">
  <input name="like-type" type="hidden" value="video">
  <input name="like-foreign-id" type="hidden" value="{{ $video->id }}">
  <input name="like-is-positive" type="hidden" value="{{ true }}">
  <button class="single-icon no-button-style" method="POST">
    <i style="color: #3ea6ff" class="material-icons">thumb_up</i>
    <div>{{ App\Like::count('video', $video->id, true) }}</div>
  </button>
</form>