<form id="unsubscribe-form" action="{{ route('video.unsubscribe') }}" method="POST">
  {{ csrf_field() }}
  <input name="subscribe-source" type="hidden" value="intro">
  <input name="subscribe-user-id" type="hidden" value="{{ Auth::user()->id }}">
  <input name="subscribe-watch-id" type="hidden" value="{{ $watch->id }}">
  <button id="unsubscribe-btn" type="submit" style="background-color: #303030 !important; border-color: #303030 !important; color: gray !important" class="btn btn-info">已訂閱</button>
</form>