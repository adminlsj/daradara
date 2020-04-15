<form id="video-save-form" action="{{ route('video.save') }}">
  {{ csrf_field() }}
  <input name="save-user-id" type="hidden" value="{{ Auth::user()->id }}">
  <input name="save-foreign-id" type="hidden" value="{{ $video->id }}">
  <button class="single-icon-wrapper no-button-style" method="POST">
  	<div class="single-icon no-select">
	    <i class="material-icons">library_add</i>
	    <div>儲存</div>
	</div>
  </button>
</form>