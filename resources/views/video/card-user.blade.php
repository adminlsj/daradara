<div class="hidden-xs col-sm-3 hover-opacity-all load-more-wrapper" style="margin-bottom: 9px; width: 20%">
	<a style="color: inherit; text-decoration: none;" href="{{ route('user.show', [$user]) }}">
	    <div style="position: relative;">
	        <img style="width: 100%; height: 100%;" src="https://i.imgur.com/4qaPe1Nl.png"alt="{{ $user->name }}">
	        <img style="height: calc(100% - 73px); position: absolute; top: 0px; left: 50%;transform: translate(-50%, 0%);" src="{{ $user->avatar == null ? $user->avatarDefault() : $user->avatar->filename }}">
		    <div style="background-color: #e8eaed; padding: 7px 10px; height: 73px">
			    <div style="font-weight: bold; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $user->name }}</div>
			    <div style="color: darkgray; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; font-size: 0.95em">{{ $count }} 個播放清單</div>
			</div>
		</div>
	</a>
</div>

<div class="hidden-sm hidden-md hidden-lg related-watch-wrap hover-opacity-all" style="background-color: #F9F9F9; margin-top: 0px; margin-left: 0px; margin-right: 0px;">
	<a href="{{ route('user.show', [$user]) }}" class="row no-gutter">
	  <div style="padding-right: 4px; width: 175px;" class="col-xs-6 col-sm-6 col-md-6">
	    <img class="lazy" style="width: 100%; height: 100%; border-top-left-radius: 3px; border-bottom-left-radius: 3px;" src="https://i.imgur.com/4qaPe1Nl.png" data-src="https://i.imgur.com/4qaPe1Nl.png" data-srcset="https://i.imgur.com/4qaPe1Nl.png" alt="{{ $user->name }}">
	    <img style="height: 100%; position: absolute; top: 0px; left: 50%;transform: translate(-50%, 0%);" src="{{ $user->avatar == null ? $user->avatarDefault() : $user->avatar->filename }}">
	  </div>
	  <div style="padding-left: 4px; width: calc(100% - 175px)" class="col-xs-6 col-sm-6 col-md-6 related-watch-title">
	    <h4>{{ $user->name }}</h4>
	  </div>
	</a>

	<div style="position: absolute; bottom: 7px; left: 178px;">
		<a style="color: darkgray; font-size: 0.8em; margin-left: 5px;">{{ $count }} 個播放清單</a>
	</div>
</div>