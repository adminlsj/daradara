<div class="hidden-xs col-sm-3 hover-opacity-all load-more-wrapper" style="margin-bottom: 9px;">
	<a style="color: inherit; text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video->id }}">
	    <div style="position: relative;">
	        <img class="lazy" style="width: 100%; height: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">
		    <div style="background-color: #e8eaed; padding: 7px 10px; height: 73px">
			    <div style="font-weight: bold; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $video->title }}</div>
			    <div href="{{ $video->sd }}" style="color: darkgray; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; font-size: 0.95em">{{ str_ireplace('player.', '', str_ireplace('www.', '', parse_url($video->sd, PHP_URL_HOST))) }}</div>
			</div>
		</div>
	</a>
</div>

<div class="hidden-sm hidden-md hidden-lg related-watch-wrap hover-opacity-all" style="background-color: #F9F9F9; margin-top: 0px; margin-left: 0px; margin-right: 0px;">
	<a href="{{ route('video.watch') }}?v={{ $video->id }}" class="row no-gutter">
	  <div style="padding-right: 4px; width: 175px;" class="col-xs-6 col-sm-6 col-md-6">
	    <img class="lazy" style="width: 100%; height: 100%; border-top-left-radius: 3px; border-bottom-left-radius: 3px;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">
	  </div>
	  <div style="padding-left: 4px; width: calc(100% - 175px)" class="col-xs-6 col-sm-6 col-md-6 related-watch-title">
	    <h4>{{ $video->title }}</h4>
	  </div>
	</a>

	<div style="position: absolute; bottom: 7px; left: 182px;">
		<img class="lazy" style="float:left; width: 18px; height: 18px; margin-top: 1px" src="{{ $video->user->avatarCircleB() }}" data-src="{{ $video->user->avatar == null ? $video->user->avatarDefault() : $video->user->avatar->filename }}" data-srcset="{{ $video->user->avatar == null ? $video->user->avatarDefault() : $video->user->avatar->filename }}">
		<a href="{{ route('user.show', [$video->user]) }}" style="color: darkgray; font-size: 0.8em; margin-left: 5px;">{{ $video->user->name }}</a>
	</div>
</div>