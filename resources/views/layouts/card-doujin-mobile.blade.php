<div class="card-mobile-panel inner">
	<div style="position: relative;">
		<img style="width: 100%;" src="https://cdn.jsdelivr.net/gh/jokogebai/jokogebai@v1.0.0/card_doujin_background.jpg">
		<img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 3px" src="{{ $video->thumbL() }}">

		<div style="position: absolute; right: -1px; bottom: -3px;">
			@if ($video->duration != null)
			    <div class="card-mobile-duration" style="color: white; font-size: 10px; text-shadow: black 1px 0 10px;">
			    	{{ $video->duration >= 3600 ? gmdate('H:i:s', $video->duration) : gmdate('i:s', $video->duration) }}
			    </div>
		    @endif
		</div>
		<div style="position: absolute; left: 3px; top: 3px;">
			<div class="card-mobile-duration" style="color: white; font-size: 10px; background-color: rgba(0, 0, 0, 0.6); padding: 0px 3px; line-height: 15px;">
		    	{{ $video->views() }}次
		    </div>
		</div>
    </div>

	<div style="padding: 0 3px;">
		<div style="text-decoration: none; color: black;">
			<div class="card-mobile-title" style="margin-top: 7px; font-weight: normal; color: #e5e5e5; padding: 0px; font-size: 12px">{{ str_replace("[".$video->user->name."] ", "", $video->title) }}</div>

			<div class="card-mobile-genre-wrapper" style="margin-left: -2px; padding: 0px; margin-top: -1px;">
				<a href="{{ route('home.search') }}?query={{ $video->user->name }}" style="font-size: 12px; color: dimgray; margin-left: 2px; display: inline-block; font-weight: normal !important;" class="card-mobile-user">{{ $video->user->name }}</a>
			</div>
		</div>
	</div>
</div>