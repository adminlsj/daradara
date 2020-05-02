<form id="unsubscribe-form" action="{{ route('video.unsubscribe') }}" method="POST">
  {{ csrf_field() }}
  <input name="subscribe-source" type="hidden" value="tag">
  <input name="subscribe-type" type="hidden" value="{{ App\Watch::where('title', $tag)->first() ? 'watch' : 'video' }}">
  <input name="subscribe-tag" type="hidden" value="{{ $tag }}">
  <input name="subscribe-user-id" type="hidden" value="{{ Auth::user()->id }}">
  <button id="unsubscribe-btn" type="submit" style="background-color: #303030 !important; border-color: #303030 !important; color: gray !important" class="btn btn-info">已訂閱</button>
</form>