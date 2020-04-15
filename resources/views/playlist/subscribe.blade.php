<div id="subscribe-panel" style="padding-left: 5px; margin-top: -13px;">
	@if (Auth::check())
		@if ($is_subscribed)
			@include('playlist.unsubscribe-btn')
		@else
			@include('playlist.subscribe-btn')
		@endif
	@else
		<div data-toggle="modal" data-target="#signUpModal">
			<button style="background-color: crimson !important; border-color: crimson !important;" class="btn btn-info">訂閱</button>
		</div>
	    @include('user.signUpModal')
	    @include('user.loginModal')
	@endif
</div>