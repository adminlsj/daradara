@if (!Auth::check())
  <div data-toggle="modal" data-target="#signUpModal" style="text-decoration: none; color: inherit; text-align: center; cursor: pointer;" class="single-icon-wrapper">
  	<div class="single-icon no-select">
	    <i style="padding-top: 7px; font-size: 21px; color: white" class="material-icons">add_circle_outline</i>
	</div>
  </div>
@else
  @include('video.saveBtn', ['user_id' => Auth::user()->id, 'video_id' => $video->id])
@endif