<div id="subscribe-panel" style="margin-top: -32px; text-align: right;">
	@if ($is_subscribed)
		@include('video.unsubscribeBtn')
	@else
		@include('video.subscribeBtn')
	@endif
</div>