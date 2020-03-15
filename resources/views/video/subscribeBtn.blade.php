<form id="subscribe-form" action="{{ route('video.subscribe') }}" method="POST">
  {{ csrf_field() }}
  <input name="subscribe-user-id" type="hidden" value="{{ Auth::user()->id }}">
  <input name="subscribe-watch-id" type="hidden" value="{{ $watch->id }}">
  <button id="subscribe-btn" type="submit" style="font-weight: 500; cursor: pointer; border: none; background-color: inherit; font-size: 1.3em; padding-bottom: 0px; padding-right: 0px; color: crimson">訂閱</button>
</form>