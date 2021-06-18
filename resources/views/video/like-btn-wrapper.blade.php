@if (!Auth::check())
  <div data-toggle="modal" data-target="#signUpModal" style="text-decoration: none; color: inherit; text-align: center; cursor: pointer;" class="single-icon-wrapper">
  	<div class="single-icon no-select">
	    <i style="color: white; padding-top: 8px; font-size: 20px" class="material-icons">favorite_border</i>
	</div>
  </div>
@else
  @include('video.likeBtn', ['user_id' => Auth::user()->id, 'video_id' => $video->id])
@endif