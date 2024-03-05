<form id="video-subscribe-form" action="{{ route('video.subscribe') }}" method="POST">
  {{ csrf_field() }}
  <input name="subscribe-user-id" type="hidden" value="{{ $user_id }}">
  <input name="subscribe-artist-id" type="hidden" value="{{ $artist_id }}">
  <input name="subscribe-status" type="hidden" value="{{ $subscribed }}">
  <button id="video-subscribe-btn" class="no-select video-subscribe-btn no-button-style" method="POST">
    {{ $subscribed ? '已訂閱' : '訂閱'}}
  </button>
</form>