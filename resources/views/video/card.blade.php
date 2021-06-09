<div class="hidden-xs load-more-wrapper video-card multiple-link-wrapper preview-trigger-desktop" style="margin-bottom: 50px; display: inline-block; vertical-align: top" data-poster="{{ $video->imgurL() }}" data-preview="{{ isset($video->qualities) ? $video->qualities[array_key_first($video->qualities)] : $video->sd }}">
	<a href="{{ route('video.watch').'?v='.$video->id }}" class="overlay" title="{{ $video->title }}"></a>
    <div style="position: relative;" class="inner">
        <div class="preview-wrapper" style="position: relative;">
		    <img style="width: 100%; height: 100%;" src="{{ $video->imgurL() }}" alt="{{ $video->title }}">
		    @if ($video->duration != null)
			    <div style="position: absolute; right: 4px; bottom: 4px; color: white; background-color: rgba(0, 0, 0, 0.75); font-size: 12px; font-weight: 500; padding: 0px 5px; border-radius: 2px; z-index: 1;">
			    	{{ $video->duration >= 3600 ? gmdate('H:i:s', $video->duration) : gmdate('i:s', $video->duration) }}
			    </div>
		    @endif
		    <div id="myBar" style="width: 0%; height: 2px; background-color: red; position: absolute; top: 0px; left: 0px; z-index: 2"></div>
	    </div>
	    <div style="padding: 7px 5px; height: 77px">
		    <div style="color:white; font-weight: bold; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $video->title }}</div>
		    <div style="color: dimgray; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; font-size: 0.85em; margin-top: 5px;">{{ $video->user->name }}</div>
		    <div style="color: dimgray; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; font-size: 0.85em;">觀看次數：{{ $video->views() }}次 • {{ Carbon\Carbon::parse($video->created_at)->diffForHumans() }}</div>
		</div>
	</div>
</div>

<div class="hidden-sm hidden-md hidden-lg preview-trigger-mobile" style="margin-bottom: 20px;" data-poster="{{ $video->imgurL() }}" data-preview="{{ isset($video->qualities) ? $video->qualities[array_key_first($video->qualities)] : $video->sd }}">
	<a href="{{ route('video.watch') }}?v={{ $video->id }}" style="text-decoration: none;">
		<div class="preview-wrapper" style="position: relative;">
			<img style="width: 100%;" src="{{ $video->imgurH() }}" alt="{{ $video->title }}">
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
				<img style="width: 38px; height: auto; border-radius: 50%;" src="{{ $video->user->avatar == null ? $video->user->avatarDefault() : $video->user->avatar->filename }}">
			</a></div>
			<div style="margin-left: 50px; font-size: 1.05em; line-height: 20px; color: white; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $video->title }}</div>
			<div style="margin-left: 50px; font-size: 0.89em; color: dimgray; margin-top: 3px;" class="inner">{{ $video->user->name }} • 觀看次數：{{ $video->views() }}次 • {{ Carbon\Carbon::parse($video->created_at)->diffForHumans() }}</div>
		</div>
	</div>
</div>