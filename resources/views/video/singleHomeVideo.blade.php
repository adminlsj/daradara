<div class="hidden-xs hidden-sm col-md-6">
	<a href="{{ route('video.trending') }}?v={{ $video->id }}">
	  <img style="border-radius: 5px;" src="https://i.imgur.com/{{ $video->imgur }}m.png" width="100%" height="100%">
	</a>

	<div style="position: relative; height: 50px">
	    <span style="position: absolute; top:-28px; right: 6px; background-color: rgba(0,0,0,0.8); color: white; padding: 1px 5px 1px 5px; font-size: 0.85em; border-radius: 2px; opacity: 0.9">{{ $video->duration() }}</span>
	    <div>
	        <a href="{{ route('video.trending') }}?v={{ $video->id }}">
	          <h4 style="margin-top: 5px; font-weight: 500; line-height: 19px; font-size: 1em;overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $video->title }}</h4>
	        </a>

	        <p style="color: gray; margin-top: -7px; margin-bottom: 0px; font-size: 0.85em;">
	        	<i style="vertical-align:middle; font-size: 1.2em; margin-top: -2.5px;" class="material-icons">remove_red_eye</i>
	        	{{ $video->views() }}次 • {{ Carbon\Carbon::parse($video->created_at)->format('Y-m-d') }}
	        </p>
	    </div>
	</div>​
</div>

<div class="visible-xs visible-sm col-xs-6 col-sm-6" style="{{ $loop->iteration % 2 == 0 ? 'padding-right: 30px; padding-left:7.5px;' : 'padding-left: 30px; padding-right:7.5px;' }}">
	<a href="{{ route('video.trending') }}?v={{ $video->id }}">
	  <img style="border-radius: 5px;" src="https://i.imgur.com/{{ $video->imgur }}m.png" width="100%" height="100%">
	</a>

	<div style="position: relative; height: 50px;">
	    <span style="position: absolute; top:-28px; right: 6px; background-color: rgba(0,0,0,0.8); color: white; padding: 1px 5px 1px 5px; font-size: 0.85em; border-radius: 2px; opacity: 0.9">{{ $video->duration() }}</span>
	    <div>
	        <a href="{{ route('video.trending') }}?v={{ $video->id }}">
	          <h4 style="margin-top: 5px; font-weight: 500; line-height: 19px; font-size: 1em;overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $video->title }}</h4>
	        </a>

	        <p style="color: gray; margin-top: -7px; margin-bottom: 0px; font-size: 0.85em;">
	        	<i style="vertical-align:middle; font-size: 1.2em; margin-top: -2.5px;" class="material-icons">remove_red_eye</i>
	        	{{ $video->views() }}次 • {{ Carbon\Carbon::parse($video->created_at)->format('Y-m-d') }}
	        </p>
	    </div>
	</div>​
</div>