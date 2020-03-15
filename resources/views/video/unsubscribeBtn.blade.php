<form id="unsubscribe-form" action="{{ route('video.unsubscribe') }}" method="POST">
  {{ csrf_field() }}
  <input name="subscribe-user-id" type="hidden" value="{{ Auth::user()->id }}">
  <input name="subscribe-watch-id" type="hidden" value="{{ $watch->id }}">
  <button id="unsubscribe-btn" type="submit" style="color: darkgray; font-weight: 500; cursor: pointer; border: none; background-color: inherit; font-size: 1.3em; padding-bottom: 0px; padding-right: 0px">已訂閱</button>
</form>