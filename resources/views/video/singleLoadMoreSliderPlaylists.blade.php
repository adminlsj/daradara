<div class="col-xs-6 col-sm-3 col-md-3 hover-opacity-all load-more-wrapper">
    <div style="position: relative;">
	    <a href="{{ route('video.watch') }}?v={{ $video->id }}">
	      <img class="lazy" style="width: 100%; height: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">
	      <div style="position: absolute; bottom: 0px; width: 100%;padding: 8px 10px; font-size: 1.0em; color: white; background: linear-gradient(to bottom, transparent 0%, black 120%);">
	        <div style="font-size: 0.8em; font-weight: bold;">{{ $video->watch()->videos()->count() }} 部影片</div>
	        <div style="margin-top: 1px; font-weight: bold;">{{ $video->watch()->title }}</div>
	      </div>
	    </a>
	</div>
</div>