<form id="video-unsave-form" action="{{ route('video.unsave') }}">
  {{ csrf_field() }}
  <input name="save-user-id" type="hidden" value="{{ Auth::user()->id }}">
  <input name="save-foreign-id" type="hidden" value="{{ $video->id }}">
  <button class="single-icon no-button-style" method="POST">
    <i style="color: #3ea6ff" class="material-icons">library_add_check</i>
    <div>已儲存</div>
  </button>
</form>