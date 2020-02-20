<form id="unsubscribe-form" action="{{ route('video.unsubscribe') }}" method="POST">
  {{ csrf_field() }}
  <input name="subscribe-user-id" type="hidden" value="{{ Auth::user()->id }}">
  <input name="subscribe-watch-category" type="hidden" value="{{ $watch->category }}">
  <button id="unsubscribe-btn" type="submit" style="float: right; margin-top: -29px; color: darkgray; font-weight: 500; cursor: pointer; border: none; background-color: inherit; padding-right: 0px">已訂閱</button>
</form>