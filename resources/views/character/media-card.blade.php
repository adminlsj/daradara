<div class="media-card">
	<a class="cover" href="{{ route('character.show', ['character' => $character->id, 'title' => $character->getName($chinese)]) }}">
		<img src="{{ $character->photo_cover }}" alt="">
	</a>
	<a style="text-decoration: none" href="{{ route('character.show', ['character' => $character->id, 'title' => $character->getName($chinese)]) }}">{{ $character->getName($chinese) }}
	</a>
</div>