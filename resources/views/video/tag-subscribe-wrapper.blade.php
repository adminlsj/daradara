<div id="subscribe-panel" style="margin-top: 11px; width: 80px; float: right">
	@if (Auth::check())
		@if ($is_subscribed)
			@include('video.tag-unsubscribe-btn')
		@else
			@include('video.tag-subscribe-btn')
		@endif
	@else
		<div data-toggle="modal" data-target="#signUpModal">
			<button style="background-color: crimson !important; border-color: crimson !important;" class="btn btn-info">訂閱</button>
		</div>
	    @include('user.signUpModal')
	    @include('user.loginModal')
	@endif
</div>