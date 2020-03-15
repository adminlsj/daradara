<div id="subscribe-panel" style="margin-top: -32px; text-align: right;">
	@if (Auth::check())
		@if ($is_subscribed)
			@include('video.unsubscribeBtn')
		@else
			@include('video.subscribeBtn')
		@endif
	@else
		<div data-toggle="modal" data-target="#signUpModal">
		  <button id="subscribe-btn" type="submit" style="font-weight: 500; cursor: pointer; border: none; background-color: inherit; font-size: 1.3em; padding-bottom: 0px; padding-right: 0px; color: crimson">訂閱</button>
		</div>
	@endif
</div>