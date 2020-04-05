<div class="col-xs-6 col-sm-3 col-md-2 hover-opacity load-more-wrapper">
    <a style="text-decoration: none; color: black" class="overlay" href="{{ route('video.watch') }}?v={{ $video->id }}">
		<img class="lazy" style="width: 100%; height: 100%;" src="{{ $video->imgur16by9() }}" data-src="{{ $video->imgurL() }}" data-srcset="{{ $video->imgurL() }}" alt="{{ $video->title }}">

		<div class="hover-underline">
		    <h4 style="font-size: 0.95em; margin-top: 7px; color: #222222;" class="text-ellipsis">@if ($video->category != 'video'){{ $video->watch()->title }}@endif {{ $video->explodeTitle() }}</h4>
		</div>
    </a>
</div>