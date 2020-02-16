<a style="text-decoration: none; color: #595959" href="{{ $link }}">
	<div class="row {{ $is_current ? 'active' : ''}}" style="height: 40px; margin-right: 0px;">
		<div class="col-md-6" style="margin-top: 8px; width: auto; margin-left: 25px">
			<i style="font-size: 1.7em;" class="material-icons">{{ $icon }}</i>
		</div>
		<div id="fontColor" class="col-md-6" style="margin-top: 10px; width: auto; margin-left: -5px;">
			{{ $title }}
		</div>
	</div>
</a>