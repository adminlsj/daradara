@if ($is_subscribed)
	@include('video.unsubscribeBtn')
@else
	@include('video.subscribeBtn')
@endif