@if (!Auth::check())
  <div data-toggle="modal" data-target="#signUpModal" style="text-decoration: none; color: inherit; text-align: center; cursor: pointer;" class="single-icon-wrapper">
  	<div class="single-icon no-select">
	    <i style="padding-top: 7px; font-size: 21px; color: white" class="material-icons">add_circle_outline</i>
  	</div>
  </div>
@else
  @include('video.saveBtn-new', ['save_icon' => $saved || $listed != '[]' ? 'add_circle' : 'add_circle_outline'])
@endif