<div id="subscribe-panel" style="padding-left: 5px; margin-top: -13px;">
	@if (Auth::check())
		@if ($is_subscribed)
			@include('video.watch-unsubscribe-btn')
		@else
			@include('video.watch-subscribe-btn')
		@endif
	@else
		<div data-toggle="modal" data-target="#signUpModal">
			<button style="background-color: #D5D5D5 !important; color: #666666; border-color: #D5D5D5 !important; height: 34px; line-height: 10px; width: 75px;" class="btn btn-info">訂閱</button>
		</div>
	    @include('user.signUpModal')
	    @include('user.loginModal')
	@endif
</div>