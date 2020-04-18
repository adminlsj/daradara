@if (!Auth::check())
  <div data-toggle="modal" data-target="#signUpModal" style="text-decoration: none; color: inherit" class="single-icon-wrapper">
  	<div class="single-icon no-select">
	    <i class="material-icons">thumb_up</i>
	    <div>{{ App\Like::count('video', $video->id, true) }}</div>
	</div>
  </div>
@elseif (App\Like::where('user_id', auth()->user()->id)->where('type', 'video')->where('foreign_id', $video->id)->first() != null)
  @include('video.unlike-btn')
@else
  @include('video.like-btn')
@endif