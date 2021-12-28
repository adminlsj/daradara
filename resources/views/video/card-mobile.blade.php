<div class="related-watch-wrap hover-lighter" style="padding-top: 0px; padding-bottom: 0px; margin-bottom: -5px;">
	<a href="{{ route('video.watch') }}?v={{ $video->id }}" class="row no-gutter">
	  <div style="padding-right: 0px; width: 160px; max-width: 50%; position: relative;" class="col-xs-6 col-sm-6 col-md-6">
	    <img class="lazy" style="width: 100%; height: 100%;" src="https://cdn.jsdelivr.net/gh/guaishushukanlifan/Project-H@latest/asset/thumbnail/WENZTSJl.jpg" data-src="{{ $video->thumbL() }}" data-srcset="{{ $video->thumbL() }}" alt="{{ $video->title }}">
	    @if ($video->duration != null)
		    <div style="position: absolute; right: 4px; bottom: 4px; color: white; background-color: rgba(0, 0, 0, 0.75); font-size: 10px; font-weight: 400; padding: 0px 3px; border-radius: 2px; z-index: 1">
		    	{{ $video->duration >= 3600 ? gmdate('H:i:s', $video->duration) : gmdate('i:s', $video->duration) }}
		    </div>
	    @endif
	  </div>
	  <div style="width: calc(100% - 160px); min-width: 50%; max-height: 90px;" class="col-xs-6 col-sm-6 col-md-6 related-watch-title">
	    <h4 style="font-weight: 600; color: white; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $video->title }}</h4>
	    <p style="color: #bdbdbd; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; font-size: 0.89em; margin-top: 6px; margin-bottom: 0px; font-weight: 400 !important;">{{ $video->user->name }}</p>
	    <p style="color: #bdbdbd; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; font-size: 0.89em; margin-top: 1px; margin-bottom: 0px; font-weight: 400 !important;">觀看次數：{{ $video->views() }}次 · {{ Carbon\Carbon::parse($video->created_at)->diffForHumans() }}</p>
	  </div>
	</a>
</div>