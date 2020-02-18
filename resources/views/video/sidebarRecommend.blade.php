<a style="text-decoration: none; color: #595959;" href="{{ $link }}">
	<div class="row {{ $is_current ? 'active' : ''}}" style="height: 40px; margin-right: 0px;">
		<div class="col-md-6" style="margin-top: 8px; width: auto; margin-left: 25px">
			<img class="lazy img-circle" style="width: 25px; height: auto;" src="https://i.imgur.com/JMcgEkPs.jpg" data-src="https://i.imgur.com/{{ $icon }}s.jpg" data-srcset="https://i.imgur.com/{{ $icon }}s.jpg" alt="{{ $title }}">
		</div>
		<div id="fontColor" class="col-md-6" style="margin-top: 10px; margin-left: -8px; width: 174px; margin-right: 0px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">
			{{ $title }}
		</div>
	</div>
</a>