<button id="info-mobile-like-btn" class="single-icon-wrapper no-button-style">
  <div class="single-icon no-select">
    <i class="{{ $video->likes->where('user_id', Auth::user()->id)->first() ? 'material-icons' : 'material-icons-outlined' }}">thumb_up</i>
    <div>{{ $video->likes_count }}</div>
  </div>
</button>