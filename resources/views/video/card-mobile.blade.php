<div style="margin-bottom: 20px;">
	<a class="preview-trigger" href="{{ route('video.watch') }}?v={{ $video->id }}" style="text-decoration: none;" data-poster="{{ $video->imgurH() }}" data-preview="{{ isset($video->qualities) ? $video->qualities[array_key_first($video->qualities)] : $video->sd }}">
		<div class="preview-wrapper" style="position: relative;">
			<img class="lazy" style="width: 100%;" src="https://i.imgur.com/WENZTSJl.jpg" data-src="{{ $video->imgurH() }}" data-srcset="{{ $video->imgurH() }}" alt="{{ $video->title }}">
			@if ($video->duration != null)
			    <div style="position: absolute; right: 6px; bottom: 6px; color: white; background-color: rgba(0, 0, 0, 0.75); font-size: 12px; font-weight: bold; padding: 0px 5px; border-radius: 2px; z-index: 1">
			    	{{ $video->duration >= 3600 ? gmdate('H:i:s', $video->duration) : gmdate('i:s', $video->duration) }}
			    </div>
		    @endif
		    <div id="myBar" style="width: 0%; height: 2px; background-color: red; position: absolute; top: 0px; left: 0px; z-index: 2"></div>
	    </div>
	</a>

	<div style="margin-top: 10px; padding: 0 15px;">
		<div class="multiple-link-wrapper" style="text-decoration: none; color: black;">
			<a href="{{ route('video.watch').'?v='.$video->id }}" class="overlay"></a>
			<div class="inner"><a href="{{ route('video.watch').'?v='.$video->id }}" style="text-decoration: none; float: left; ">
				<img style="width: 38px; height: auto; border-radius: 50%;" src="{{ $video->user->avatar_temp }}">
			</a></div>
			<div style="margin-left: 50px; font-size: 1.05em; line-height: 20px; color: white; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $video->title }}</div>
			<div style="margin-left: 50px; font-size: 0.89em; color: dimgray; margin-top: 3px;" class="inner">{{ $video->user->name }} • 觀看次數：{{ $video->views() }}次 • {{ Carbon\Carbon::parse($video->created_at)->diffForHumans() }}</div>
		</div>
	</div>
</div>