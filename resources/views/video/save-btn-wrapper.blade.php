@if (!Auth::check())
  <div data-toggle="modal" data-target="#signUpModal" style="text-decoration: none; color: inherit" class="single-icon">
    <i class="material-icons">library_add</i>
    <div>儲存</div>
  </div>
@elseif (App\Save::where('user_id', auth()->user()->id)->where('foreign_id', $video->id)->first() != null)
  @include('video.unsaveBtn')
@else
  @include('video.saveBtn')
@endif