<div class="hidden-xs col-sm-3 hover-opacity-all load-more-wrapper" style="margin-bottom: 9px; width: 20%">
	<a style="color: inherit; text-decoration: none;" href="{{ route('video.playlist') }}?list={{ $watch->id }}">
	    <div style="position: relative;">
	        <img class="lazy" style="width: 100%; height: 100%;" src="{{ $watch->videos->first()->imgur16by9() }}" data-src="{{ $watch->videos->first()->imgurL() }}" data-srcset="{{ $watch->videos->first()->imgurL() }}" alt="{{ $watch->title }}">
	        <span style="right: 0px; height: calc(100% - 73px)">
		      	<div style="margin: 0;position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
			      	<div style="font-weight: bold">{{ $watch->videos->count() }}</div>
			      	<i style="font-size: 1.6em; margin-right: -5px; font-weight: bold" class="material-icons">playlist_play</i>
			    </div>
		    </span>
		    <div style="background-color: #e8eaed; padding: 7px 10px; height: 73px">
			    <div style="font-weight: bold; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $watch->title }}</div>
			    <div style="color: darkgray; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; font-size: 0.95em">{{ $user->name }}</div>
			</div>
		</div>
	</a>
</div>

<div class="hidden-sm hidden-md hidden-lg related-watch-wrap hover-opacity-all load-more-wrapper" style="background-color: #F9F9F9; margin-top: 0px; margin-left: 0px; margin-right: 0px; margin-bottom: 10px">
	<a href="{{ route('video.playlist') }}?list={{ $watch->id }}" class="row no-gutter">
	  <div style="padding-right: 4px; width: 175px;" class="col-xs-6 col-sm-6 col-md-6">
	    <img class="lazy" style="width: 100%; height: 100%; border-top-left-radius: 3px; border-bottom-left-radius: 3px;" src="{{ $watch->videos->first()->imgur16by9() }}" data-src="{{ $watch->videos->first()->imgurL() }}" data-srcset="{{ $watch->videos->first()->imgurL() }}" alt="{{ $watch->title }}">
	    <span style="right: 4px; height: 100%; width: 40%">
	      	<div style="margin: 0;position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
		      	<div style="font-weight: bold">{{ $watch->videos->count() }}</div>
		      	<i style="font-size: 1.6em; margin-right: -5px; font-weight: bold" class="material-icons">playlist_play</i>
		    </div>
	    </span>
	  </div>
	  <div style="padding-left: 4px; width: calc(100% - 175px)" class="col-xs-6 col-sm-6 col-md-6 related-watch-title">
	    <h4>{{ $watch->title }}</h4>
	  </div>
	</a>

	<div style="position: absolute; bottom: 7px; left: 182px;">
		<img class="lazy" style="float:left; width: 18px; height: 18px; margin-top: 1px" src="{{ $user->avatarCircleB() }}" data-src="{{ $user->avatar == null ? $user->avatarDefault() : $user->avatar->filename }}" data-srcset="{{ $user->avatar == null ? $user->avatarDefault() : $user->avatar->filename }}">
		<a href="{{ route('user.show', [$user]) }}" style="color: darkgray; font-size: 0.8em; margin-left: 5px;">{{ $user->name }}</a>
	</div>
</div>