<div class="media-card">
	<a class="cover" href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->getTitle($chinese)]) }}">
		<img src="{{ $anime->photo_cover }}" alt="">
	</a>
	<a style="text-decoration: none" href="{{ route('anime.show', ['anime' => $anime->id, 'title' => $anime->getTitle($chinese)]) }}">{{ $anime->getTitle($chinese) }}
	</a>
</div>