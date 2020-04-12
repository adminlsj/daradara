<div id="subscribe-panel" style="padding-left: 5px; margin-top: -13px;">
	@if (Auth::check())
		@if ($is_subscribed)
			@include('video.intro-unsubscribe-btn')
		@else
			@include('video.intro-subscribe-btn')
		@endif
	@else
		<div data-toggle="modal" data-target="#signUpModal">
			<button style="background-color: crimson !important; border-color: crimson !important; height: 35px; line-height: 10px; width: 60px;" class="btn btn-info">訂閱</button>
		</div>
	    @include('user.signUpModal')
	    @include('user.loginModal')
	@endif
</div>