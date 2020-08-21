<button id="info-mobile-like-btn" class="single-icon-wrapper no-button-style">
  <div class="single-icon no-select">
    <i class="{{ Auth::check() && App\Like::where('type', 'video')->where('user_id', Auth::user()->id)->where('foreign_id', $video->id)->first() ? 'material-icons' : 'material-icons-outlined' }}">thumb_up</i>
    <div>{{ App\Like::count('video', $video->id, true) }}</div>
  </div>
</button>