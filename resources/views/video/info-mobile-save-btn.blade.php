<button id="info-mobile-save-btn" class="single-icon-wrapper no-button-style" method="POST">
  	<div class="single-icon no-select">
  		@if (Auth::check() && App\Save::where('user_id', auth()->user()->id)->where('video_id', $video->id)->first())
  			<i class="material-icons">done</i>
		    <div>已儲存</div>
		@else
			<i class="material-icons">add</i>
		    <div>{{ Request::is('/') ? '播放清單' : '儲存' }}</div>
  		@endif
	</div>
</button>