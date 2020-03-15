<form id="subscribe-form" action="{{ route('video.subscribe') }}" method="POST">
  {{ csrf_field() }}
  <input name="subscribe-source" type="hidden" value="intro">
  <input name="subscribe-user-id" type="hidden" value="{{ Auth::user()->id }}">
  <input name="subscribe-watch-id" type="hidden" value="{{ $watch->id }}">
  <button id="subscribe-btn" type="submit" style="background-color: red !important; border-color: red !important" class="btn btn-info">訂閱</button>
</form>