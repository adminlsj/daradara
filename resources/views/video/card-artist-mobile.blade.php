<div class="card-mobile-panel inner">
	<div style="width: 84px; display: inline-block;">
		<div style="position: relative; display: inline-block;">
			<img style="width: 100%; height: 100%; border-radius: 5px;" src="https://i.imgur.com/wCSgaov.png">
			<img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 5px" src="{{ $artist->avatar_temp }}">
	    </div>
	</div>

	<div style="display: inline-block; text-decoration: none; margin-left: 8px; height: 60px; width: calc(100% - 102px); vertical-align: middle;">
		<div class="card-mobile-title" style="color: #e5e5e5; font-weight: bold;">{{ $artist->name }}</div>

		<div class="card-mobile-genre-wrapper" style="margin-top: 3px; margin-left: -2px">
			<span style="text-decoration: none; font-size: 12px; color: dimgray; margin-left: 2px; display: inline-block; font-weight: bold;" class="card-mobile-user">{{ $artist->videos_count }} 部影片</span>
		</div>
	</div>
</div>