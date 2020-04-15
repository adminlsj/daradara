<form id="subscribe-form" action="{{ route('subscribe.store') }}" method="POST">
  {{ csrf_field() }}
  <input name="subscribe-source" type="hidden" value="video">
  <input name="subscribe-type" type="hidden" value="watch">
  <input name="subscribe-tag" type="hidden" value="{{ $tag }}">
  <input name="subscribe-user-id" type="hidden" value="{{ Auth::user()->id }}">
  <button id="subscribe-btn" type="submit" style="background-color: #D5D5D5 !important; color: #666666; border-color: #D5D5D5 !important; height: 34px; line-height: 10px; width: 75px;" class="btn btn-info">訂閱</button>
</form>