<button id="info-mobile-like-btn" class="single-icon-wrapper no-button-style">
  <div class="single-icon no-select">
    <i class="{{ Auth::check() && $video->likes->where('user_id', Auth::user()->id)->first() ? 'material-icons' : 'material-icons-outlined' }}">thumb_up</i>
    <div>{{ App\Like::count('video', $video->id, true) }}</div>
  </div>
</button>