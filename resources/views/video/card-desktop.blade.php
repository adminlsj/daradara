<div class="load-more-wrapper video-card card-desktop" data-poster="{{ $video->imgurL() }}" data-preview="{{ isset($video->qualities) ? $video->qualities[array_key_first($video->qualities)] : $video->sd }}">
	<a style="font-size: 14px; text-decoration: none;" href="{{ route('video.watch').'?v='.$video->id }}" title="{{ $video->title }}">
        <div class="preview-wrapper" style="position: relative;">
		    <img class="lazy" style="width: 100%; height: 100%;" src="https://i.imgur.com/WENZTSJl.jpg" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">
		    @if ($video->duration != null)
			    <div style="position: absolute; right: 4px; bottom: 4px; color: white; background-color: rgba(0, 0, 0, 0.75); font-size: 12px; font-weight: 500; padding: 0px 5px; border-radius: 2px; z-index: 1;">
			    	{{ $video->duration >= 3600 ? gmdate('H:i:s', $video->duration) : gmdate('i:s', $video->duration) }}
			    </div>
		    @endif
		    <div id="myBar" style="width: 0%; height: 2px; background-color: red; position: absolute; top: 0px; left: 0px; z-index: 2"></div>
	    </div>
	    <div class="card-info-wrapper">
		    <div style="color:white; font-weight: bold; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $video->title }}</div>
		    <div class="hidden-xs" style="color: dimgray; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; font-size: 0.85em; margin-top: 5px;">{{ $video->user->name }}</div>
		    <div class="card-info-lower-wrapper" style="color: dimgray; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; font-size: 0.85em;">觀看次數：{{ $video->views() }}次 • {{ Carbon\Carbon::parse($video->created_at)->diffForHumans() }}</div>
		</div>
	</a>
</div>