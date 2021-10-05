<div style="margin: 0 4px; margin-bottom: 9px; background-color: #141414; border-radius: 3px; box-shadow: 0 0px 2px 0 rgba(232, 232, 232, 0.1);">
	<a href="{{ route('video.watch') }}?v={{ $video->id }}" style="text-decoration: none;" data-poster="{{ $video->imgurH() }}" data-preview="{{ isset($video->qualities) ? $video->qualities[array_key_first($video->qualities)] : $video->sd }}">
		<div style="position: relative;">
			<img class="lazy" style="width: 100%; border-top-left-radius: 3px; border-top-right-radius: 3px;" src="https://i.imgur.com/WENZTSJl.jpg" data-src="{{ $video->imgurH() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">
			<div style="position: absolute; height: 20px; width: 100%; bottom: 0px; background: linear-gradient(to bottom, transparent 0%, black 120%);">
				<div style="float: left; line-height: 20px; font-weight: 400">
					<span style="font-size: 16px; color: white; padding-left: 6px; padding-right: 3px; vertical-align: middle; margin-top: -8px;" class="material-icons-outlined">smart_display</span>
					<span style="font-size: 10px; color: white;">{{ $video->views() }}</span>
				</div>
				@if ($video->duration != null)
				    <div style="float: right; color: white; font-size: 10px; font-weight: 400; padding: 0px 5px; border-radius: 2px; z-index: 1; line-height: 20px;">
				    	{{ $video->duration >= 3600 ? gmdate('H:i:s', $video->duration) : gmdate('i:s', $video->duration) }}
				    </div>
			    @endif
		    </div>
	    </div>
	</a>

	<div style="margin-top: 5px; padding: 0 7px;">
		<div style="text-decoration: none; color: black;">
			<div style="font-size: 0.85em; line-height: 17px; color: white; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; font-weight: 400; height: 31px">{{ $video->title }}</div>
			<div style="font-size: 0.75em; color: dimgray; margin-top: 10px; padding-bottom: 5px; font-weight: 400" class="inner">觀看次數：{{ $video->views() }}次 • {{ Carbon\Carbon::parse($video->created_at)->diffForHumans() }}</div>
		</div>
	</div>
</div>