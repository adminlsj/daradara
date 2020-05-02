<form id="subscribe-form" action="{{ route('video.subscribe') }}" method="POST">
  {{ csrf_field() }}
  <input name="subscribe-source" type="hidden" value="tag">
  <input name="subscribe-type" type="hidden" value="{{ App\Watch::where('title', $tag)->first() ? 'watch' : 'video' }}">
  <input name="subscribe-tag" type="hidden" value="{{ $tag }}">
  <input name="subscribe-user-id" type="hidden" value="{{ Auth::user()->id }}">
  <button id="subscribe-btn" type="submit" style="background-color: crimson !important; border-color: crimson !important" class="btn btn-info">訂閱</button>
</form>