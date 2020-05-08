<div class="col-xs-6 col-sm-3 col-md-3 hover-opacity-all load-more-wrapper">
    <div style="position: relative;">
	    <a href="{{ route('video.watch') }}?v={{ $video->id }}">
	      <img class="lazy" style="width: 100%; height: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">
	      <div class="single-load-more-video-wrapper">
	        <div class="hidden-xs hidden-sm" style="font-size: 0.8em; font-weight: bold;">{{ $video->user()->name }}</div>
	        <div style="margin-top: 1px; font-weight: bold; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $video->title }}</div>
	      </div>
	    </a>
	</div>
</div>