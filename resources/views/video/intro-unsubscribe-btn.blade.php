<form id="unsubscribe-form" action="{{ route('video.unsubscribe') }}" method="POST">
  {{ csrf_field() }}
  <input name="subscribe-source" type="hidden" value="intro">
  <input name="subscribe-type" type="hidden" value="watch">
  <input name="subscribe-tag" type="hidden" value="{{ $tag }}">
  <input name="subscribe-user-id" type="hidden" value="{{ Auth::user()->id }}">
  <button id="unsubscribe-btn" type="submit" style="background-color: #595959 !important; border-color: #595959 !important; color: #999999; height: 34px; line-height: 10px; width: 75px; padding-left: 12px; font-weight: bold" class="btn btn-info">已訂閱</button>
</form>