<a style="text-decoration: none; color: #595959" href="{{ $link }}">
	<div class="row {{ $is_current ? 'active' : ''}}" style="height: 40px; margin-right: 0px;">
		<div class="col-md-6" style="margin-top: 8px; width: auto; margin-left: 25px">
			<img class="lazy img-circle" style="width: 25px; height: auto;" src="https://i.imgur.com/JMcgEkPs.jpg" data-src="https://i.imgur.com/{{ $icon }}s.jpg" data-srcset="https://i.imgur.com/{{ $icon }}s.jpg" alt="{{ $title }}">
		</div>
		<div id="fontColor" class="col-md-6" style="margin-top: 10px; width: auto; margin-left: -8px;">
			{{ $title }}
		</div>
	</div>
</a>