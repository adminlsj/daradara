<form id="unsubscribe-form" action="{{ route('subscribe.destroy') }}" method="POST">
  {{ csrf_field() }}
  <input name="subscribe-source" type="hidden" value="playlist">
  <input name="subscribe-type" type="hidden" value="watch">
  <input name="subscribe-tag" type="hidden" value="{{ $tag }}">
  <input name="subscribe-user-id" type="hidden" value="{{ Auth::user()->id }}">
  <button id="unsubscribe-btn" type="submit" style="background-color: #303030 !important; border-color: #303030 !important; color: gray;" class="btn btn-info">已訂閱</button>
</form>