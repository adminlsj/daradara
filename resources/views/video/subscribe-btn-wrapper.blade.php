<div id="subscribe-panel" style="margin-top: -32px; text-align: right;">
	@if (Auth::check())
		@if ($is_subscribed)
			@include('video.unsubscribeBtn')
		@else
			@include('video.subscribeBtn')
		@endif
	@else
		<div data-toggle="modal" data-target="#signUpModal">
		  <button id="subscribe-btn" class="video-subscribe-btn" type="submit">訂閱</button>
		</div>
	@endif
</div>