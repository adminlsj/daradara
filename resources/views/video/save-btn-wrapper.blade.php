@if (!Auth::check())
  <div data-toggle="modal" data-target="#signUpModal" style="text-decoration: none; color: inherit; text-align: center; cursor: pointer;" class="single-icon-wrapper">
  	<div class="single-icon no-select">
	    <i style="padding-top: 7px; font-size: 21px; color: white" class="material-icons">add_circle_outline</i>
	</div>
  </div>
@elseif (App\Save::where('user_id', auth()->user()->id)->where('video_id', $video->id)->first() != null)
  @include('video.unsaveBtn')
@else
  @include('video.saveBtn')
@endif