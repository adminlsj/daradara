<button id="info-mobile-save-btn" class="single-icon-wrapper no-button-style" method="POST">
  	<div class="single-icon no-select">
  		@if (Auth::check() && $video->saves->where('user_id', Auth::user()->id)->first())
  			<i class="material-icons">done</i>
		    <div>已儲存</div>
		@else
			<i class="material-icons">add</i>
		    <div>{{ Request::is('/') ? '播放清單' : '儲存' }}</div>
  		@endif
	</div>
</button>