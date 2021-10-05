<div style="margin: 0 4px; margin-bottom: 9px; background-color: black; border-radius: 3px; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.5);">
	<a href="{{ route('video.watch') }}?v={{ $video->id }}" style="text-decoration: none;" data-poster="{{ $video->imgurH() }}" data-preview="{{ isset($video->qualities) ? $video->qualities[array_key_first($video->qualities)] : $video->sd }}">
		<div style="position: relative;">
			<img style="width: 100%; border-top-left-radius: 3px; border-top-right-radius: 3px;" src="https://i.imgur.com/2jSdwcG.png">
			<img style="position: absolute; top: 0; left: 0; height: 100%; object-fit: cover" src="{{ $video->imgurL() }}">
			<div style="position: absolute; height: 25px; width: 100%; bottom: 0px; background: linear-gradient(to bottom, transparent 0%, black 120%);">
				<div style="float: left; line-height: 25px; font-weight: 400">
					<span style="font-size: 15px; color: white; padding-left: 7px; padding-right: 3px; vertical-align: middle; margin-top: -8px; font-weight: 400;" class="material-icons-outlined">smart_display</span>
					<span style="font-size: 10px; color: white;">{{ $video->views() }}</span>

					<span style="font-size: 13px; color: white; padding-left: 10px; padding-right: 5px; vertical-align: middle; margin-top: -8px; transform: scale(1.25,1); font-weight: 400" class="material-icons-outlined">wysiwyg</span>
					<span style="font-size: 10px; color: white;">{{ Carbon\Carbon::parse($video->created_at)->diffForHumans() }}</span>
				</div>
				@if ($video->duration != null)
				    <div style="float: right; color: white; font-size: 10px; font-weight: 400; padding: 0px 6px; border-radius: 2px; z-index: 1; line-height: 25px;">
				    	{{ $video->duration >= 3600 ? gmdate('H:i:s', $video->duration) : gmdate('i:s', $video->duration) }}
				    </div>
			    @endif
		    </div>
	    </div>
	</a>

	<div style="margin-top: 6px; padding: 0 8px;">
		<div style="text-decoration: none; color: black;">
			<div style="font-size: 0.89em; line-height: 18px; color: white; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; font-weight: 400; height: 34px">{{ $video->title }}</div>

			<div style="margin-top: 7px; padding-bottom: 7px; font-weight: 400">
				@if (array_key_exists('3D', $video->tags_array))
					<span class="card-mobile-genre" style="color: rgba(245, 171, 53, 1); border-color: rgba(245, 171, 53, 0.30);">3D</span>
				@elseif (array_key_exists('同人', $video->tags_array))
					<span class="card-mobile-genre" style="color: rgba(241, 130, 141,1); border-color: rgba(241, 130, 141, 0.30);">同人</span>
				@elseif (array_key_exists('Cosplay', $video->tags_array))
					<span class="card-mobile-genre" style="color: rgba(165, 55, 253, 1); border-color: rgba(165, 55, 253, 0.30);">COS</span>
				@else
					<span class="card-mobile-genre" style="color: rgba(242, 38, 19, 1); border-color: rgba(242, 38, 19, 0.30);">裏番</span>
				@endif
				<span style="font-size: 12px; color: dimgray;" class="inner">{{ $video->user->name }}</span>
			</div>
		</div>
	</div>
</div>