<div class="col-xs-6 col-sm-3 col-md-3 hover-opacity-all load-more-wrapper" style="margin-bottom: 9px">
    <div style="position: relative;">
	    <a href="{{ route('video.playlist') }}?list={{ $watch->id }}">
	      <img class="lazy" style="width: 100%; height: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">
	      <div class="single-load-more-video-wrapper">
	        <div style="font-size: 0.8em; font-weight: bold;">{{ $watch->videos->count() }} 部影片</div>
	        <div style="margin-top: 1px; font-weight: bold; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $watch->title }}</div>
	      </div>
	    </a>
	</div>
</div>