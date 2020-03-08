<div class="col-xs-6 col-sm-6 col-md-3" style="padding-left:5px; padding-right:5px; margin-bottom: 10px;">
	<div style="background-color: white; border-radius: 3px; box-shadow: 0 1px 3px rgba(0,0,0,0.05)">
		<a href="{{ route('video.watch') }}?v={{ $video->id }}">
			<img class="lazy" style="border-top-left-radius: 3px; border-top-right-radius: 3px; width: 100%; height: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">
		</a>

		<div style="position: relative; height: 47px; padding: 0px 8px;">
		    <span style="position: absolute; top:-28px; right: 6px; background-color: rgba(0,0,0,0.8); color: white; padding: 0px 5px 1px 5px; font-size: 0.85em; border-radius: 2px; opacity: 0.9; font-weight: 500">{{ $video->duration() }}</span>
		    <div>
		        <a style="color: #323232; text-decoration: none;" href="{{ route('video.watch') }}?v={{ $video->id }}">
		          <h4 style="margin-top: 5px; font-weight: 400; line-height: 19px; font-size: 1em;overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $video->title }}</h4>
		        </a>

		        <p style="color: #a9a9a9; margin-top: -5px; margin-bottom: 2px; font-size: 0.8em;">
		        	<i style="vertical-align:middle; font-size: 1.15em; margin-top: -2px; margin-right: -1px;" class="material-icons">play_circle_filled</i>
		        	{{ $video->views() }} • {{ $video->genre() }} • {{ Carbon\Carbon::parse($video->uploaded_at)->diffForHumans() }}
		        </p>
		    </div>
		</div>​
	</div>
</div>