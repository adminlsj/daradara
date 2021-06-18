<form id="video-save-form" action="{{ route('video.save') }}">
  {{ csrf_field() }}
  <input name="save-user-id" type="hidden" value="{{ $user_id }}">
  <input name="save-video-id" type="hidden" value="{{ $video_id }}">
  <input name="save-status" type="hidden" value="{{ $saved }}">
  <button class="single-icon-wrapper no-button-style" method="POST">
  	<div class="single-icon no-select">
	    <i style="padding-top: 7px; font-size: 21px; color: white" class="material-icons">{{ $saved ? 'add_circle' : 'add_circle_outline'}}</i>
  	</div>
  </button>
</form>