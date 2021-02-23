<form id="video-unsave-form" action="{{ route('video.unsave') }}">
  {{ csrf_field() }}
  <input name="save-user-id" type="hidden" value="{{ Auth::user()->id }}">
  <input name="save-video-id" type="hidden" value="{{ $video->id }}">
  <button class="single-icon-wrapper no-button-style" method="POST">
  	<div class="single-icon no-select">
	    <i style="padding-top: 7px; font-size: 21px; color: white" class="material-icons">add_circle</i>
	</div>
  </button>
</form>