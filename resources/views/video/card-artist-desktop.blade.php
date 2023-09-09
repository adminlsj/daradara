<div class="card-mobile-panel inner">
	<div style="position: relative;">
		<img style="width: 100%;" src="https://img4.qy0.ru/data/2197/80/card_artist_background.jpg">
		<img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 3px" src="{{ $artist->avatar_temp }}">
    </div>

	<div class="card-mobile-details-wrapper" style="margin-top: -1px; padding: 0 3px;">
		<div style="text-decoration: none; color: black;">
			<div class="card-mobile-title search-artist-title" style="font-weight: normal; color: #e5e5e5;">{{ $artist->name }}</div>

			<div class="card-mobile-genre-wrapper" style="margin-top: 3px; margin-left: -2px">
				<span style="text-decoration: none; font-size: 12px; color: dimgray; margin-left: 2px; display: inline-block;" class="card-mobile-user search-artist-count">{{ $artist->videos_count }} 部影片</span>
			</div>
		</div>
	</div>
</div>