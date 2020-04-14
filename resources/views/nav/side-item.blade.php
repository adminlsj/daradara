<a style="text-decoration: none; color: #595959" href="{{ $link }}">
	<div class="row {{ $is_current ? 'active' : ''}}" style="height: 40px; margin-right: 0px;">
		<div class="col-md-6" style="margin-top: 8px; width: auto; margin-left: 25px;">
			@if (Auth::check() && strpos(auth()->user()->alert, 'subscribe') !== false && $icon == 'subscriptions')
				<i style="font-size: 1.7em;" class="material-icons">{{ $icon }}</i>
				<span style="position: absolute; margin-top: -10px; margin-left: -10px;" class="alert-circle"></span>
			@else
				<i style="font-size: 1.7em;" class="material-icons">{{ $icon }}</i>
			@endif
		</div>
		<div id="fontColor" class="col-md-6" style="margin-top: 10px; width: auto; margin-left: -5px;">
			{{ $title }}
		</div>
	</div>
</a>