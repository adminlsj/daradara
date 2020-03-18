<form id="subscribe-form" action="{{ route('video.subscribe') }}" method="POST">
  {{ csrf_field() }}
  <input name="subscribe-source" type="hidden" value="video">
  <input name="subscribe-type" type="hidden" value="watch">
  <input name="subscribe-tag" type="hidden" value="{{ $tag }}">
  <input name="subscribe-user-id" type="hidden" value="{{ Auth::user()->id }}">
  <button id="subscribe-btn" class="video-subscribe-btn" type="submit">訂閱</button>
</form>