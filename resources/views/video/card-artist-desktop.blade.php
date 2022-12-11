<div class="hover-lighter card-mobile-panel" style="margin-bottom: 30px; border-radius: 5px;">
	<a href="{{ route('home.search') }}?query={{ $artist->name }}" style="text-decoration: none;">
		<div style="position: relative;">
			<img style="width: 100%;" src="https://i.imgur.com/1JyJ58n.jpg">
			<img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 3px" src="{{ $artist->avatar_temp }}">
	    </div>
	</a>

	<div style="margin-top: -1px; padding: 0 8px;">
		<div style="text-decoration: none; color: black;">
			<a href="{{ route('home.search') }}?query={{ $artist->name }}" style="color: white; font-size: inherit;">
				<div class="card-mobile-title search-artist-title">{{ $artist->name }}</div>
			</a>

			<div class="card-mobile-genre-wrapper" style="margin-top: 3px; margin-left: -2px">
				<a style="text-decoration: none; font-size: 12px; color: dimgray; margin-left: 2px; display: inline-block;" class="card-mobile-user search-artist-count">{{ $artist->videos_count }} 部影片</a>
			</div>
		</div>
	</div>
</div>