<div class="hover-lighter card-mobile-panel" style="margin-bottom: 8px;">
	<div style="width: 84px; display: inline-block;">
		<a href="{{ route('home.search') }}?query={{ $artist->name }}" style="text-decoration: none;">
			<div style="position: relative; display: inline-block;">
				<img style="width: 100%; height: 100%; border-radius: 5px;" src="https://i.imgur.com/wCSgaov.png">
				<img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 5px" src="{{ $artist->avatar_temp }}">
		    </div>
		</a>
	</div>

	<div style="display: inline-block; text-decoration: none; margin-left: 8px; height: 60px; width: calc(100% - 102px); vertical-align: middle;">
		<a href="{{ route('home.search') }}?query={{ $artist->name }}" style="color: #e5e5e5; font-size: inherit;">
			<div class="card-mobile-title" style="color: #e5e5e5; font-weight: bold;">{{ $artist->name }}</div>
		</a>

		<div class="card-mobile-genre-wrapper" style="margin-top: 3px; margin-left: -2px">
			<a style="text-decoration: none; font-size: 12px; color: dimgray; margin-left: 2px; display: inline-block; font-weight: bold;" class="card-mobile-user">{{ $artist->videos_count }} 部影片</a>
		</div>
	</div>
</div>