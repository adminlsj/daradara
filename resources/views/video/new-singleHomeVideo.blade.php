<div class="col-xs-6 col-sm-3 col-md-2 hover-opacity-all" style="padding-left:8px; padding-right:8px; margin-bottom: 6px; width: 20%">
	<div style="background-color: #F9F9F9; border-radius: 3px; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.1);">
		<a href="{{ route('video.watch') }}?v={{ $video->id }}">
			<img class="lazy" style="border-top-left-radius: 3px; border-top-right-radius: 3px; width: 100%; height: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">
		</a>

		<div style="position: relative; height: 82px; padding: 0px 12px; padding-top: 2px;">
		    <div>
		        <a style="color: #323232; text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video->id }}">
		          <h4 style="margin-top: 5px; font-weight: bold; line-height: 19px; font-size: 1em;overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;">{{ $video->title }}</h4>
		        </a>

		       <div style="position: absolute; bottom: -10px; left: 13px;">
					<img class="lazy" style="float:left; width: 18px; height: 18px; margin-top: 1px" src="{{ $video->user()->avatarCircleB() }}" data-src="{{ $video->user()->avatar == null ? $video->user()->avatarDefault() : $video->user()->avatar->filename }}" data-srcset="{{ $video->user()->avatar == null ? $video->user()->avatarDefault() : $video->user()->avatar->filename }}">
					<a class="text-ellipsis" href="{{ route('user.show', [$video->user()]) }}" style="color: darkgray; font-size: 0.8em; margin-left: 5px; font-weight: bold">{{ $video->user()->name }}</a>
				</div>
		    </div>
		</div>​
	</div>
</div>