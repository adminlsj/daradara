<div class="col-xs-6 col-sm-3 col-md-3 hover-opacity-all load-more-wrapper multiple-link-wrapper" style="margin-bottom: 9px;">
	<a style="color: inherit" href="{{ route('video.watch') }}?v={{ $video->id }}" class="overlay"></a>
    <div style="position: relative;" class="inner">
        <img class="lazy" style="width: 100%; height: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">
	    <div style="background-color: #e8eaed; padding: 6px 9px; height: 73px">
		    <div style="font-weight: bold; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">{{ $video->title }}</div>
		    <a target="_blank" href="{{ $video->sd }}" style="color: darkgray;">{{ str_ireplace('www.', '', parse_url($video->sd, PHP_URL_HOST)) }}</a>
		</div>
	</div>
</div>