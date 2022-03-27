<div class="hover-lighter card-mobile-panel" style="margin-bottom: 15px; border-radius: 5px;">
	<a href="{{ route('video.watch') }}?v={{ $video->id }}" style="text-decoration: none;">
		<div style="position: relative;">
			<img style="width: 100%;" src="https://cdn.jsdelivr.net/gh/guaishushukanlifan/Project-H@latest/asset/thumbnail/2jSdwcGl.jpg">
			<img style="position: absolute; top: 0; left: 0; height: 100%; object-fit: cover;" src="{{ $video->thumbL() }}">
			<div style="position: absolute; height: 25px; width: 100%; bottom: 0px; background: linear-gradient(to bottom, transparent 0%, black 120%);">
				<div style="float: left; line-height: 25px; font-weight: 400">
					<span class="card-mobile-views material-icons-outlined">smart_display</span>
					<span style="font-size: 10px; color: white;">{{ $video->views() }}</span>

					<span class="card-mobile-created material-icons-outlined">wysiwyg</span>
					<span style="font-size: 10px; color: white;">{{ Carbon\Carbon::parse($video->created_at)->diffForHumans() }}</span>
				</div>
				@if ($video->duration != null)
				    <div class="card-mobile-duration">
				    	{{ $video->duration >= 3600 ? gmdate('H:i:s', $video->duration) : gmdate('i:s', $video->duration) }}
				    </div>
			    @endif
		    </div>
	    </div>
	</a>

	<div style="margin-top: 6px; padding: 0 8px;">
		<div style="text-decoration: none; color: black;">
			<a href="{{ route('video.watch') }}?v={{ $video->id }}" style="text-decoration: none; font-size: inherit;">
				<div class="card-mobile-title">{{ $video->title }}</div>
			</a>

			<div style="margin-top: 10px; padding-bottom: 10px; font-weight: 400">
				@if (array_key_exists('3D', $video->tags_array))
					<span class="card-mobile-genre" style="color: rgba(245, 171, 53, 1); border-color: rgba(245, 171, 53, 0.30);">3D</span>
				@elseif (array_key_exists('同人', $video->tags_array))
					<span class="card-mobile-genre" style="color: rgba(241, 130, 141,1); border-color: rgba(241, 130, 141, 0.30);">同人</span>
				@elseif (array_key_exists('Cosplay', $video->tags_array))
					<span class="card-mobile-genre" style="color: rgba(165, 55, 253, 1); border-color: rgba(165, 55, 253, 0.30);">COS</span>
				@else
					<span class="card-mobile-genre" style="color: rgba(242, 38, 19, 1); border-color: rgba(242, 38, 19, 0.30);">裏番</span>
				@endif
				<span style="font-size: 11px; color: dimgray; margin-left: 2px" class="card-mobile-user">{{ $video->user->name }}</span>
			</div>
		</div>
	</div>
</div>