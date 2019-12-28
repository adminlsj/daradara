<div class="col-xs-6 col-sm-6 col-md-3" style="padding-left:7.5px; padding-right:7.5px;">
	<a href="{{ route('video.watch') }}?v={{ $video->id }}">
	  <img style="border-radius: 5px; width: 100%; height: 100%;" src="{{ $video->imgurM() }}" alt="{{ $video->title }}">
	</a>

	<div style="position: relative; height: 50px;">
	    <span style="position: absolute; top:-28px; right: 6px; background-color: rgba(0,0,0,0.8); color: white; padding: 1px 5px 1px 5px; font-size: 0.85em; border-radius: 2px; opacity: 0.9">{{ $video->duration() }}</span>
	    <div>
	        <a style="color: #323232; text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video->id }}">
	          <h4 style="margin-top: 5px; font-weight: 500; line-height: 19px; font-size: 1em;overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $video->title }}</h4>
	        </a>

	        <p style="color: #a9a9a9; margin-top: -7px; margin-bottom: 0px; font-size: 0.8em;">
	        	<i style="vertical-align:middle; font-size: 1.15em; margin-top: -2.5px;" class="material-icons">remove_red_eye</i>
	        	{{ $video->views() }}次 • {{ Carbon\Carbon::parse($video->created_at)->format('Y-m-d') }}
	        </p>
	    </div>
	</div>​
</div>