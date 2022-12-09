<div class="hover-lighter card-mobile-panel" style="margin-bottom: 15px; border-radius: 5px;">
	<a href="{{ route('video.watch') }}?v={{ $video->id }}" style="text-decoration: none;">
		<div style="position: relative;">
			<img style="width: 100%;" src="https://i.imgur.com/D1l0JoC.jpg">
			<img style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 3px" src="{{ $video->thumbL() }}">
	    </div>
	</a>

	<div style="margin-top: -1px; padding: 0 8px;">
		<div style="text-decoration: none; color: black;">
			<a href="{{ route('video.watch') }}?v={{ $video->id }}" style="text-decoration: none; font-size: inherit;">
				<div class="card-mobile-title">{{ str_replace("[".$video->user->name."] ", "", $video->title) }}</div>
			</a>

			<div class="card-mobile-genre-wrapper" style="margin-top: 3px; margin-left: -2px">
				<a href="{{ route('home.search') }}?query={{ $video->user->name }}" style="font-size: 12px; color: dimgray; margin-left: 2px; display: inline-block;" class="card-mobile-user">{{ $video->user->name }}</a>
			</div>


			<div style="float: left; margin-top: -3px; margin-bottom: 45px">
				@if ($video->duration != null)
				    <div class="card-mobile-duration" style="background: #2E2E2E; padding: 0px 3px; line-height: 20px; color: #b8babc;">
				    	{{ $video->duration >= 3600 ? gmdate('H:i:s', $video->duration) : gmdate('i:s', $video->duration) }}
				    </div>
			    @endif

			    <div class="card-mobile-duration" style="background: #2E2E2E; padding: 0px 3px; line-height: 20px; margin-right: 5px; color: #b8babc;">
			    	{{ $video->views() }}次
			    </div>
			</div>

		</div>
	</div>
</div>